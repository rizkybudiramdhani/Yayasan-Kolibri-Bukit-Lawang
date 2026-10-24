<?php
require_once __DIR__ . '/../rekomendasi_foto_helper.php';
require_once __DIR__ . '/../rekomendasi_notifikasi.php';

const REKOMENDASI_MAKS_PER_JAM = 3;
// Manusia butuh lebih dari beberapa detik untuk mengisi nama + cerita; bot mengirim seketika.
const REKOMENDASI_MIN_DETIK_ISI = 3;

$rekomendasi_sukses_kirim = false;
$rekomendasi_error_foto = null;
$rekomendasi_error_kirim = null;

if (isset($_POST['kirim_rekomendasi'])) {
    $tokenKiriman = $_POST['rek_token'] ?? null;
    $tokenValid = is_string($tokenKiriman)
        && is_string($_SESSION['rek_token'] ?? null)
        && hash_equals($_SESSION['rek_token'], $tokenKiriman);
    // Dihitung dari awal request ini (bukan time()) supaya lama render halaman di server tidak ikut terhitung.
    $terlaluCepat = $_SERVER['REQUEST_TIME_FLOAT'] - (float) ($_SESSION['rek_form_time'] ?? 0) < REKOMENDASI_MIN_DETIK_ISI;
    $ip = substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 45);
    $nama = is_string($_POST['nama'] ?? null) ? mb_substr(trim($_POST['nama']), 0, 50) : '';
    // Kolom isi bertipe TEXT (maks 65535 byte); dipotong per byte supaya tidak gagal insert diam-diam.
    $isi = is_string($_POST['isi'] ?? null) ? mb_strcut(trim($_POST['isi']), 0, 65535) : '';

    // Token yang barusan sukses dikirim ulang = pengunjung me-refresh halaman setelah berhasil.
    // Dulu kasus ini memunculkan error "Halaman sudah terlalu lama dibuka" padahal kirimannya sudah masuk.
    $kirimUlangSetelahSukses = is_string($tokenKiriman)
        && is_string($_SESSION['rek_token_terkirim'] ?? null)
        && hash_equals($_SESSION['rek_token_terkirim'], $tokenKiriman);

    if (!empty($_POST['website']) || ($tokenValid && $terlaluCepat)) {
        // Bot (honeypot terisi / terlalu cepat): pura-pura sukses supaya bot tidak belajar, tapi tidak disimpan.
        $rekomendasi_sukses_kirim = true;
    } elseif ($kirimUlangSetelahSukses) {
        $rekomendasi_sukses_kirim = true; // tampilkan lagi pesan sukses, tanpa menyimpan dobel
    } elseif (!$tokenValid) {
        $rekomendasi_error_kirim = $language['rekomendasi_gagal_form'];
    } elseif ($nama === '' || $isi === '') {
        // Dulu gagal diam-diam (form muncul lagi tanpa pesan) jika nama/isi hanya berisi spasi
        $rekomendasi_error_kirim = $language['rekomendasi_gagal_isi'];
    } else {
        $foto = null;
        try {
            $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM rekomendasi WHERE ip_address = ? AND created_at > NOW() - INTERVAL 1 HOUR");
            if (!$stmt) {
                throw new RuntimeException(mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, 's', $ip);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $jumlahSejam);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($jumlahSejam >= REKOMENDASI_MAKS_PER_JAM) {
                $rekomendasi_error_kirim = $language['rekomendasi_gagal_batas'];
            } else {
                $hasilFoto = simpan_foto_rekomendasi($_FILES['gambar'] ?? [], __DIR__ . '/../img/rekomendasi');
                $foto = $hasilFoto['filename'];
                $rekomendasi_error_foto = $hasilFoto['error'];

                $stmt = mysqli_prepare($conn, "INSERT INTO rekomendasi (nama, foto, isi, status, ip_address) VALUES (?, ?, ?, 'pending', ?)");
                if (!$stmt) {
                    throw new RuntimeException(mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt, 'ssss', $nama, $foto, $isi, $ip);
                $tersimpan = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                if (!$tersimpan) {
                    throw new RuntimeException(mysqli_error($conn));
                }

                kirim_notifikasi_rekomendasi($nama, $isi, $foto !== null);
                $_SESSION['rek_token_terkirim'] = $_SESSION['rek_token'];
                unset($_SESSION['rek_token']);
                $rekomendasi_sukses_kirim = true;
            }
        } catch (Throwable $err) {
            // Dulu error database (mis. kolom belum ada) membuat beranda berhenti di tengah (fatal error).
            // Sekarang: catat ke error_log, tampilkan pesan ramah, dan buang foto yang terlanjur tersimpan.
            error_log('Rekomendasi gagal disimpan: ' . $err->getMessage());
            if ($foto !== null && nama_foto_rekomendasi_valid($foto)) {
                @unlink(__DIR__ . '/../img/rekomendasi/' . $foto);
            }
            $rekomendasi_error_foto = null;
            $rekomendasi_error_kirim = $language['rekomendasi_gagal_sistem'];
        }
    }
}

if (!is_string($_SESSION['rek_token'] ?? null)) {
    $_SESSION['rek_token'] = bin2hex(random_bytes(16));
}
$_SESSION['rek_form_time'] = microtime(true);

try {
    $Rekomendasi = mysqli_query($conn, "SELECT * FROM rekomendasi WHERE status = 'approved' ORDER BY id DESC");
} catch (Throwable $err) {
    // Tabel bermasalah tidak boleh membuat seluruh beranda error; section cukup tampil tanpa daftar
    error_log('Rekomendasi gagal dibaca: ' . $err->getMessage());
    $Rekomendasi = false;
}
$jumlah_rekomendasi = $Rekomendasi ? mysqli_num_rows($Rekomendasi) : 0;
?>

<div class="rekomendasi py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <p><?= $language["rekomendasi"] ?></p>
            <h2><?= $language["rekomendasi2"] ?></h2>
        </div>

        <?php if ($jumlah_rekomendasi > 0): ?>
        <div class="owl-carousel rekomendasi-carousel">
            <?php while ($r = mysqli_fetch_object($Rekomendasi)): ?>
                <div class="rekomendasi-item card-style p-4">
                    <div class="text-center">
                        <?php if (!empty($r->foto)): ?>
                            <img src="img/rekomendasi/<?= htmlspecialchars($r->foto) ?>" alt="<?= htmlspecialchars($r->nama) ?>" class="rekomendasi-photo mb-3">
                        <?php else: ?>
                            <div class="rekomendasi-avatar mb-3">
                                <?= htmlspecialchars(mb_strtoupper(mb_substr($r->nama, 0, 1))) ?>
                            </div>
                        <?php endif; ?>
                        <i class="fa fa-quote-left rekomendasi-quote-icon"></i>
                        <p class="rekomendasi-text"><?= nl2br(htmlspecialchars($r->isi)) ?></p>
                        <h3 class="rekomendasi-nama mb-0"><?= htmlspecialchars($r->nama) ?></h3>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <div class="rekomendasi-form-wrap">
            <?php if ($rekomendasi_sukses_kirim): ?>
                <div class="rekomendasi-alert-sukses">
                    <i class="fa fa-check-circle"></i>
                    <?= $language['rekomendasi_sukses'] ?>
                </div>
                <?php if (!empty($rekomendasi_error_foto)): ?>
                    <div class="rekomendasi-alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <?= $language['rekomendasi_foto_gagal'] ?>: <?= htmlspecialchars($rekomendasi_error_foto) ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <h3 class="rekomendasi-form-title"><?= $language['rekomendasi_form_judul'] ?></h3>
                <p class="rekomendasi-form-sub"><?= $language['rekomendasi_form_sub'] ?></p>

                <?php if ($rekomendasi_error_kirim !== null): ?>
                    <div class="rekomendasi-alert-warning rekomendasi-alert-kirim">
                        <i class="fa fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($rekomendasi_error_kirim) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="rekomendasi-form" id="formRekomendasi">
                    <input type="hidden" name="rek_token" value="<?= htmlspecialchars($_SESSION['rek_token']) ?>">
                    <input type="text" name="website" class="rekomendasi-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

                    <div class="rekomendasi-form-row">
                        <input type="text" name="nama" placeholder="<?= $language['rekomendasi_nama_placeholder'] ?>" required maxlength="50" value="<?= htmlspecialchars($nama ?? '') ?>">
                        <div class="rekomendasi-file-field">
                            <input type="file" name="gambar" id="rekomendasiFoto" accept="image/png,image/jpeg,image/gif">
                            <small class="rekomendasi-foto-hint"><?= $language['rekomendasi_foto_hint'] ?></small>
                            <small class="rekomendasi-foto-warning" id="rekomendasiFotoWarning" hidden></small>
                        </div>
                    </div>
                    <textarea name="isi" placeholder="<?= $language['rekomendasi_isi_placeholder'] ?>" required rows="4"><?= htmlspecialchars($isi ?? '') ?></textarea>
                    <button type="submit" name="kirim_rekomendasi" class="btn-tanya" id="rekomendasiSubmitBtn"><?= $language['rekomendasi_kirim'] ?></button>
                </form>

                <script>
                    (function() {
                        var MAX_SIZE = 2 * 1024 * 1024; // 2MB, harus sama dengan limit di rekomendasi_foto_helper.php
                        var input = document.getElementById('rekomendasiFoto');
                        var warning = document.getElementById('rekomendasiFotoWarning');
                        var submitBtn = document.getElementById('rekomendasiSubmitBtn');

                        input.addEventListener('change', function() {
                            if (!input.files || !input.files[0]) {
                                warning.hidden = true;
                                submitBtn.disabled = false;
                                return;
                            }

                            var file = input.files[0];

                            if (file.size > MAX_SIZE) {
                                var ukuranMB = (file.size / (1024 * 1024)).toFixed(1);
                                // json_encode: teks terjemahan yang mengandung tanda kutip tidak lagi merusak JavaScript
                                warning.textContent = <?= json_encode($language['rekomendasi_foto_terlalu_besar'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?> + ' (' + ukuranMB + ' MB, maks 2 MB)';
                                warning.hidden = false;
                                submitBtn.disabled = true;
                            } else {
                                warning.hidden = true;
                                submitBtn.disabled = false;
                            }
                        });
                    })();
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .rekomendasi-item.card-style {
        min-height: 320px;
        justify-content: center;
    }

    .rekomendasi-carousel .rekomendasi-item .rekomendasi-photo {
        width: 90px !important;
        height: 90px !important;
        max-width: 90px !important;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem;
        display: block;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .rekomendasi-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #75975e;
        color: #fff;
        font-size: 34px;
        font-weight: 600;
    }

    .rekomendasi-quote-icon {
        color: #75975e;
        opacity: 0.35;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .rekomendasi-text {
        font-size: 0.95rem;
        color: #555;
        font-style: italic;
        margin-bottom: 1rem;
    }

    .rekomendasi-nama {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
    }

    .owl-carousel .rekomendasi-item {
        margin: 10px;
    }

    @media (max-width: 768px) {
        .rekomendasi-item.card-style {
            min-height: auto;
        }
    }

    .rekomendasi-form-wrap {
        max-width: 600px;
        margin: 50px auto 0;
        background: #f8f9f5;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
    }

    .rekomendasi-form-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 6px;
    }

    .rekomendasi-form-sub {
        color: #666;
        font-size: .9rem;
        margin-bottom: 20px;
    }

    .rekomendasi-honeypot {
        position: absolute;
        left: -9999px;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .rekomendasi-form {
        text-align: left;
    }

    .rekomendasi-form-row {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .rekomendasi-form-row input[type="text"] {
        flex: 1 1 200px;
    }

    .rekomendasi-form-row input[type="file"] {
        flex: 1 1 200px;
        padding: 8px;
    }

    .rekomendasi-file-field {
        flex: 1 1 200px;
        display: flex;
        flex-direction: column;
    }

    .rekomendasi-foto-hint {
        color: #888;
        font-size: .78rem;
        margin-top: 4px;
    }

    .rekomendasi-foto-warning {
        color: #c0392b;
        font-size: .78rem;
        margin-top: 4px;
        font-weight: 600;
    }

    .rekomendasi-form input[type="text"],
    .rekomendasi-form input[type="file"],
    .rekomendasi-form textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: inherit;
        font-size: .95rem;
    }

    .rekomendasi-form textarea {
        width: 100%;
        resize: vertical;
        margin-bottom: 16px;
    }

    .rekomendasi-form .btn-tanya {
        border: none;
        cursor: pointer;
        display: block;
        width: 100%;
        text-align: center;
    }

    .rekomendasi-alert-sukses {
        background: #e6f4ea;
        color: #1e7e34;
        border: 1px solid #c3e6cb;
        border-radius: 10px;
        padding: 20px;
        font-size: 1rem;
    }

    .rekomendasi-alert-sukses i {
        margin-right: 8px;
    }

    .rekomendasi-alert-warning {
        background: #fff3cd;
        color: #8a6d00;
        border: 1px solid #ffe69c;
        border-radius: 10px;
        padding: 14px 20px;
        font-size: .9rem;
        margin-top: 12px;
    }

    .rekomendasi-alert-kirim {
        margin: 0 0 16px;
        text-align: left;
    }

    .rekomendasi-alert-warning i {
        margin-right: 8px;
    }
</style>
