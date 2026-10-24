<?php
/**
 * CONTOH pengaturan email. Cara pakai:
 *   1. Di cPanel > Email Accounts, buat akun email, misal noreply@yayasankolibri.com
 *   2. Salin file ini menjadi mail_config.php (di folder yang sama)
 *   3. Isi password akun email tersebut di 'smtp_pass'
 *   4. Buka Admin > Tes Email untuk mengecek
 *
 * mail_config.php TIDAK di-commit ke git (berisi password) dan diblokir dari
 * akses publik. Jangan isi password di file contoh ini.
 *
 * Nilai host & port bisa dicek di cPanel > Email Accounts > Connect Devices
 * (bagian "Outgoing Server"). Umumnya: mail.namadomain.com, port 465 (SSL).
 */
return [
    'smtp_host' => 'mail.yayasankolibri.com',
    'smtp_port' => 465,                          // 465 = SSL, 587 = TLS
    'smtp_user' => 'noreply@yayasankolibri.com', // alamat email lengkap = username
    'smtp_pass' => '',                           // ISI di mail_config.php, bukan di sini
    'from_name' => 'Website Yayasan Kolibri',

    // Biarkan true. Ubah ke false HANYA jika Tes Email gagal dengan error sertifikat SSL
    // (misalnya "certificate verify failed") dan host lain dari cPanel juga tidak berhasil.
    'smtp_verify_ssl' => true,
];
