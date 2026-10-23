<?php include 'header.php'?>
<!-- content -->

<?php
    require_once __DIR__ . '/../auth_helper.php';

    // Cast ke integer: menutup celah SQL injection lewat ?id=
    $idPengguna = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($conn, "SELECT id, nama, username, level FROM pengguna WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'i', $idPengguna);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pId, $pNama, $pUsername, $pLevel);
    $ditemukan = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$ditemukan) {
        echo "<script>window.location = 'pengguna.php'</script>";
        exit; // sebelumnya halaman tetap lanjut render dengan data kosong
    }

    $e = function ($nilai) { return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8'); };
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
                            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="input-control" value="<?= $e($pNama) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="input-control" value="<?= $e($pUsername) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <!-- Password lama TIDAK lagi dicetak ke HTML (dulu terlihat di view-source) -->
                            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengganti password" class="input-control" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select name="level" id="level" class="input-control" required>
                                <option value="">Pilih</option>
                                <option value="admin"<?= ($pLevel == 'admin') ? ' selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <button type="button" class="btn" onclick="window.location = 'pengguna.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){
                            $nama         = ucwords(trim((string) $_POST['nama']));
                            $user         = trim((string) $_POST['username']);
                            $passwordBaru = (string) ($_POST['password'] ?? '');
                            $level        = 'admin'; // satu-satunya nilai valid untuk ENUM('admin')

                            if ($passwordBaru === '') {
                                // Password tidak diubah
                                $update = mysqli_prepare($conn, "UPDATE pengguna SET nama = ?, username = ?, level = ? WHERE id = ?");
                                mysqli_stmt_bind_param($update, 'sssi', $nama, $user, $level, $idPengguna);
                            } else {
                                $disimpan = siapkan_password_untuk_disimpan($conn, $passwordBaru);
                                $update = mysqli_prepare($conn, "UPDATE pengguna SET nama = ?, username = ?, password = ?, level = ? WHERE id = ?");
                                mysqli_stmt_bind_param($update, 'ssssi', $nama, $user, $disimpan, $level, $idPengguna);
                            }

                            if (mysqli_stmt_execute($update)) {
                                echo "<script>window.location='pengguna.php?success=Edit Data Berhasil'</script>";
                            } else {
                                error_log('Gagal edit pengguna: ' . mysqli_error($conn));
                                echo '<div class="alert alert-error">Gagal Edit</div>';
                            }
                        }
                    ?>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
