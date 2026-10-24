-- ============================================================
-- Perbesar kolom teks konten supaya judul & keterangan bisa deskriptif.
-- Jalankan SEKALI lewat phpMyAdmin (tab SQL) di database production.
--
-- AMAN: MODIFY hanya MEMPERBESAR batas panjang. Data yang sudah ada
-- tidak diubah, tidak dipotong, dan tidak dihapus. Kalau tidak sengaja
-- dijalankan dua kali pun tidak masalah.
--
--   berita.judul      : 25  -> 150 karakter (judul artikel untuk SEO)
--   foto.keterangan   : 25  -> 255 karakter (jadi teks alt foto di Google)
--   video.keterangan  : 100 -> 255 karakter
-- ============================================================

ALTER TABLE `berita` MODIFY `judul` VARCHAR(150) NOT NULL;
ALTER TABLE `foto`   MODIFY `keterangan` VARCHAR(255) NOT NULL;
ALTER TABLE `video`  MODIFY `keterangan` VARCHAR(255) NOT NULL;
