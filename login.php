<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/auth_helper.php';

/*
 * Proses login dijalankan SEBELUM ada output HTML apa pun.
 * Alasannya: session_regenerate_id() dan header('Location') sama-sama butuh
 * mengirim HTTP header, dan itu gagal kalau HTML sudah terkirim duluan.
 */
$pesanError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    // Prepared statement: input user tidak pernah ditempel langsung ke SQL
    $stmt = mysqli_prepare($conn, 'SELECT id, nama, password, level FROM pengguna WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    // bind_result dipakai (bukan get_result) karena get_result butuh driver mysqlnd
    // yang tidak selalu tersedia di shared hosting PHP 7
    mysqli_stmt_bind_result($stmt, $id, $nama, $hashTersimpan, $level);
    $pengguna = null;
    if (mysqli_stmt_fetch($stmt)) {
        $pengguna = (object) ['id' => $id, 'nama' => $nama, 'password' => (string) $hashTersimpan, 'level' => $level];
    }
    mysqli_stmt_close($stmt);

    if ($pengguna && verifikasi_password($password, $pengguna->password)) {
        // Upgrade otomatis: password lama (plaintext) → hash, kalau kolom sudah dimigrasi
        if (!password_sudah_di_hash($pengguna->password) && kolom_password_siap($conn)) {
            $hashBaru = password_hash($password, PASSWORD_DEFAULT);
            $upd = mysqli_prepare($conn, 'UPDATE pengguna SET password = ? WHERE id = ?');
            mysqli_stmt_bind_param($upd, 'si', $hashBaru, $pengguna->id);
            mysqli_stmt_execute($upd);
        }

        // Ganti session ID setelah login untuk mencegah session fixation
        session_regenerate_id(true);
        $_SESSION['status_login'] = true;
        $_SESSION['uid']    = $pengguna->id;
        $_SESSION['uname']  = $pengguna->nama;
        $_SESSION['ulevel'] = $pengguna->level;

        header('Location: admin/index.php');
        exit;
    }

    // Pesan sengaja disamakan: jangan beri tahu penyerang username mana yang valid
    $pesanError = 'Username atau password salah';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
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
                <?php if (isset($_GET['msg'])): ?>
                    <!-- htmlspecialchars mencegah XSS lewat parameter ?msg= -->
                    <div class="alert alert-error"><?= htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php if ($pesanError !== null): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($pesanError, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <!-- form login -->
                <form action="" method="POST">

                    <div class="form-group">
                        <label for="username"> Username</label>
                        <input type="text" name="username" id="username" placeholder="Username" class="input-control" autocomplete="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password"> Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="input-control" autocomplete="current-password" required>
                    </div>

                    <input type="submit" name="submit" value="Login" class="btn">
                </form>
            </div>
            <!-- box-footer -->
            <div class="box-footer text-center">
                <a href="index.php">Halaman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>
