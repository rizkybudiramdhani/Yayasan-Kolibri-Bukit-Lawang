<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Video
                </div>
                <div class="box-body">
                    
                    <a href="tambah-video.php" class="text-green"> <i class="fa fa-plus"> </i>Tambah Video </a>
                    <br>
                    <br>
                    
                    
                    <?php
                    
                        if(isset($_GET['success'])){
                            echo "<div class ='alert alert-success'>".$_GET['success']."</div>";
                        }
                    
                    ?>

                    <form action="" method="get">

                        <div class="input-group">
                            <input type="text" name="key" id="" placeholder="Pencarian">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>

                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Video</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $no = 1;
                                $where = " WHERE 1=1";
                                if(isset($_GET['key'])){
                                    $where .= " AND keterangan LIKE '%".addslashes($_GET['key'])."%' ";
                                }

                                $video = mysqli_query($conn,"SELECT * FROM video $where ORDER BY id DESC");
                                if(mysqli_num_rows($video) > 0){
                                    while($p = mysqli_fetch_array($video)){
                            ?>
                            <tr>
                                <td><?= $no++?></td>
                                <td>
                                <video width="200" controls>
                                    <source src="../img/galeriv/<?=  $p['video'] ?>" type="video/<?= pathinfo($p['video'], PATHINFO_EXTENSION); ?>">
                                    Your browser does not support the video tag.
                                </video>
                                </td>
                                <td><?= $p['keterangan']?></td>
                                <td>
                                    <a href="edit-video.php?id=<?= $p['id']?>" title="Edit video" class="text-orange"><i class= "fa fa-edit"></i></a> 
                                    <a href="hapus.php?idvideo=<?= $p['id']?>"onclick="return confirm('Yakin Ingin Hapus')"  title="Hapus Data" class="text-red"><i class= "fa fa-times"></i></a>
                                </td>
                            </tr>
                                
                            <?php }}else{ ?> 
                                <tr>
                                    <td colspan="4">Data Tidak Ada</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
   