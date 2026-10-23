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
        
        
        <!-- Blog Start -->
        <h1 class="text-center h3"><?= $e($p->judul) ?></h1>

        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <img src="img/upload/<?= $e(rawurlencode($p->gambar)) ?>" alt="<?= $e($p->judul) ?>" style="width: 50%;" class="images">
        </div>
        <p class="padding-custom"><?= $p -> keterangan?></p>
        <!-- Blog End -->


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
        .padding-custom{
            padding-left: 100px; 
            padding-right: 100px;
            white-space: pre-wrap; 
            line-height: 1.5; 
        }
    </style>
</html>

