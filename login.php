<?php
session_start();
    include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylephp.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!--page login -->
    <div class="page-login">

        <!-- box -->
        <div class ="box box-login">

            <!-- box header -->
            <div class="box-header text-center">
                Login
            </div>
            <!-- box body -->
            <div class="box-body">
                <!-- form login -->
                <?php
                    if(isset($_GET['msg'])){
                        echo "<div class = 'alert alert-error'>".$_GET['msg']."</div>";
                    }
                ?>
                <form action="" method="POST">

                    <div class="form-group">
                        <label for="username"> Username</label>
                        <input type="text" name="username" placeholder ="Username" class="input-control">
                    </div>
                    <div class="form-group">
                        <label for="password"> Password</label>
                        <input type="password" name="password" placeholder ="Password" class="input-control">
                    </div>

                    <input type="submit" name="submit"value="Login" class="btn">
                </form>

                <?php
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user = mysqli_real_escape_string($conn, $_POST['username']);
                    $pass = mysqli_real_escape_string($conn, $_POST['password']);
                    
                    // Query untuk memverifikasi username dan password
                    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '".$user."' ");
                    if (mysqli_num_rows($cek) > 0) {
                        $d = mysqli_fetch_object($cek);
                        if ($pass == $d->password) {
                            // Jika login berhasil, simpan nama dan status login dalam sesi
                            $_SESSION['status_login'] = true;
                            $_SESSION['uid'] = $d->id;
                            $_SESSION['uname'] = $d->nama; // Menyimpan nama pengguna ke dalam sesi
                            $_SESSION['ulevel'] = $d->level;
                
                            echo "<script>window.location = 'admin/index.php'</script>";
                        } else {
                            echo '<div class="alert alert-error">Password Salah</div>';
                        }
                    } else {
                        echo '<div class="alert alert-error">Username tidak ditemukan</div>';
                    }
                }

                ?>
            </div>
            <!-- box-footer -->
            <div class="box-footer text-center">
                <a href="index.php">Halaman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>