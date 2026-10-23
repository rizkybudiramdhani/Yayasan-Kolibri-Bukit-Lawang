<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Tambah Rekomendasi
                </div>
                <div class="box-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="formTambahRekomendasi">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" placeholder="Nama Pemberi Rekomendasi" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi Rekomendasi</label>
                            <textarea name="isi" id="isi" placeholder="Isi Rekomendasi" class="input-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Foto (opsional, JPG/PNG/GIF, maks 2MB)</label>
                            <input type="file" name="gambar" id="gambar" class="input-control">
                            <div class="alert alert-error" id="pesanFotoBesar" style="display:none; margin-top:8px;"></div>
                        </div>

                        <button type="button" class="btn" onclick="window.location = 'rekomendasi.php'">Kembali</button>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-blue" id="btnSimpanRekomendasi">
                    </form>

                    <script>
                        (function() {
                            var MAX_SIZE = 2 * 1024 * 1024; // 2MB, harus sama dengan limit di rekomendasi_foto_helper.php
                            var input = document.getElementById('gambar');
                            var pesan = document.getElementById('pesanFotoBesar');
                            var btnSimpan = document.getElementById('btnSimpanRekomendasi');

                            input.addEventListener('change', function() {
                                if (!input.files || !input.files[0]) {
                                    pesan.style.display = 'none';
                                    btnSimpan.disabled = false;
                                    return;
                                }

                                var file = input.files[0];

                                if (file.size > MAX_SIZE) {
                                    var ukuranMB = (file.size / (1024 * 1024)).toFixed(1);
                                    pesan.textContent = 'Ukuran foto terlalu besar (' + ukuranMB + ' MB). Maksimal 2MB.';
                                    pesan.style.display = 'block';
                                    btnSimpan.disabled = true;
                                } else {
                                    pesan.style.display = 'none';
                                    btnSimpan.disabled = false;
                                }
                            });
                        })();
                    </script>
                    <?php
                        if(isset($_POST['submit'])){
                            require_once '../rekomendasi_foto_helper.php';

                            $nama = mb_substr(ucwords(trim($_POST['nama'] ?? '')), 0, 50);
                            $isi  = trim($_POST['isi'] ?? '');

                            $hasilFoto = simpan_foto_rekomendasi($_FILES['gambar'] ?? [], '../img/rekomendasi');
                            $rename = $hasilFoto['filename'];

                            if ($hasilFoto['error'] !== null) {
                                echo '<div class="alert alert-error">' . htmlspecialchars($hasilFoto['error']) . '</div>';
                            }

                            if($rename !== null || empty($_FILES['gambar']['name'])){
                                $stmt = mysqli_prepare($conn, "INSERT INTO rekomendasi (nama, foto, isi, status) VALUES (?, ?, ?, 'approved')");
                                mysqli_stmt_bind_param($stmt, 'sss', $nama, $rename, $isi);
                                $simpan = mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                                if($simpan){
                                    echo "<script>window.location='rekomendasi.php?success=Berhasil Simpan'</script>";
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
