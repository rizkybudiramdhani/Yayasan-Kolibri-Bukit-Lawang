<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Tambah berita
                </div>
                <div class="box-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" placeholder="Judul Berita" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="" cols="30" rows="10" class="input-control" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" name="gambar" id="" class="input-control" required>
                        </div>
                        
                        <button type="button" class="btn" onclick="window.location = 'berita.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){

                            // print_r($_FILES['gambar']);

                            $judul = addslashes( ucwords($_POST['judul']));
                            $ket = addslashes(($_POST['keterangan']));
                            
                            $filename = $_FILES['gambar']['name'];
                            $tmpname = $_FILES['gambar']['tmp_name'];
                            $filesize = $_FILES['gambar']['size'];

                            $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                            $rename = 'berita' .time().'.'.$formatfile;

                            $allowedtype =array('png', 'jpg', 'jpeg', 'gif','mp4');

                            if(!in_array($formatfile, $allowedtype)){
                                echo '<div class="alert alert-error"> Format file tidak diizinkan</div>';
                            }elseif($filesize > 1000000){
                                echo '<div class="alert alert-error"> Ukuran file tidak boleh lebih dari 1MB</div>';
                            }else{

                                move_uploaded_file($tmpname,"../img/upload/".$rename );                           

                                    $simpan = mysqli_query($conn, "INSERT INTO berita VALUES (
                                        null,
                                        '".$judul."',
                                        '".$ket."',
                                        '".$rename."'
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
   