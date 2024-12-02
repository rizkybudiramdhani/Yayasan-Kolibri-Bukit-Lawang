<?php
// Include koneksi database
include 'koneksi.php';

// Ambil video dari database
$query = "SELECT * FROM videod ORDER BY id DESC LIMIT 1"; // Mengambil video terbaru
$result = mysqli_query($conn, $query);
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}
$video = mysqli_fetch_assoc($result);
?>

<div class="carousel">
    <div class="container-fluid">
        <div class="owl-carousel">
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="img/slide.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h1><?=$language["slider1"] ?></h1>
                    <p><?=$language["slider1.2"] ?></p>
                    <div class="carousel-btn">
                        <a class="btn btn-custom" href="donate.php"><?=$language["slidert"] ?></a>
                        <a class="btn btn-custom btn-play" data-toggle="modal" data-src="../img/galerivd/<?= $p['video']?>" type="video/<?= pathinfo($p['video'], PATHINFO_EXTENSION); ?>" data-target="#videoModal"><?=$language["slidert2"] ?></a>
                    </div>
                </div>
            </div>
            <!-- Tambahkan video ke dalam carousel -->
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="img/slide2.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h1><?=$language["slider2"] ?></h1>
                    <p><?=$language["slider2.2"] ?></p>
                    <div class="carousel-btn">
                        <a class="btn btn-custom" href="donate.php"><?=$language["slidert"] ?></a>
                        <a class="btn btn-custom btn-play" data-toggle="modal" data-src="../img/galerivd/<?=$video['video']?>" data-target="#videoModal"><?=$language["slidert2"] ?></a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="img/slide3.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h1><?=$language["slider3"] ?></h1>
                    <p><?=$language["slider3.2"] ?></p>
                    <div class="carousel-btn">
                        <a class="btn btn-custom" href="donate.php"><?=$language["slidert"] ?></a>
                        <a class="btn btn-custom btn-play" data-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-target="#videoModal"><?=$language["slidert2"] ?></a>
                    </div>
                </div>
            </div>
            <!-- Tambahkan item carousel lainnya di sini -->
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan video -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Tonton Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <video id="videoFrame" width="100%" height="315" controls>
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.btn-play').on('click', function() {
        var videoSrc = $(this).data('src');
        $('#videoFrame source').attr('src', videoSrc);
        $('#videoFrame')[0].load(); // Reload video
        $('#videoFrame')[0].play(); // Play video automatically
    });

    // Hapus sumber video saat modal ditutup
    $('#videoModal').on('hidden.bs.modal', function () {
        $('#videoFrame source').attr('src', '');
        $('#videoFrame')[0].load(); // Reload video
    });
});
</script>
<?php
mysqli_close($conn); // Tutup koneksi
?>