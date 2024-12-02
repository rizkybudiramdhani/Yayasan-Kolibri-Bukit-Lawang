<?php include 'koneksi.php' ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Yayasan Kolibri</title>
        <link rel="shortcut icon" href="img/icon.png" style="border-radius: 50%;" type="image/x-icon" >
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free Website Template" name="keywords">
        <meta content="Free Website Template" name="description">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Top Bar Start -->
        <div class="top-bar d-none d-md-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="top-bar-left">

                            <a href="?lang=in"> <img src="img/indonesia-flag.png" ></img> </a> ||
                            <a href="?lang=en"> <img src="img/us-of-america.png"></img></a>
                        
                            <div class="text">
                                <i class="fa fa-phone-alt"></i>
                                <p>+62-8529-7243-719</p>
                            </div>
                            <div class="text">
                                <i class="fa fa-envelope"></i>
                                <p>yusufsihotang70@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="top-bar-right">
                            <div class="social">
                                <a href="https://www.facebook.com/people/Yayasan-Kolibri-Bukit-Lawang-New/100091601498368/"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/yayasan_kolibri_bukit_lawang?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php 
    // Cek apakah cookie 'lang' ada
    if (isset($_COOKIE['lang'])) {
        $lang = $_COOKIE['lang']; // Ambil bahasa dari cookie
    } else {
        $lang = "in"; // default language
    }

    // Jika ada parameter 'lang' dalam URL, perbarui cookie
    if (isset($_GET["lang"])) {
        $lang = $_GET['lang'];
        setcookie('lang', $lang, time() + (86400 * 30), "/"); // Simpan cookie selama 30 hari
    }

    $language = parse_ini_file("lang/$lang.ini");
?>