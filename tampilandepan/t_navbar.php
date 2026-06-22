<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<div class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand"> <img src="img/icon.png" class=image></img> YAYASAN KOLIBRI </a> <a href="index.php" class="icon">BUKIT LAWANG</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto">
                <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><?php echo $language["nav1"]; ?></a>
                <a href="tentang.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'tentang.php' ? 'active' : ''; ?>"><?php echo $language["nav2"]; ?></a>
                <a href="berita.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : ''; ?>"><?php echo $language["nav3"]; ?></a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $language["nav4"]; ?></a>
                    <div class="dropdown-menu">
                        <a href="foto.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'foto.php' ? 'active' : ''; ?>"><?php echo $language["nav4.1"]; ?></a>
                        <a href="video.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'video.php' ? 'active' : ''; ?>"><?php echo $language["nav4.2"]; ?></a>   
                    </div>
                </div>
                <a href="kontak.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : ''; ?>"><?php echo $language["nav5"]; ?></a>
                <div class="language">
                    <a href="?lang=in"> <img src="img/indonesia-flag.png" ></img> </a> ||
                    <a href="?lang=en"> <img src="img/us-of-america.png" ></img></a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media (min-width: 768px) {
    .language {
        display: none;
    }
}

/* Tampilkan elemen pada perangkat dengan lebar kurang dari 768px (handphone) */
@media (max-width: 767px) {
    .language {
        display: block; /* atau inline, inline-block, dll. sesuai kebutuhan */
    }
}


</style>
<style>
    @media (min-width: 768px) {
        .language {
            display: none;
        }
    }

    /* Tampilkan elemen pada perangkat dengan lebar kurang dari 768px (handphone) */
    @media (max-width: 767px) {
        .language {
            display: block;
        }
        
        /* TAMBAHAN: Kecilkan tulisan YAYASAN KOLIBRI di mobile */
        .navbar-brand {
            font-size: 16px !important;
            letter-spacing: 1px !important;
        }
        
        .navbar-brand img {
            max-height: 25px !important;
        }
        
        .icon {
            font-size: 10px !important;
            letter-spacing: 1px !important;
        }
    }
    
    @media (max-width: 576px) {
        /* Untuk HP yang lebih kecil, kecilkan lagi */
        .navbar-brand {
            font-size: 14px !important;
            letter-spacing: 0.5px !important;
        }
        
        .navbar-brand img {
            max-height: 20px !important;
        }
        
        .icon {
            font-size: 9px !important;
        }
    }
</style>