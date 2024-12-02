<?php include 'header.php'?>
<!-- content -->

<?php

    $berita   = mysqli_query($conn, "SELECT * FROM berita WHERE id = '".$_GET['id']."' ");
    
    if(mysqli_num_rows($berita) == 0){
        echo "<script>window.location = 'berita.php'</script>";
    }
    $p          = mysqli_fetch_object($berita);


?>
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Edit Berita
                </div>
                <div class="box-body">
                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" value ="<?= $p->judul?>" id="judul" placeholder="Judul Berita" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="" cols="30" rows="10" class="input-control" placeholder="Keterangan"><?= $p->keterangan?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <img src="../img/upload/<?= $p-> gambar ?>" alt=""width="200px" class="image">
                            <input type="hidden" name="gambar2" value="<?= $p-> gambar?>" >
                            <input type="file" name="gambar" id="" class="input-control">
                        </div>
                        
                        <button type="button" class="btn" onclick="window.location = 'berita.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){

                            $judul = addslashes( ucwords($_POST['judul']));
                            $ket = addslashes(($_POST['keterangan']));
                           
                            if($_FILES['gambar']['name'] != ''){

                                // echo 'user ganti gambar';

                                $filename = $_FILES['gambar']['name'];
                                $tmpname = $_FILES['gambar']['tmp_name'];
                                $filesize = $_FILES['gambar']['size'];

                                $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                                $rename = 'berita' .time().'.'.$formatfile;

                                $allowedtype =array('png', 'jpg', 'jpeg', 'gif','mp4');

                                if(!in_array($formatfile, $allowedtype)){
                                    
                                    echo '<div class="alert alert-error"> Format file tidak diizinkan</div>';
                                    
                                    return false;

                                }elseif($filesize > 1000000){
                                    
                                    echo '<div class="alert alert-error"> Ukuran file tidak boleh lebih dari 1MB</div>';
                                
                                }

                                if(file_exists("../img/upload/".$_POST['gambar2'])){

                                    unlink("../img/upload/".$_POST['gambar2']);

                                }


                                move_uploaded_file($tmpname,"../img/upload/".$rename ); 
            
                            }else{
                                // echo 'user tidak ganti gambar';

                                $rename = $_POST['gambar2'];
                            }

                            $update =mysqli_query($conn, "UPDATE berita SET
                                    judul = '".$judul."',
                                    keterangan = '".$ket."',
                                    gambar = '".$rename."'
                                    WHERE id = '".$_GET['id']."'
                            ");

                            if($update){
                                echo "<script>window.location='Berita.php?success=Edit Data Berhasil'</script>";
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
   