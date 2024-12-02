<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Foto
                </div>
                <div class="box-body">
                    
                    <a href="tambah-foto.php" class="text-green"> <i class="fa fa-plus"> </i>Tambah Foto </a>
                    
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
                                <th>Foto</th>
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

                                $Foto = mysqli_query($conn,"SELECT * FROM foto $where ORDER BY id DESC");
                                if(mysqli_num_rows($Foto) > 0){
                                    while($p = mysqli_fetch_array($Foto)){
                            ?>
                            <tr>
                                <td><?= $no++?></td>
                                <td><img src="../img/galerif/<?=  $p['foto'] ?>" alt="" width="200px"></td>
                                <td><?= $p['keterangan']?></td>
                                <td>
                                    <a href="edit-foto.php?id=<?= $p['id']?>" title="Edit Data" class="text-orange"><i class= "fa fa-edit"></i></a> 
                                    <a href="hapus.php?idfoto=<?= $p['id']?>"onclick="return confirm('Yakin Ingin Hapus')"  title="Hapus Data" class="text-red"><i class= "fa fa-times"></i></a>
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
   