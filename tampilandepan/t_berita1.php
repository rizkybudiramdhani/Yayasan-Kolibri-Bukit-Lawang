<?php
    include 'koneksi.php';
    $tb = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 1 ");
    $d = mysqli_fetch_object($tb);
?>
<div class="event">
            <div class="container">
                <div class="section-header text-center">
                    <p><?=$language["n"]  ?></p>
                    <h2><?=$language["n2"]  ?></h2>
                </div>
                <?php 
                    $berita = mysqli_query($conn,"SELECT * FROM berita ORDER BY id DESC");
                    if(mysqli_num_rows($berita) > 0){
                        while($b = mysqli_fetch_array($berita)){
                    
                ?>
               
                    <div class="srow"> <!--col-4 -->
                            
                        <div class="">
                            <div class="event-item">
                                <img src="img/event-2.jpg" alt="Image">
                                <div class="event-content">
                                    
                                    <div class="event-text">
                                        <h3>Lorem ipsum dolor sit</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Neca pretim miura bitur facili ornare velit non vulpte liqum metus tortor
                                        </p>
                                        <a class="btn btn-custom" href="">Join Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }}else{ ?>
                        Tidak ada data
                <?php } ?>
                
            </div>
        </div>