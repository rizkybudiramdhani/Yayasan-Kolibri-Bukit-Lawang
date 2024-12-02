<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Tambah Pengguna
                </div>
                <div class="box-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="input-control"required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class="input-control"required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Level</label>
                            <select name="level" id=""class="input-control" required>
                                <option value="">Pilih</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="button" class="btn" onclick="window.location = 'pengguna.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){
                            $nama = addslashes( ucwords($_POST['nama']));
                            $user = addslashes(($_POST['username']));
                            $password = $_POST['password'];
                            $level = $_POST['level'];

                            $cek = mysqli_query($conn, "SELECT username FROM pengguna WHERE username = '".$user."' ");
                            if(mysqli_num_rows($cek) > 0 ){
                                echo '<div class="alert alert-error">Username sudah digunakan</div>';
                            }else{
                                $simpan = mysqli_query($conn, "INSERT INTO pengguna VALUES (
                                    null,
                                    '".$nama."',
                                    '".$user."',
                                    '".$password."',
                                    '".$level."'
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
   