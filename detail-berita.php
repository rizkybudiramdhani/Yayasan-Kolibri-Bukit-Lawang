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
        <?php 
        $berita   = mysqli_query($conn, "SELECT * FROM berita WHERE id = '".$_GET['id']."' ");
    
        if(mysqli_num_rows($berita) == 0){
            echo "<script>window.location = 'index.php'</script>";
        }
        $p = mysqli_fetch_object($berita);
    
        ?>
        <h3 class="text-center"><?= $p->judul ?></h3>

        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <img src="img/upload/<?= $p->gambar ?>" style="width: 50%;" class="images">
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
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
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

