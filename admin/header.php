<?php
    session_start();
    include '../koneksi.php';
    if(!isset($_SESSION['status_login']))
        echo "<script>window.location = '../login.php?msg=Harap Login Terlebih Dahulu!'</script>";
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

        <div class = "container">

            <!-- navbar brand -->
            <h2 class = "nav-brand float-left"><a href="index.php">Kolibri</a></h2>

            <!-- navbar menu -->
            <ul class="nav-menu float-left">
                <li><a href="Index.php">Dashboard</a></li>
                <li><a href="Pengguna.php">Pengguna</a></li>
            
                <li><a href="Berita.php">Berita</a></li>
                <li><a href="Index.php">Galeri <i class="fa fa-caret-down"></i></a>
                <!-- submenu -->
                <ul class="dropdown">
                    <li><a href="Foto.php">Foto </a></li>
                    <li><a href="Video.php">Video</a></li>
                </ul>
                
                <li><a href="kontak.php">Pesan</a></li>
            </li>
                <li><a href="Akun.php"><?= $_SESSION['uname'] ?>     <i class="fa fa-caret-down"></i></a>
                    <!-- submenu -->
                    <ul class="dropdown">
                        <li><a href="Logout.php">Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

    </div>