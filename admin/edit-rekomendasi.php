<?php include 'header.php'?>
<!-- content -->

<?php

    $idRekomendasi = (int) ($_GET['id'] ?? 0);
    $Rekomendasi = mysqli_query($conn, "SELECT * FROM rekomendasi WHERE id = $idRekomendasi");

    if(mysqli_num_rows($Rekomendasi) == 0){
        echo "<script>window.location = 'rekomendasi.php'</script>";
        exit;
    }
    $p = mysqli_fetch_object($Rekomendasi);

?>
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Edit Rekomendasi
                </div>
                <div class="box-body">
                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars($p->nama) ?>" id="nama" placeholder="nama" class="input-control" required>
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi Rekomendasi</label>
                            <textarea name="isi" id="isi" placeholder="isi rekomendasi" class="input-control" required><?= htmlspecialchars($p->isi) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Foto (opsional, JPG/PNG/GIF, maks 2MB)</label>
                            <?php if(!empty($p->foto)): ?>
                                <img src="../img/rekomendasi/<?= htmlspecialchars($p->foto) ?>" alt="" width="120px" class="image">
                            <?php endif; ?>
                            <input type="file" name="gambar" id="gambar" class="input-control">
                            <div class="alert alert-error" id="pesanFotoBesar" style="display:none; margin-top:8px;"></div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="input-control">
                                <option value="approved" <?= $p->status === 'approved' ? 'selected' : '' ?>>Tayang di halaman depan</option>
                                <option value="pending" <?= $p->status === 'pending' ? 'selected' : '' ?>>Menunggu persetujuan (disembunyikan)</option>
                            </select>
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
                            $rename = $p->foto;

                            if(!empty($_FILES['gambar']['name'])){
                                $hasilFoto = simpan_foto_rekomendasi($_FILES['gambar'], '../img/rekomendasi');

                                if ($hasilFoto['error'] !== null) {
                                    echo '<div class="alert alert-error">' . htmlspecialchars($hasilFoto['error']) . '</div>';
                                } else {
                                    if(nama_foto_rekomendasi_valid($p->foto) && file_exists("../img/rekomendasi/".$p->foto)){
                                        unlink("../img/rekomendasi/".$p->foto);
                                    }
                                    $rename = $hasilFoto['filename'];
                                }
                            }

                            $rename = empty($rename) ? null : $rename;
                            $status = ($_POST['status'] ?? '') === 'pending' ? 'pending' : 'approved';

                            $stmt = mysqli_prepare($conn, "UPDATE rekomendasi SET nama = ?, isi = ?, foto = ?, status = ? WHERE id = ?");
                            mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $isi, $rename, $status, $idRekomendasi);
                            $update = mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);

                            if($update){
                                echo "<script>window.location='rekomendasi.php?success=Edit Data Berhasil'</script>";
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
