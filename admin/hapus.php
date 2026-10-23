<?php

    if (session_status() === PHP_SESSION_NONE) session_start();
    if(!isset($_SESSION['status_login'])){
        echo "<script>window.location = '../login.php?msg=Harap Login Terlebih Dahulu!'</script>";
        exit;
    }

    include '../koneksi.php';
    require_once '../rekomendasi_foto_helper.php';

    foreach (['idpengguna', 'idberita', 'idfoto', 'idvideo', 'idpesan', 'idrekomendasi'] as $kunciId) {
        if (isset($_GET[$kunciId])) {
            $_GET[$kunciId] = (int) $_GET[$kunciId];
        }
    }

    if(isset($_GET['idpengguna'])){

        $delete = mysqli_query($conn, "DELETE FROM pengguna WHERE id = '".$_GET['idpengguna']."' ");
        echo "<script>window.location = 'pengguna.php'</script>";

    }
    if(isset($_GET['idberita'])){  
        $berita = mysqli_query($conn, "SELECT gambar FROM berita WHERE id = '".$_GET['idberita']."' ");
        
        if(mysqli_num_rows($berita) > 0){

            $p = mysqli_fetch_object($berita);

            if(file_exists("../img/upload/".$p->gambar)){
                unlink("../img/upload/".$p->gambar);
            }

        }

        $delete = mysqli_query($conn, "DELETE FROM berita WHERE id = '".$_GET['idberita']."' ");
        echo "<script>window.location = 'Berita.php'</script>";

    }

    if(isset($_GET['idfoto'])){  
        $Foto = mysqli_query($conn, "SELECT foto FROM foto WHERE id = '".$_GET['idfoto']."' ");
        
        if(mysqli_num_rows($Foto) > 0){

            $p = mysqli_fetch_object($Foto);

            if(file_exists("../img/galerif/".$p->foto)){
                unlink("../img/galerif/".$p->foto);
            }

        }

        $delete = mysqli_query($conn, "DELETE FROM foto WHERE id = '".$_GET['idfoto']."' ");
        echo "<script>window.location = 'Foto.php'</script>";

    }
    if(isset($_GET['idvideo'])){  
        $video = mysqli_query($conn, "SELECT video FROM video WHERE id = '".$_GET['idvideo']."' ");
        
        if(mysqli_num_rows($video) > 0){

            $p = mysqli_fetch_object($video);

            if(file_exists("../img/galeriv/".$p->video)){
                unlink("../img/galeriv/".$p->video);
            }

        }

        $delete = mysqli_query($conn, "DELETE FROM video WHERE id = '".$_GET['idvideo']."' ");
        echo "<script>window.location = 'video.php'</script>";

    }
    if(isset($_GET['idpesan'])){

        $delete = mysqli_query($conn, "DELETE FROM pesan WHERE id = '".$_GET['idpesan']."' ");
        echo "<script>window.location = 'kontak.php'</script>";
    }

    if(isset($_GET['idrekomendasi'])){
        $Rekomendasi = mysqli_query($conn, "SELECT foto FROM rekomendasi WHERE id = '".$_GET['idrekomendasi']."' ");

        if(mysqli_num_rows($Rekomendasi) > 0){

            $p = mysqli_fetch_object($Rekomendasi);

            if(nama_foto_rekomendasi_valid($p->foto) && file_exists("../img/rekomendasi/".$p->foto)){
                unlink("../img/rekomendasi/".$p->foto);
            }

        }

        $delete = mysqli_query($conn, "DELETE FROM rekomendasi WHERE id = '".$_GET['idrekomendasi']."' ");
        echo "<script>window.location = 'rekomendasi.php'</script>";
    }

?>