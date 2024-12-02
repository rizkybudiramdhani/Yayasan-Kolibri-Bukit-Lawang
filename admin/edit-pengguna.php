<?php include 'header.php'?>
<!-- content -->

<?php

    $pengguna   = mysqli_query($conn, "SELECT * FROM pengguna WHERE id = '".$_GET['id']."' ");
    $p          = mysqli_fetch_object($pengguna);

    if(mysqli_num_rows($pengguna) == 0){
        echo "<script>window.location = 'pengguna.php'</script>";
    }

?>
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Edit Pengguna
                </div>
                <div class="box-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="input-control" value="<?=  $p -> nama?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="input-control" value="<?=  $p -> username?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class="input-control" value="<?=  $p -> password?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Level</label>
                            <select name="level" id=""class="input-control" required>
                                <option value="">Pilih</option>
                                <option value="admin"<?= ($p->level == 'admin')? 'selected':''; ?>>Admin</option>
                            </select>
                        </div>
                        <button type="button" class="btn" onclick="window.location = 'pengguna.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){
                            $nama =  ucwords($_POST['nama']);
                            $user = $_POST['username'];
                            $password = $_POST['password'];
                            $level = $_POST['level'];

                            $update =mysqli_query($conn, "UPDATE pengguna SET
                                    nama = '".$nama."',
                                    username = '".$user."',
                                    password = '".$password."',
                                    level = '".$level."'
                                    WHERE id = '".$_GET['id']."'
                            ");

                            if($update){
                                echo "<script>window.location='pengguna.php?success=Edit Data Berhasil'</script>";
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
   