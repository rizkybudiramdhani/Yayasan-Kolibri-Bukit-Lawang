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
                            require_once __DIR__ . '/../auth_helper.php';

                            $nama     = ucwords(trim((string) $_POST['nama']));
                            $user     = trim((string) $_POST['username']);
                            $password = (string) $_POST['password'];
                            // Kolom level ENUM('admin'): whitelist, jangan percaya nilai dari form
                            $level    = 'admin';

                            // Prepared statement menggantikan addslashes (yang bukan proteksi SQL injection yang benar)
                            $cek = mysqli_prepare($conn, "SELECT id FROM pengguna WHERE username = ? LIMIT 1");
                            mysqli_stmt_bind_param($cek, 's', $user);
                            mysqli_stmt_execute($cek);
                            mysqli_stmt_store_result($cek);
                            $sudahAda = mysqli_stmt_num_rows($cek) > 0;
                            mysqli_stmt_close($cek);

                            if ($sudahAda) {
                                echo '<div class="alert alert-error">Username sudah digunakan</div>';
                            } else {
                                $disimpan = siapkan_password_untuk_disimpan($conn, $password);
                                $simpan = mysqli_prepare($conn, "INSERT INTO pengguna (nama, username, password, level) VALUES (?, ?, ?, ?)");
                                mysqli_stmt_bind_param($simpan, 'ssss', $nama, $user, $disimpan, $level);

                                if (mysqli_stmt_execute($simpan)) {
                                    echo '<div class="alert alert-success"> Berhasil Simpan</div>';
                                    if (!kolom_password_siap($conn)) {
                                        echo '<div class="alert alert-error">Peringatan: password masih tersimpan tanpa enkripsi. Jalankan sql/migrasi-password.sql di phpMyAdmin.</div>';
                                    }
                                } else {
                                    // Detail error DB sengaja tidak ditampilkan ke layar
                                    error_log('Gagal tambah pengguna: ' . mysqli_error($conn));
                                    echo '<div class="alert alert-error">Gagal Simpan</div>';
                                }
                            }
                        }
                    
                    ?>

                </div>
            </div>
        </div>

    </div>
<?php include 'footer.php'?>
   