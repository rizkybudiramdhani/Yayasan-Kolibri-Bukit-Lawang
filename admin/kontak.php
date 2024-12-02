<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Pesan
                </div>
                <div class="box-body">
                    
                    
                    
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>subjek</th>
                                <th>Pesan</th>
                                <th>aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $no = 1;
                                $where = " WHERE 1=1";
                                if(isset($_GET['key'])){
                                    $where .= " AND nama LIKE '%".addslashes($_GET['key'])."%' ";
                                }

                                $pesan = mysqli_query($conn,"SELECT * FROM pesan $where ORDER BY id DESC");
                                if(mysqli_num_rows($pesan) > 0){
                                    while($p = mysqli_fetch_array($pesan)){
                            ?>
                            <tr>
                                <td><?= $no++?></td>
                                <td><?= $p['nama']?></td>
                                <td><?= $p['email']?></td>
                                <td><?= $p['subjek']?></td>
                                <td><?= $p['pesan']?></td>
                            
                                <td>
                                    
                                    <a href="hapus.php?idpesan=<?= $p['id']?>"onclick="return confirm('Yakin Ingin Hapus')"  title="Hapus Data" class="text-red"><i class= "fa fa-times"></i></a>
                                </td>
                            </tr>
                                
                            <?php }}else{ ?> 
                                <tr>
                                    <td colspan="6">Data Tidak Ada</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
   