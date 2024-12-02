<?php
    ob_start();
    session_start();
    include 'koneksi.php';
    $tb = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 1 ");
    $d = mysqli_fetch_object($tb);
    $nama_admin = isset($_SESSION['uname']) ? $_SESSION['uname'] : 'Admin';
?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p><?=$language["n"]  ?></p>
            <h2><?=$language["nn"] ?></h2>
        </div>
        <div class="row"> <!-- Tambahkan row di sini -->
            <?php 
                $berita = mysqli_query($conn,"SELECT * FROM berita ORDER BY id DESC");
                if(mysqli_num_rows($berita) > 0){
                    while($b = mysqli_fetch_array($berita)){  
            ?>
            <div class="col-lg-4 col-md-6"> <!-- Gunakan kolom untuk mengatur item -->
                <div class="blog-item">
                    <a href="detail-berita.php?id=<?= $b['id'] ?>">
                    <div class="blog-img" style ="background-image: url('img/upload/<?= $b['gambar'] ?>');">
                        
                    </div>
                    <div class="blog-text">
                        <h3><?=$b['judul'] ?></h3> <!-- Ganti dengan data yang relevan -->
                        <p>
                            <?=$b['keterangan '] ?> <!-- Ganti dengan data yang relevan -->
                        </p>
                    </div>
                    </a>
                    <div class="blog-meta">
                        <p><i class="fa fa-user"></i><a href=""><?= $nama_admin ?></a></p>
                        
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