<?php include 'header.php'?>
<?php
/*
 * Halaman diagnosis notifikasi email.
 * Menunjukkan cara kirim yang aktif (SMTP / mail()), lalu mengirim email uji
 * ke alamat penerima notifikasi rekomendasi dan menampilkan hasil + transkrip
 * SMTP (password otomatis disembunyikan PHPMailer).
 */
require_once __DIR__ . '/../rekomendasi_notifikasi.php';

$e = function ($t) { return htmlspecialchars((string) $t, ENT_QUOTES, 'UTF-8'); };

// Token CSRF: tombol kirim hanya sah dari halaman ini sendiri
if (empty($_SESSION['tes_email_token'])) {
    $_SESSION['tes_email_token'] = bin2hex(random_bytes(16));
}

$config      = konfigurasi_email();
$pakaiSmtp   = smtp_siap($config);
$mailAktif   = fungsi_mail_tersedia();
$hasil       = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && hash_equals($_SESSION['tes_email_token'], (string) ($_POST['token'] ?? ''))) {
    $waktu = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('d-m-Y H:i:s');
    $ok = kirim_email(
        REKOMENDASI_NOTIF_KE,
        'Tes email website Yayasan Kolibri (' . $waktu . ')',
        "Ini email uji dari halaman Admin > Tes Email.\n\nKalau email ini sampai, notifikasi rekomendasi juga akan sampai.\n\nDikirim: {$waktu} WIB",
        $error,
        true,
        $log,
        $metode
    );
    $hasil = ['ok' => $ok, 'error' => $error, 'log' => $log, 'metode' => $metode];
}
?>
    <div class="content">
        <div class="container">
            <div class="box">
                <div class="box-header">
                    Tes Email Notifikasi
                </div>
                <div class="box-body">

                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 35%">Penerima notifikasi</td>
                                <td><?= $e(REKOMENDASI_NOTIF_KE) ?></td>
                            </tr>
                            <tr>
                                <td>Cara kirim yang dipakai</td>
                                <td>
                                    <?php if ($pakaiSmtp): ?>
                                        <strong>SMTP</strong> (<?= $e($config['smtp_user']) ?> lewat <?= $e($config['smtp_host']) ?>:<?= (int) ($config['smtp_port'] ?? 465) ?>)
                                    <?php else: ?>
                                        <strong>mail() bawaan PHP</strong> &mdash; SMTP belum diatur (file mail_config.php belum ada / belum lengkap)
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Fungsi mail() di server</td>
                                <td><?= $mailAktif ? 'Tersedia' : '<span style="color:#c0392b">Dimatikan oleh hosting</span>' ?></td>
                            </tr>
                            <tr>
                                <td>Versi PHP</td>
                                <td><?= $e(PHP_VERSION) ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if ($hasil !== null): ?>
                        <?php if ($hasil['ok']): ?>
                            <div class="alert alert-success">
                                Email uji <strong>diterima server pengirim</strong> lewat <?= $e($hasil['metode']) ?>.
                                Cek kotak masuk <?= $e(REKOMENDASI_NOTIF_KE) ?> dalam 1&ndash;5 menit, <strong>termasuk folder Spam</strong>.
                                <?php if ($hasil['metode'] === 'mail()'): ?>
                                    <br><br>Catatan: mail() hanya menyerahkan email ke server; Gmail masih bisa menolak atau
                                    memasukkannya ke Spam. Kalau tidak sampai, atur SMTP (lihat panduan di bawah).
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-error">
                                Email uji <strong>gagal dikirim</strong> lewat <?= $e($hasil['metode']) ?>:<br>
                                <?= $e($hasil['error']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (trim((string) $hasil['log']) !== ''): ?>
                            <details style="margin: 10px 0 20px">
                                <summary style="cursor:pointer">Lihat detail percakapan dengan server email (untuk teknisi)</summary>
                                <pre style="white-space: pre-wrap; font-size: 12px; background: #f6f6f6; padding: 12px; border-radius: 6px; max-height: 360px; overflow: auto"><?= $e($hasil['log']) ?></pre>
                            </details>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form method="POST" style="margin: 15px 0 25px">
                        <input type="hidden" name="token" value="<?= $e($_SESSION['tes_email_token']) ?>">
                        <input type="submit" value="Kirim Email Uji" class="btn btn-blue">
                    </form>

                    <?php if (!$pakaiSmtp): ?>
                    <h4 style="margin-bottom: 8px">Cara mengaktifkan SMTP (disarankan)</h4>
                    <ol style="line-height: 1.8; padding-left: 20px">
                        <li>Buka cPanel &gt; <strong>Email Accounts</strong> &gt; Create, buat akun misalnya <code>noreply@yayasankolibri.com</code>.</li>
                        <li>Di File Manager, salin <code>mail_config.example.php</code> menjadi <code>mail_config.php</code> (folder yang sama).</li>
                        <li>Edit <code>mail_config.php</code>, isi password akun email tadi di <code>smtp_pass</code>.</li>
                        <li>Kembali ke halaman ini dan klik <strong>Kirim Email Uji</strong>.</li>
                    </ol>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php'?>
