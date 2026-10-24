<?php
/*
 * Data berita diambil SEBELUM header supaya:
 * 1. Kalau ID tidak ada, bisa redirect pakai HTTP header (bukan script JS).
 * 2. Judul berita bisa dipakai sebagai <title> & meta description halaman.
 *
 * Dulu $_GET['id'] ditempel langsung ke SQL → SQL injection di halaman PUBLIK
 * (bisa membaca seluruh isi database tanpa login). Sekarang: cast int + prepared statement.
 */
include_once __DIR__ . '/koneksi.php';

$idBerita = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT judul, keterangan, gambar FROM berita WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $idBerita);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $judulBerita, $isiBerita, $gambarBerita);
$beritaDitemukan = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$beritaDitemukan) {
    header('Location: berita.php');
    exit;
}
$p = (object) ['judul' => $judulBerita, 'keterangan' => $isiBerita, 'gambar' => $gambarBerita];

$pageTitle = $p->judul . ' – Yayasan Kolibri Bukit Lawang';
$pageImage = 'img/upload/' . rawurlencode($p->gambar); // preview saat link artikel dibagikan di WA/FB
$pageDesc  = mb_strimwidth(trim(preg_replace('/\s+/', ' ', strip_tags($p->keterangan))), 0, 155, '…', 'UTF-8');

include 'tampilandepan/t_header.php';
?>
        <!-- Top Bar End -->

        <!-- Nav Bar Start -->
<?php include 'tampilandepan/t_navbar.php'?>
        <!-- Nav Bar End -->
        
        
        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2><?=$language["nav3"]  ?></h2>
                    </div>
                    <div class="col-12">
                        <a href="index.php"><?=$language["nav1"]  ?></a>
                        <a href="berita.php"><?=$language["nav3"]  ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
        
        
        <!-- Artikel Start -->
        <article class="artikel-detail">
            <div class="container">
                <h1><?= $e($p->judul) ?></h1>

                <figure class="artikel-detail-gambar">
                    <img src="img/upload/<?= $e(rawurlencode($p->gambar)) ?>" alt="<?= $e($p->judul) ?>">
                </figure>

                <!-- Di-escape: isi artikel ditulis sebagai teks biasa di admin;
                     baris baru tetap tampil karena white-space: pre-line -->
                <div class="artikel-detail-isi"><?= $e($p->keterangan) ?></div>

                <a href="berita.php<?= $lang === 'en' ? '?lang=en' : '' ?>" class="artikel-detail-kembali">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $e($language['artikel_kembali']) ?>
                </a>
            </div>
        </article>
        <!-- Artikel End -->


        <!-- Footer Start -->
        <?php include 'tampilandepan/t_footer.php'?>
        <!-- Footer End -->

        <!-- Back to top button -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- Pre Loader -->
        <div id="loader" class="show">
            <div class="loader"></div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/parallax/parallax.min.js"></script>
        
        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
    <style>
        /* Lebar teks dibatasi ±70 karakter per baris agar nyaman dibaca,
           menggantikan padding tetap 100px yang membuat teks sempit di HP */
        .artikel-detail { padding: 45px 0 60px; }
        .artikel-detail .container { max-width: 820px; }
        .artikel-detail h1 {
            font-size: clamp(1.6rem, 4vw, 2.3rem);
            line-height: 1.25;
            text-align: center;
            color: #4a4c70;
            margin-bottom: 25px;
        }
        .artikel-detail-gambar { margin: 0 0 30px; }
        .artikel-detail-gambar img {
            display: block;
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            border-radius: 10px;
        }
        .artikel-detail-isi {
            white-space: pre-line;
            font-size: 1.05rem;
            line-height: 1.8;
            color: #444;
        }
        .artikel-detail-kembali {
            display: inline-block;
            margin-top: 35px;
            font-weight: 600;
            color: #75975e;
        }
        .artikel-detail-kembali:hover { color: #5a7a47; text-decoration: none; }
    </style>
</html>

