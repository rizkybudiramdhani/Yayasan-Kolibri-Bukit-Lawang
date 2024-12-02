<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Tambah Video
                </div>
                <div class="box-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="video">Video</label>
                            <input type="file" name="video" id="" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan video" class="input-control" required>
                        </div>
       
                        <button type="button" class="btn" onclick="window.location = 'video.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){

                            // print_r($_FILES['video']);

                            $ket = addslashes( ucwords($_POST['keterangan']));
                            
                            $filename = $_FILES['video']['name'];
                            $tmpname = $_FILES['video']['tmp_name'];
                            $filesize = $_FILES['video']['size'];

                            $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                            $rename = 'video' .time().'.'.$formatfile;

                            $allowedtype =array('mp4','gif','mkv','mov');

                            if(!in_array($formatfile, $allowedtype)){
                                echo '<div class="alert alert-error"> Format file tidak diizinkan</div>';
                            }elseif($filesize > 1000000000){
                                echo '<div class="alert alert-error"> Ukuran file tidak boleh lebih dari 1GB</div>';
                            }else{

                                move_uploaded_file($tmpname,"../img/galeriv/".$rename );                           

                                    $simpan = mysqli_query($conn, "INSERT INTO video VALUES (
                                        null,
                                        '".$rename."',
                                        '".$ket."'
                                        
                                    )");
                                    if($simpan){
                                        echo '<div class="alert alert-success"> Berhasil Simpan</div>';
                                    }else{
                                        echo 'Gagal Simpan'.mysqli_error($conn);
                                    }   
                            }

                            
                        }
                    
                    ?>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
   