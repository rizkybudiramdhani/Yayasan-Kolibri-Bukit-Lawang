<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box">
                <div class="box-header">
                    Rekomendasi
                </div>
                <div class="box-body">

                    <a href="tambah-rekomendasi.php" class="text-green"> <i class="fa fa-plus"> </i>Tambah Rekomendasi </a>

                    <?php

                        if(isset($_GET['approve'])){
                            $idApprove = (int) $_GET['approve'];
                            mysqli_query($conn, "UPDATE rekomendasi SET status = 'approved' WHERE id = $idApprove");
                            echo "<script>window.location = 'rekomendasi.php?success=Rekomendasi disetujui & tayang di halaman depan'</script>";
                            exit;
                        }

                        if(isset($_GET['success'])){
                            echo "<div class ='alert alert-success'>".htmlspecialchars($_GET['success'])."</div>";
                        }

                        $jumlahPending = mysqli_fetch_object(mysqli_query($conn, "SELECT COUNT(*) AS n FROM rekomendasi WHERE status = 'pending'"))->n;
                        if($jumlahPending > 0){
                            echo "<div class='alert alert-error'><i class='fa fa-bell'></i> Ada <strong>$jumlahPending</strong> rekomendasi baru dari pengunjung yang menunggu persetujuan.</div>";
                        }

                    ?>

                    <form action="" method="get">

                        <div class="input-group">
                            <input type="text" name="key" id="" placeholder="Pencarian">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>

                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Isi Rekomendasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                                $where = " WHERE 1=1";
                                if(isset($_GET['key'])){
                                    $where .= " AND nama LIKE '%".mysqli_real_escape_string($conn, $_GET['key'])."%' ";
                                }

                                $Rekomendasi = mysqli_query($conn,"SELECT * FROM rekomendasi $where ORDER BY status ASC, id DESC");
                                if(mysqli_num_rows($Rekomendasi) > 0){
                                    while($p = mysqli_fetch_array($Rekomendasi)){
                            ?>
                            <tr<?= $p['status'] === 'pending' ? ' class="row-pending"' : '' ?>>
                                <td><?= $no++?></td>
                                <td>
                                    <?php if(!empty($p['foto'])): ?>
                                        <img src="../img/rekomendasi/<?= htmlspecialchars($p['foto']) ?>" alt="" width="80px">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($p['nama'])?></td>
                                <td><?= nl2br(htmlspecialchars($p['isi']))?></td>
                                <td>
                                    <?php if($p['status'] === 'pending'): ?>
                                        <span class="badge-status badge-pending">Menunggu</span>
                                    <?php else: ?>
                                        <span class="badge-status badge-approved">Tayang</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($p['status'] === 'pending'): ?>
                                        <a href="rekomendasi.php?approve=<?= $p['id']?>" title="Setujui & Tayangkan" class="text-green"><i class="fa fa-check"></i></a>
                                    <?php endif; ?>
                                    <a href="edit-rekomendasi.php?id=<?= $p['id']?>" title="Edit Data" class="text-orange"><i class= "fa fa-edit"></i></a>
                                    <a href="hapus.php?idrekomendasi=<?= $p['id']?>"onclick="return confirm('Yakin Ingin Hapus')"  title="Hapus Data" class="text-red"><i class= "fa fa-times"></i></a>
                                </td>
                            </tr>

                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="6">Data Tidak Ada</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <style>
        .row-pending {
            background: #fff8e6;
        }
        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 600;
        }
        .badge-pending {
            background: #FFF3CD;
            color: #8A6D00;
        }
        .badge-approved {
            background: #D4EDDA;
            color: #155724;
        }
    </style>

<?php include 'footer.php'?>
