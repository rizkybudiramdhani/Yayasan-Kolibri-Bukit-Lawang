<?php include 'tampilandepan/t_header.php'?>
        <!-- Top Bar End -->

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
        
        
        <!-- Blog Start -->
        <!-- Blog Start -->
<?php
    include 'koneksi.php';
    $vt = mysqli_query($conn, "SELECT * FROM video ORDER BY id DESC LIMIT 1 ");
    $v = mysqli_fetch_object($vt);
?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p><?=$language["nav4.2"]  ?></p>
            <h2><?=$language["v"] ?></h2>
        </div>
        <div class="row"> <!-- Tambahkan row di sini -->
    <?php 
        $video = mysqli_query($conn,"SELECT * FROM video ORDER BY id DESC");
        if(mysqli_num_rows($video) > 0){
            while($vi = mysqli_fetch_array($video)){  
    ?>
    <div class="col-lg-4 col-md-6"> <!-- Gunakan kolom untuk mengatur item -->
        <div class="blog-item">
            <video width="100%" controls>
                <source src="img/galeriv/<?= $vi['video'] ?>" type="video/<?= pathinfo($vi['video'], PATHINFO_EXTENSION); ?>">
                Your browser does not support the video tag.
            </video>
            <div class="blog-text">
                <p><?=$vi['keterangan'] ?></p>
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
<div class="modal" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="border: none;" >
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  style="padding: 0;">
                <img src="" alt="Deskripsi Gambar" class="img-fluid" id="modalImage" style="width: 100%; height: auto; max-height: 90vh;">
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
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
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
