<?php
/**
 * Helper password untuk login & manajemen pengguna.
 *
 * Kenapa ada mode "legacy"?
 * Kolom `pengguna.password` di database lama cuma VARCHAR(25), sedangkan hasil
 * password_hash() panjangnya 60 karakter (bcrypt). Kalau hash langsung disimpan
 * ke kolom 25 karakter, MySQL akan memotongnya / menolak, dan admin TIDAK BISA
 * LOGIN lagi. Jadi helper ini mengecek ukuran kolom dulu:
 *   - kolom >= 255  → simpan sebagai hash (aman)
 *   - kolom < 255   → tetap simpan plaintext seperti sebelumnya (tidak merusak),
 *                     sampai migrasi sql/migrasi-password.sql dijalankan.
 * Login mendukung keduanya, dan otomatis meng-upgrade password lama ke hash
 * saat admin login pertama kali setelah migrasi.
 */

function kolom_password_siap(mysqli $conn): bool
{
    static $siap = null;
    if ($siap !== null) {
        return $siap;
    }

    $hasil = mysqli_query(
        $conn,
        "SELECT CHARACTER_MAXIMUM_LENGTH AS panjang
           FROM information_schema.COLUMNS
          WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'pengguna'
            AND COLUMN_NAME = 'password'"
    );
    $baris = $hasil ? mysqli_fetch_assoc($hasil) : null;
    $siap  = $baris !== null && (int) $baris['panjang'] >= 255;

    return $siap;
}

/** True kalau string tersimpan adalah hasil password_hash(), bukan plaintext. */
function password_sudah_di_hash(string $tersimpan): bool
{
    // PHP >= 7.4 mengembalikan null untuk non-hash, PHP lama mengembalikan 0
    return !empty(password_get_info($tersimpan)['algo']);
}

/** Cocokkan password input dengan yang tersimpan (hash ATAU plaintext lama). */
function verifikasi_password(string $input, string $tersimpan): bool
{
    if (password_sudah_di_hash($tersimpan)) {
        return password_verify($input, $tersimpan);
    }
    // hash_equals mencegah timing attack pada perbandingan string biasa
    return hash_equals($tersimpan, $input);
}

/** Nilai yang disimpan ke kolom password: hash kalau kolom sudah siap. */
function siapkan_password_untuk_disimpan(mysqli $conn, string $plain): string
{
    return kolom_password_siap($conn) ? password_hash($plain, PASSWORD_DEFAULT) : $plain;
}
