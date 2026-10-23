<?php include 'tampilandepan/t_header.php'?>
        <!-- Top Bar End -->

        <!-- Nav Bar Start -->
<?php include 'tampilandepan/t_navbar.php'?>
        <!-- Nav Bar End -->
<style>
/* === STYLE UNTUK GALERI / FOTO === */
.blog-item {
    border-radius: 8px;
    overflow: hidden; /* supaya gambar di dalam ikut melengkung */
    border: 1px solid #e5e5e5;
    background-color: #fff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    margin-bottom: 25px;
}

.blog-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.blog-img {
    height: 220px;
    background-size: cover;
    background-position: center;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    cursor: pointer;
    transition: filter 0.3s ease;
}

.blog-img:hover {
    filter: brightness(0.9);
}

.blog-text {
    padding: 15px;
    text-align: center;
    background-color: #fff;
}

.blog-text p {
    margin: 0;
    color: #555;
    font-size: 0.95rem;
}

/* Modal image styling */
.modal-content {
    border-radius: 10px;
    overflow: hidden;
}
.modal-body img {
    border-radius: 10px;
}

/* Responsif tambahan */
@media (max-width: 768px) {
    .blog-img {
        height: 180px;
    }
}
.modal-image {
  max-width: 90vw;        /* batas maksimum lebar 90% dari layar */
  max-height: 90vh;       /* batas maksimum tinggi 90% dari layar */
  width: auto;            /* biarkan browser menyesuaikan */
  height: auto;           /* menjaga rasio asli foto */
  border-radius: 10px;
  display: block;
  margin: auto;
  box-shadow: 0 0 20px rgba(0,0,0,0.4);
}

.modal-dialog {
  max-width: 100%; /* biar modal tidak memotong gambar */
}

</style>
        
        
        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2><?=$language["nav4.1"]  ?></h2>
                    </div>
                    <div class="col-12">
                        <a href=""><?=$language["nav1"]  ?></a>
                        <a href=""><?=$language["nav4.1"]  ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
        
        
        <!-- Blog Start -->
        <!-- Blog Start -->
<?php
    include_once 'koneksi.php';
    $ft = mysqli_query($conn, "SELECT * FROM foto ORDER BY id DESC LIMIT 1 ");
    $f = mysqli_fetch_object($ft);
?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p><?=$language["nav4.1"]  ?></p>
            <h2><?=$language["ft"] ?></h2>
        </div>
        <div class="row"> <!-- Tambahkan row di sini -->
            <?php 
                $foto = mysqli_query($conn,"SELECT * FROM foto ORDER BY id DESC");
                if(mysqli_num_rows($foto) > 0){
                    while($fth = mysqli_fetch_array($foto)){  
            ?>
            <div class="col-lg-4 col-md-6"> <!-- Gunakan kolom untuk mengatur item -->
                <div class="blog-item">
                    <div class="blog-img" style ="background-image: url('img/galerif/<?= $fth['foto'] ?>');" data-toggle="modal" data-target="#imageModal" data-img-url="img/galerif/<?= $fth['foto'] ?>">
                    </div>
                    <div class="blog-text">
                        <p><?=$fth['keterangan'] ?></p>
                    </div>
                    
                </div>
            </div>  
            <?php }}else{ ?>
                <div class="col-12"> <!-- Menampilkan pesan jika tidak ada data -->
                    Tidak ada data
                </div>
            <?php } ?>
        </div> <!-- Tutup row di sini -->
    </div>
</div>
<!-- Blog End -->

<!-- Modal untuk menampilkan gambar yang diperbesar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border: none; background: transparent; box-shadow: none;">
      <div class="modal-header" style="border: none;">
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 2rem;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center p-0">
        <img src="" alt="Foto" id="modalImage" class="modal-image">
      </div>
    </div>
  </div>
</div>


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
    // Script untuk menangani pembukaan modal dan menampilkan gambar yang diperbesar
    $(document).on('click', '.blog-img', function() {
        var imgUrl = $(this).data('img-url');
        $('#modalImage').attr('src', imgUrl);
    });
</script>
    </body>
</html>
