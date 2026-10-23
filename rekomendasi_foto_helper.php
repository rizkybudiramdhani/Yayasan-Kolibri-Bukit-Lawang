<?php

const REKOMENDASI_FOTO_MAX_BYTES = 2 * 1024 * 1024;
// Batas resolusi sebelum di-decode: PNG 2MB bisa berisi 20000x20000 piksel (~1.6GB RAM saat di-decode GD).
const REKOMENDASI_FOTO_MAX_PIXELS = 25000000;
const REKOMENDASI_FOTO_MAX_DIM = 400;

/**
 * Validasi, resize (maks 400x400, mempertahankan rasio), dan simpan foto rekomendasi.
 * Dipakai bersama oleh form publik (t_rekomendasi.php) & admin (tambah/edit-rekomendasi.php).
 * Gambar selalu di-encode ulang lewat GD, jadi isi file asli (termasuk kode tersisip) tidak pernah tersimpan.
 *
 * @return array{filename: ?string, error: ?string}
 */
function simpan_foto_rekomendasi(array $file, string $uploadDir): array
{
    if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['filename' => null, 'error' => null];
    }

    // Kiriman berbentuk array (gambar[]=...) atau field yang dimanipulasi ditolak sebelum diproses.
    if (!is_string($file['name']) || !is_string($file['tmp_name'] ?? null) || !is_int($file['error'] ?? null) || !is_int($file['size'] ?? null)) {
        return ['filename' => null, 'error' => 'Upload gagal, silakan coba lagi'];
    }

    $error = $file['error'] ?? UPLOAD_ERR_OK;
    if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
        return ['filename' => null, 'error' => 'Ukuran file tidak boleh lebih dari 2MB'];
    }
    if ($error !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'] ?? '')) {
        return ['filename' => null, 'error' => 'Upload gagal, silakan coba lagi'];
    }

    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, ['png', 'jpg', 'jpeg', 'gif'], true)) {
        return ['filename' => null, 'error' => 'Format file tidak diizinkan (hanya JPG/PNG/GIF)'];
    }

    if ($file['size'] > REKOMENDASI_FOTO_MAX_BYTES) {
        return ['filename' => null, 'error' => 'Ukuran file tidak boleh lebih dari 2MB'];
    }

    // Jenis gambar ditentukan dari isi file, bukan dari nama file kiriman browser.
    $info = @getimagesize($file['tmp_name']);
    $tipeDiizinkan = [IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif'];
    if ($info === false || !isset($tipeDiizinkan[$info[2]])) {
        return ['filename' => null, 'error' => 'File gambar tidak valid atau rusak'];
    }

    [$width, $height] = $info;
    if ($width < 1 || $height < 1 || $width * $height > REKOMENDASI_FOTO_MAX_PIXELS) {
        return ['filename' => null, 'error' => 'Resolusi gambar terlalu besar'];
    }

    $extOut = $tipeDiizinkan[$info[2]];
    switch ($extOut) {
        case 'png':
            $sourceImage = @imagecreatefrompng($file['tmp_name']);
            break;
        case 'gif':
            $sourceImage = @imagecreatefromgif($file['tmp_name']);
            break;
        default:
            $sourceImage = @imagecreatefromjpeg($file['tmp_name']);
    }

    if (!$sourceImage) {
        return ['filename' => null, 'error' => 'File gambar tidak valid atau rusak'];
    }

    $ratio = min(1, REKOMENDASI_FOTO_MAX_DIM / $width, REKOMENDASI_FOTO_MAX_DIM / $height);
    $newWidth = max(1, (int) round($width * $ratio));
    $newHeight = max(1, (int) round($height * $ratio));

    $resized = imagecreatetruecolor($newWidth, $newHeight);
    if ($extOut !== 'jpg') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
    }
    imagecopyresampled($resized, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagedestroy($sourceImage);

    $filename = 'rekomendasi' . bin2hex(random_bytes(12)) . '.' . $extOut;
    $fullPath = rtrim($uploadDir, '/\\') . '/' . $filename;

    if ($extOut === 'png') {
        $tersimpan = imagepng($resized, $fullPath, 8);
    } elseif ($extOut === 'gif') {
        $tersimpan = imagegif($resized, $fullPath);
    } else {
        $tersimpan = imagejpeg($resized, $fullPath, 85);
    }
    imagedestroy($resized);

    if (!$tersimpan) {
        return ['filename' => null, 'error' => 'Foto gagal disimpan di server'];
    }

    return ['filename' => $filename, 'error' => null];
}

/** Nama file foto rekomendasi yang sah (hasil helper di atas atau data lama); mencegah path traversal saat unlink. */
function nama_foto_rekomendasi_valid(?string $nama): bool
{
    return $nama !== null && preg_match('/^rekomendasi[a-zA-Z0-9]+\.(png|jpg|jpeg|gif)$/', $nama) === 1;
}
