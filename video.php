<?php include 'tampilandepan/t_header.php'?>

        <!-- Nav Bar Start -->
<?php include 'tampilandepan/t_navbar.php'?>
        <!-- Nav Bar End -->


        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2><?=$language["nav4.2"]  ?></h2>
                    </div>
                    <div class="col-12">
                        <a href=""><?=$language["nav1"]  ?></a>
                        <a href=""><?=$language["nav4.2"]  ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Video Section Start -->
<?php
    include 'koneksi.php';

    $per_page = 6;
    $page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset   = ($page - 1) * $per_page;

    $total_res   = mysqli_query($conn, "SELECT COUNT(*) AS total FROM video");
    $total_row   = mysqli_fetch_object($total_res);
    $total       = (int)$total_row->total;
    $total_pages = (int)ceil($total / $per_page);

    $video = mysqli_query($conn,
        "SELECT id, video, keterangan FROM video ORDER BY id DESC LIMIT $per_page OFFSET $offset"
    );
?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p><?=$language["nav4.2"]  ?></p>
            <h2><?=$language["v"] ?></h2>
        </div>

        <div class="row">
        <?php if (mysqli_num_rows($video) > 0): ?>
            <?php while ($vi = mysqli_fetch_array($video)):
                $file  = htmlspecialchars($vi['video'], ENT_QUOTES);
                $ext   = strtolower(pathinfo($vi['video'], PATHINFO_EXTENSION));
                $mime  = ($ext === 'webm') ? 'video/webm' : (($ext === 'ogg') ? 'video/ogg' : 'video/mp4');
                $ket   = htmlspecialchars($vi['keterangan'], ENT_QUOTES);
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-item">
                    <!-- Placeholder: video TIDAK di-load sampai user klik -->
                    <div class="vid-placeholder"
                         data-src="img/galeriv/<?= $file ?>"
                         data-type="<?= $mime ?>">
                        <div class="vid-play-btn">
                            <div class="vid-play-circle">
                                <i class="fa fa-play"></i>
                            </div>
                            <span class="vid-play-label">Klik untuk memutar</span>
                        </div>
                    </div>
                    <div class="blog-text">
                        <p><?= $ket ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-4">
                <p>Tidak ada video tersedia.</p>
            </div>
        <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Navigasi halaman video">
            <ul class="pagination justify-content-center flex-wrap">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>

    </div>
</div>
<!-- Video Section End -->

<style>
/* === VIDEO PLACEHOLDER === */
.vid-placeholder {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* rasio 16:9 */
    background: linear-gradient(135deg, #1a2a1a 0%, #2d4a2d 100%);
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
}
.vid-placeholder:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.35);
}
.vid-play-btn {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #fff;
}
.vid-play-circle {
    width: 64px;
    height: 64px;
    background: rgba(255,255,255,.2);
    border: 2px solid rgba(255,255,255,.5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    transition: background .2s ease, transform .2s ease;
}
.vid-placeholder:hover .vid-play-circle {
    background: rgba(255,255,255,.35);
    transform: scale(1.1);
}
.vid-play-label {
    font-size: 13px;
    opacity: .8;
    letter-spacing: .5px;
}

/* Video yang sudah di-load menggantikan placeholder */
.vid-placeholder video,
.blog-item video {
    display: block;
    width: 100%;
    border-radius: 8px;
}
</style>

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

<script>
// Klik placeholder → inject elemen <video> dan langsung putar
// Video TIDAK didownload sama sekali sebelum diklik
document.querySelectorAll('.vid-placeholder').forEach(function(ph) {
    ph.addEventListener('click', function() {
        var src  = ph.dataset.src;
        var type = ph.dataset.type;

        var video  = document.createElement('video');
        video.width    = '100%';
        video.controls = true;
        video.autoplay = true;
        video.style.display = 'block';

        var source = document.createElement('source');
        source.src  = src;
        source.type = type;
        video.appendChild(source);

        ph.replaceWith(video);
        video.play().catch(function(){/* autoplay mungkin diblokir browser, tapi controls tetap tersedia */});
    });
});
</script>
    </body>
</html>
