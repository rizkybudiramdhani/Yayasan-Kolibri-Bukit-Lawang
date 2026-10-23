-- ============================================================
-- Migrasi: perbesar kolom password agar bisa menampung hash bcrypt
-- Jalankan SEKALI lewat phpMyAdmin (tab SQL) di database production.
--
-- Aman dijalankan: password lama (plaintext) TIDAK hilang. Setelah ini,
-- setiap admin yang login akan otomatis di-upgrade ke hash oleh login.php.
-- ============================================================

ALTER TABLE `pengguna`
    MODIFY `password` VARCHAR(255) NOT NULL;
