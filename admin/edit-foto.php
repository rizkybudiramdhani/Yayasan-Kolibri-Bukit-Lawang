<?php include 'header.php'?>
<!-- content -->

<?php

    // Cast ke integer: menutup celah SQL injection lewat ?id= (berlaku juga untuk UPDATE di bawah)
    $_GET['id'] = (int) ($_GET['id'] ?? 0);
    $Foto   = mysqli_query($conn, "SELECT * FROM foto WHERE id = '".$_GET['id']."' ");
    
    if(mysqli_num_rows($Foto) == 0){
        echo "<script>window.location = 'Foto.php'</script>";
    }
    $p          = mysqli_fetch_object($Foto);


?>
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Edit Foto
                </div>
                <div class="box-body">
                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" value ="<?= htmlspecialchars($p->keterangan, ENT_QUOTES, 'UTF-8') ?>" id="keterangan" placeholder="Keterangan Foto" class="input-control" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <img src="../img/galerif/<?= $p->foto ?>" alt=""width="200px" class="image">
                            <input type="hidden" name="gambar2" value="<?= $p->foto ?>" >
                            <input type="file" name="gambar" id="" class="input-control">
                        </div>
                        
                        <button type="button" class="btn" onclick="window.location = 'Foto.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){

                            $ket = addslashes( ucwords($_POST['keterangan']));
                           
                            if($_FILES['gambar']['name'] != ''){

                                // echo 'user ganti gambar';

                                $filename = $_FILES['gambar']['name'];
                                $tmpname = $_FILES['gambar']['tmp_name'];
                                $filesize = $_FILES['gambar']['size'];

                                $formatfile = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $rename = 'foto' .time().'.'.$formatfile;

                                $allowedtype =array('png', 'jpg', 'jpeg', 'gif');

                                if(!in_array($formatfile, $allowedtype)){
                                    
                                    echo '<div class="alert alert-error"> Format file tidak diizinkan</div>';
                                    
                                    return false;

                                }elseif($filesize > 1000000){
                                    
                                    echo '<div class="alert alert-error"> Ukuran file tidak boleh lebih dari 1MB</div>';
                                
                                }

                                if(file_exists("../img/galerif/".basename((string) $_POST['gambar2']))){

                                    unlink("../img/galerif/".basename((string) $_POST['gambar2']));

                                }


                                move_uploaded_file($tmpname,"../img/galerif/".$rename ); 
            
                            }else{
                                // echo 'user tidak ganti gambar';

                                $rename = basename((string) $_POST['gambar2']);
                            }

                            $update =mysqli_query($conn, "UPDATE foto SET
                                    keterangan = '".$ket."',
                                    foto = '".$rename."'
                                    WHERE id = '".$_GET['id']."'
                            ");

                            if($update){
                                echo "<script>window.location='Foto.php?success=Edit Data Berhasil'</script>";
                            }else{
                                echo 'Gagal Edit'.mysqli_error($conn);
                            }   

                        }
                    
                    ?>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
   