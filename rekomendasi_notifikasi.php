<?php

// Ganti alamat penerima di sini kalau notifikasi ingin dikirim ke email lain.
const REKOMENDASI_NOTIF_KE = 'yusufsihotang70@gmail.com';
// Pengirim memakai domain website sendiri supaya tidak ditolak/masuk spam oleh Gmail.
const REKOMENDASI_NOTIF_DARI = 'noreply@yayasankolibri.com';
const REKOMENDASI_ADMIN_URL = 'https://yayasankolibri.com/admin/rekomendasi.php';

function kirim_notifikasi_rekomendasi(string $nama, string $isi, bool $adaFoto): bool
{
    $waktu = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('d-m-Y H:i') . ' WIB';

    $isiPesan = "Ada rekomendasi baru dari pengunjung website Yayasan Kolibri.\n"
        . "Rekomendasi ini BELUM tampil di halaman depan sampai disetujui admin.\n\n"
        . "Nama  : {$nama}\n"
        . 'Foto  : ' . ($adaFoto ? 'Ada' : 'Tidak ada') . "\n"
        . "Waktu : {$waktu}\n\n"
        . "Isi rekomendasi:\n"
        . "----------------------------------------\n"
        . $isi . "\n"
        . "----------------------------------------\n\n"
        . "Setujui atau hapus di halaman admin:\n"
        . REKOMENDASI_ADMIN_URL . "\n";

    // Baris email maksimal 998 karakter (RFC 5322); isi panjang tanpa enter dipecah supaya tidak rusak di jalan.
    $isiPesan = wordwrap(str_replace("\r\n", "\n", $isiPesan), 900, "\n", true);

    $headers = implode("\r\n", [
        'From: Website Yayasan Kolibri <' . REKOMENDASI_NOTIF_DARI . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
    ]);

    $subjek = '=?UTF-8?B?' . base64_encode('Rekomendasi baru dari ' . $nama . ' menunggu persetujuan') . '?=';

    $terkirim = @mail(REKOMENDASI_NOTIF_KE, $subjek, $isiPesan, $headers, '-f' . REKOMENDASI_NOTIF_DARI);
    if (!$terkirim) {
        error_log('Notifikasi rekomendasi gagal dikirim ke ' . REKOMENDASI_NOTIF_KE);
    }
    return $terkirim;
}
