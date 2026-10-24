<?php
require_once __DIR__ . '/mail_helper.php';

// Ganti alamat penerima di sini kalau notifikasi ingin dikirim ke email lain.
if (!defined('REKOMENDASI_NOTIF_KE'))   define('REKOMENDASI_NOTIF_KE', 'yusufsihotang70@gmail.com');
if (!defined('REKOMENDASI_ADMIN_URL'))  define('REKOMENDASI_ADMIN_URL', 'https://yayasankolibri.com/admin/rekomendasi.php');

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

    $subjek = 'Rekomendasi baru dari ' . $nama . ' menunggu persetujuan';

    // Kegagalan kirim dicatat ke error_log oleh kirim_email(); rekomendasi tetap tersimpan.
    return kirim_email(REKOMENDASI_NOTIF_KE, $subjek, $isiPesan);
}
