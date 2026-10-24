<?php
/**
 * Pengiriman email website.
 *
 * Urutan cara kirim:
 *   1. SMTP terautentikasi (kalau mail_config.php sudah diisi)  <- disarankan
 *   2. Fungsi mail() bawaan PHP (cadangan)
 *
 * Kenapa SMTP: email dari mail() tidak login ke server email, jadi biasanya
 * tidak ditandatangani DKIM. Sejak 2024 Gmail menolak / memasukkan ke Spam email
 * seperti itu. Lewat SMTP dengan akun email domain sendiri (dibuat di cPanel),
 * email ditandatangani server dan jauh lebih dipercaya Gmail. Beberapa hosting
 * juga mematikan mail() sama sekali.
 */

require_once __DIR__ . '/lib/phpmailer/Exception.php';
require_once __DIR__ . '/lib/phpmailer/PHPMailer.php';
require_once __DIR__ . '/lib/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

/** Pengaturan SMTP dari mail_config.php (file ini tidak di-commit karena berisi password). */
function konfigurasi_email(): array
{
    $file = __DIR__ . '/mail_config.php';
    $config = is_file($file) ? include $file : [];
    return is_array($config) ? $config : [];
}

/** True kalau SMTP sudah diisi lengkap. */
function smtp_siap(array $config): bool
{
    return !empty($config['smtp_host']) && !empty($config['smtp_user']) && !empty($config['smtp_pass']);
}

/** True kalau fungsi mail() tersedia (tidak dimatikan hosting lewat disable_functions). */
function fungsi_mail_tersedia(): bool
{
    $dimatikan = array_map('trim', explode(',', (string) ini_get('disable_functions')));
    return function_exists('mail') && !in_array('mail', $dimatikan, true);
}

/**
 * Kirim email teks biasa.
 *
 * @param string      $ke      Alamat tujuan
 * @param string      $subjek  Subjek (boleh ada huruf non-ASCII)
 * @param string      $isi     Isi email (teks biasa)
 * @param string|null $error   Diisi pesan error kalau gagal
 * @param string|null $log     Diisi transkrip SMTP (password otomatis disembunyikan) jika $debug
 * @param string|null $metode  Diisi 'smtp' atau 'mail()'
 */
function kirim_email(string $ke, string $subjek, string $isi, ?string &$error = null, bool $debug = false, ?string &$log = null, ?string &$metode = null): bool
{
    $config = konfigurasi_email();
    $error  = null;
    $log    = '';
    $namaPengirim = $config['from_name'] ?? 'Website Yayasan Kolibri';

    if (smtp_siap($config)) {
        $metode = 'smtp';
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host     = $config['smtp_host'];
            $mail->Port     = (int) ($config['smtp_port'] ?? 465);
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp_user'];
            $mail->Password = $config['smtp_pass'];
            // Default dari port: 465 = SSL langsung, selain itu (587) = STARTTLS.
            // Bisa dipaksa lewat 'smtp_secure' => 'ssl' / 'tls' kalau hosting memakai port lain.
            $secure = $config['smtp_secure'] ?? ($mail->Port === 465 ? 'ssl' : 'tls');
            $mail->SMTPSecure = $secure === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Timeout  = 20;

            // Opsi cadangan: kalau sertifikat SSL mail.domain belum valid (mis. AutoSSL belum mencakupnya),
            // verifikasi bisa dimatikan lewat 'smtp_verify_ssl' => false. Lebih baik pakai host yang
            // sertifikatnya valid (lihat cPanel > Connect Devices); ini hanya jalan terakhir.
            if (($config['smtp_verify_ssl'] ?? true) === false) {
                $mail->SMTPOptions = ['ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ]];
            }
            $mail->CharSet  = PHPMailer::CHARSET_UTF8;

            if ($debug) {
                $mail->SMTPDebug   = 3; // level 3: percakapan + detail koneksi/SSL; password tetap disembunyikan (baru tampil di level 4)
                $mail->Debugoutput = function ($baris) use (&$log) { $log .= rtrim($baris) . "\n"; };
            }

            // Pengirim WAJIB sama dengan akun yang login, supaya tidak ditolak & lolos cek DMARC Gmail
            $mail->setFrom($config['smtp_user'], $namaPengirim);
            $mail->addAddress($ke);
            $mail->Subject = $subjek;
            $mail->Body    = $isi;
            $mail->isHTML(false);

            $mail->send();
            return true;
        } catch (Throwable $e) {
            $error = $mail->ErrorInfo ?: $e->getMessage();
            error_log('Email SMTP gagal ke ' . $ke . ': ' . $error);
            return false;
        }
    }

    // ---- Cadangan: mail() bawaan PHP ----
    $metode = 'mail()';
    if (!fungsi_mail_tersedia()) {
        $error = 'Fungsi mail() dimatikan oleh hosting dan SMTP belum diatur di mail_config.php';
        error_log('Email gagal ke ' . $ke . ': ' . $error);
        return false;
    }

    $dari = $config['from_email'] ?? 'noreply@yayasankolibri.com';
    $headers = implode("\r\n", [
        'From: ' . $namaPengirim . ' <' . $dari . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
    ]);
    $subjekEncoded = '=?UTF-8?B?' . base64_encode($subjek) . '?=';
    // Baris email maks. 998 karakter (RFC 5322)
    $isi = wordwrap(str_replace("\r\n", "\n", $isi), 900, "\n", true);

    $terkirim = @mail($ke, $subjekEncoded, $isi, $headers, '-f' . $dari);
    if (!$terkirim) {
        $errTerakhir = error_get_last();
        $error = 'mail() ditolak server' . ($errTerakhir ? ': ' . $errTerakhir['message'] : '');
        error_log('Email mail() gagal ke ' . $ke . ': ' . $error);
    }
    return $terkirim;
}
