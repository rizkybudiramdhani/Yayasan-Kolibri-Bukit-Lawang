-- ============================================================
-- Tabel untuk fitur Rekomendasi & statistik pengunjung.
-- Jalankan lewat phpMyAdmin (tab SQL) di database production.
--
-- AMAN dijalankan walaupun tabel sudah ada: "IF NOT EXISTS" membuat
-- perintah dilewati, data lama tidak disentuh.
--
-- Kalau tabel rekomendasi SUDAH ADA, pastikan kolomnya lengkap dengan:
--     SHOW COLUMNS FROM rekomendasi;
-- Kolom wajib: id, nama, foto, isi, status, ip_address, created_at
-- ============================================================

CREATE TABLE IF NOT EXISTS `rekomendasi` (
    `id`         INT(11)      NOT NULL AUTO_INCREMENT,
    `nama`       VARCHAR(50)  NOT NULL,
    `foto`       VARCHAR(255) NULL DEFAULT NULL,
    `isi`        TEXT         NOT NULL,
    `status`     ENUM('pending','approved') NOT NULL DEFAULT 'pending',
    `ip_address` VARCHAR(45)  NULL DEFAULT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_status` (`status`),
    KEY `idx_ip_waktu` (`ip_address`, `created_at`)  -- mempercepat cek batas 3 kiriman/jam
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `page_visits` (
    `id`         INT(11)     NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(45) NOT NULL,
    `url`        TEXT        NOT NULL,
    `visited_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_visited_at` (`visited_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
