<?php
// Include koneksi database
include_once 'koneksi.php';

// Ambil video terbaru dari database
$query = "SELECT * FROM videod ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
if (!$result) {
  die('Query Error: ' . mysqli_error($conn));
}
$video = mysqli_fetch_assoc($result);
?>

<div class="carousel">
  <div class="container-fluid">
    <div class="owl-carousel">

      <!-- Slide 1 -->
      <div class="carousel-item">
        <div class="carousel-img">
          <img src="img/slide.jpg" alt="<?= htmlspecialchars($language["alt_slider"], ENT_QUOTES, 'UTF-8') ?>">

        </div>
        <div class="carousel-text">
          <h1><?= $language["slider1"] ?></h1>
          <p><?= $language["slider1.2"] ?></p>
          <div class="carousel-btn">
            <a class="btn btn-custom" href="donate.php"><?= $language["slidert"] ?></a>
            <a class="btn btn-custom btn-play" data-toggle="modal"
              data-src="../img/galerivd/<?= $video['video'] ?>"
              data-target="#videoModal"><?= $language["slidert2"] ?></a>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="carousel-img">
          <img src="img/slide2.jpg" alt="<?= htmlspecialchars($language["alt_slider"], ENT_QUOTES, 'UTF-8') ?>">
          <div class="overlay"></div>
        </div>
        <div class="carousel-text">
          <h1><?= $language["slider2"] ?></h1>
          <p><?= $language["slider2.2"] ?></p>
          <div class="carousel-btn">
            <a class="btn btn-custom" href="donate.php"><?= $language["slidert"] ?></a>
            <a class="btn btn-custom btn-play" data-toggle="modal"
              data-src="../img/galerivd/<?= $video['video'] ?>"
              data-target="#videoModal"><?= $language["slidert2"] ?></a>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item">
        <div class="carousel-img">
          <img src="img/slide3.jpg" alt="<?= htmlspecialchars($language["alt_slider"], ENT_QUOTES, 'UTF-8') ?>">
          <div class="overlay"></div>
        </div>
        <div class="carousel-text">
          <h1><?= $language["slider3"] ?></h1>
          <p><?= $language["slider3.2"] ?></p>
          <div class="carousel-btn">
            <a class="btn btn-custom" href="donate.php"><?= $language["slidert"] ?></a>
            <a class="btn btn-custom btn-play" data-toggle="modal"
              data-src="../img/galerivd/<?= $video['video'] ?>"
              data-target="#videoModal"><?= $language["slidert2"] ?></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<style>
  /* ==== GAYA GAMBAR CAROUSEL ==== */
  .carousel-img {
    position: relative;
    border-radius: 0 0 18px 18px;
    /* hanya bawah kiri & bawah kanan */
    overflow: hidden;
  }

  /* gambar tetap proporsional */
  .carousel-img img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 0 0 18px 18px;
    transition: transform 0.5s ease-in-out;
  }

  .carousel-img:hover img {
    transform: scale(1.05);
  }

  /* overlay gelap */
  .carousel-img .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 10, 10, 0.35);
    border-radius: 0 0 18px 18px;
    z-index: 1;
  }

  /* ==== Teks di tengah ==== */
  .carousel-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    text-align: center;
    color: #fff;
    padding: 20px;
    width: 80%;
  }

  .carousel-text h1 {
    font-weight: 700;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
  }

  .carousel-text p {
    font-size: 1.1rem;
    margin-top: 10px;
    color: #f1f1f1;
  }

  /* ==== Tombol ==== */
  .carousel-btn .btn-custom {
    border-radius: 25px;
    padding: 10px 25px;
    margin: 5px;
    font-weight: 500;
    transition: 0.3s;
  }

  .carousel-btn .btn-custom:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  /* ==== Hilangkan tombol navigasi Owl Carousel ==== */
  .owl-nav,
  .owl-prev,
  .owl-next {
    display: none !important;
  }

  /* Hilangkan juga dots jika kamu mau tampil bersih */
  .owl-dots {
    display: none !important;
  }
</style>