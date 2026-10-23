<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include '../koneksi.php';
    if(!isset($_SESSION['status_login'])){
        echo "<script>window.location = '../login.php?msg=Harap Login Terlebih Dahulu!'</script>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - kolibri</title><link rel="stylesheet" href="../css/stylephp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
    <!-- navbar -->
    <div class = "navbar">

        <div class = "container navbar-inner">

            <!-- navbar brand -->
            <h2 class = "nav-brand float-left"><a href="index.php">Kolibri</a></h2>

            <button type="button" class="nav-toggle" aria-label="Menu" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </button>

            <!-- navbar menu -->
            <ul class="nav-menu float-left">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="pengguna.php">Pengguna</a></li>
                <li><a href="Berita.php">Berita</a></li>
                <li class="has-dropdown">
                    <a href="Foto.php">Galeri <i class="fa fa-caret-down"></i></a>
                    <!-- submenu -->
                    <ul class="dropdown">
                        <li><a href="Foto.php">Foto</a></li>
                        <li><a href="video.php">Video</a></li>
                    </ul>
                </li>
                <li><a href="kontak.php">Pesan</a></li>
                <li><a href="rekomendasi.php">Rekomendasi</a></li>
                <li class="has-dropdown">
                    <a href="index.php"><?= $_SESSION['uname'] ?> <i class="fa fa-caret-down"></i></a>
                    <!-- submenu -->
                    <ul class="dropdown">
                        <li><a href="Logout.php">Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.querySelector('.nav-toggle');
            var menu = document.querySelector('.nav-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', function() {
                    var isOpen = menu.classList.toggle('is-open');
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            }
            document.querySelectorAll('.nav-menu > li.has-dropdown').forEach(function(li) {
                var link = li.querySelector(':scope > a');
                link.addEventListener('click', function(e) {
                    if (window.matchMedia('(max-width: 768px)').matches) {
                        e.preventDefault();
                        li.classList.toggle('dropdown-open');
                    }
                });
            });
        });
    </script>