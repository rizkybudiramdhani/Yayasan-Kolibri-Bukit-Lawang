<?php include 'header.php'?>
<!-- content -->
    <div class="content">

        <div class ="container">
            <div class="box dash-box">
                <div class="box-header">
                    Dashboard
                </div>
                <div class="box-body">
                    <div class="dash-welcome">
                        <h3>Selamat Datang, <span><?= $_SESSION['uname']?></span> 👋</h3>
                        <p>Berikut ringkasan aktivitas pengunjung website Yayasan Kolibri.</p>
                    </div>

                    <?php
                        $bulanIni = mysqli_query($conn, "
                            SELECT COUNT(*) AS total_visit, COUNT(DISTINCT ip_address) AS total_unik
                            FROM page_visits
                            WHERE MONTH(visited_at) = MONTH(CURDATE()) AND YEAR(visited_at) = YEAR(CURDATE())
                        ");
                        $bulanIni = mysqli_fetch_object($bulanIni);

                        $semua = mysqli_query($conn, "
                            SELECT COUNT(*) AS total_visit, COUNT(DISTINCT ip_address) AS total_unik
                            FROM page_visits
                        ");
                        $semua = mysqli_fetch_object($semua);
                    ?>

                    <div class="stat-grid">
                        <div class="stat-card stat-accent-blue">
                            <div class="stat-icon"><i class="fa fa-user-friends"></i></div>
                            <div class="stat-body">
                                <div class="stat-number"><?= (int) $bulanIni->total_unik ?></div>
                                <div class="stat-label">Pengunjung Bulan Ini</div>
                            </div>
                        </div>
                        <div class="stat-card stat-accent-green">
                            <div class="stat-icon"><i class="fa fa-eye"></i></div>
                            <div class="stat-body">
                                <div class="stat-number"><?= (int) $bulanIni->total_visit ?></div>
                                <div class="stat-label">Kunjungan Halaman Bulan Ini</div>
                            </div>
                        </div>
                        <div class="stat-card stat-accent-orange">
                            <div class="stat-icon"><i class="fa fa-globe"></i></div>
                            <div class="stat-body">
                                <div class="stat-number"><?= (int) $semua->total_unik ?></div>
                                <div class="stat-label">Pengunjung Sepanjang Waktu</div>
                            </div>
                        </div>
                        <div class="stat-card stat-accent-purple">
                            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
                            <div class="stat-body">
                                <div class="stat-number"><?= (int) $semua->total_visit ?></div>
                                <div class="stat-label">Total Kunjungan Sepanjang Waktu</div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-section">
                        <h3 class="stat-subtitle"><i class="fa fa-chart-bar"></i> Grafik Pengunjung Per Bulan <span>6 bulan terakhir</span></h3>

                        <?php
                            $bulanan = mysqli_query($conn, "
                                SELECT DATE_FORMAT(visited_at, '%Y-%m') AS bulan,
                                       COUNT(DISTINCT ip_address) AS unik,
                                       COUNT(*) AS total
                                FROM page_visits
                                WHERE visited_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                                GROUP BY bulan
                                ORDER BY bulan ASC
                            ");

                            $dataBulanan = [];
                            while ($b = mysqli_fetch_object($bulanan)) {
                                $dataBulanan[] = $b;
                            }

                            $maxUnik = 1;
                            foreach ($dataBulanan as $b) {
                                if ((int) $b->unik > $maxUnik) $maxUnik = (int) $b->unik;
                            }

                            $namaBulan = [
                                '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                                '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
                                '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
                            ];
                        ?>

                        <?php if (count($dataBulanan) > 0): ?>
                            <div class="chart-card">
                                <div class="chart-gridlines">
                                    <span></span><span></span><span></span><span></span>
                                </div>
                                <div class="chart-bulanan">
                                    <?php foreach ($dataBulanan as $b):
                                        $tahun = substr($b->bulan, 0, 4);
                                        $bulanKey = substr($b->bulan, 5, 2);
                                        $tinggiPersen = round(((int) $b->unik / $maxUnik) * 100);
                                    ?>
                                        <div class="chart-bar-col">
                                            <div class="chart-bar-value"><?= (int) $b->unik ?></div>
                                            <div class="chart-bar" style="height: <?= max($tinggiPersen, 4) ?>%;" title="<?= (int) $b->unik ?> pengunjung unik"></div>
                                            <div class="chart-bar-label"><?= $namaBulan[$bulanKey] ?? $bulanKey ?><br><small><?= $tahun ?></small></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="dash-empty">Belum ada data kunjungan untuk ditampilkan.</p>
                        <?php endif; ?>
                    </div>

                    <div class="dash-section">
                        <h3 class="stat-subtitle"><i class="fa fa-calendar-day"></i> Rincian Per Hari <span>bulan ini</span></h3>

                        <table class="table dash-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pengunjung Unik</th>
                                    <th>Total Kunjungan Halaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $harian = mysqli_query($conn, "
                                        SELECT DATE(visited_at) AS tanggal,
                                               COUNT(DISTINCT ip_address) AS unik,
                                               COUNT(*) AS total
                                        FROM page_visits
                                        WHERE MONTH(visited_at) = MONTH(CURDATE()) AND YEAR(visited_at) = YEAR(CURDATE())
                                        GROUP BY DATE(visited_at)
                                        ORDER BY tanggal DESC
                                    ");

                                    if (mysqli_num_rows($harian) > 0) {
                                        while ($h = mysqli_fetch_object($harian)) {
                                ?>
                                    <tr>
                                        <td><?= date('d-m-Y', strtotime($h->tanggal)) ?></td>
                                        <td><span class="pill pill-blue"><?= (int) $h->unik ?></span></td>
                                        <td><span class="pill pill-green"><?= (int) $h->total ?></span></td>
                                    </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                    <tr>
                                        <td colspan="3">Belum ada data kunjungan bulan ini</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <style>
        .dash-welcome h3 {
            font-size: 1.4rem;
            margin-bottom: 4px;
        }
        .dash-welcome h3 span {
            color: #3D550C;
        }
        .dash-welcome p {
            color: #777;
            margin-bottom: 0;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin: 24px 0 8px;
        }
        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            border-left: 5px solid transparent;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }
        .stat-accent-blue { border-left-color: #2E8BC0; }
        .stat-accent-green { border-left-color: #81B622; }
        .stat-accent-orange { border-left-color: #FF8300; }
        .stat-accent-purple { border-left-color: #8E44AD; }

        .stat-icon {
            flex: 0 0 52px;
            height: 52px;
            width: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
        }
        .stat-accent-blue .stat-icon { background: linear-gradient(135deg, #2E8BC0, #145DA0); }
        .stat-accent-green .stat-icon { background: linear-gradient(135deg, #81B622, #3D550C); }
        .stat-accent-orange .stat-icon { background: linear-gradient(135deg, #FFA500, #FF8300); }
        .stat-accent-purple .stat-icon { background: linear-gradient(135deg, #A569BD, #8E44AD); }

        .stat-number {
            font-size: 1.9rem;
            font-weight: 700;
            color: #222;
            line-height: 1.1;
        }
        .stat-label {
            font-size: .85rem;
            color: #777;
            margin-top: 2px;
        }

        .dash-section {
            margin-top: 32px;
        }
        .stat-subtitle {
            display: flex;
            align-items: baseline;
            gap: 10px;
            font-size: 1.1rem;
            margin-bottom: 14px;
            color: #333;
        }
        .stat-subtitle i {
            color: #81B622;
        }
        .stat-subtitle span {
            font-size: .8rem;
            font-weight: 400;
            color: #999;
        }

        .chart-card {
            position: relative;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            padding: 20px 12px 0;
        }
        .chart-gridlines {
            position: absolute;
            top: 20px;
            left: 12px;
            right: 12px;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none;
        }
        .chart-gridlines span {
            border-top: 1px dashed #eee;
        }
        .chart-bulanan {
            position: relative;
            display: flex;
            align-items: flex-end;
            gap: 16px;
            height: 220px;
            padding: 0 8px;
            overflow-x: auto;
            z-index: 1;
        }
        .chart-bar-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            flex: 1 0 64px;
            min-width: 64px;
            height: 100%;
        }
        .chart-bar-value {
            font-size: .85rem;
            font-weight: 700;
            color: #3D550C;
            margin-bottom: 6px;
        }
        .chart-bar {
            width: 34px;
            background: linear-gradient(180deg, #9ED12F 0%, #3D550C 100%);
            border-radius: 8px 8px 0 0;
            transition: transform .2s ease, box-shadow .2s ease, height .3s ease;
            box-shadow: 0 2px 6px rgba(61, 85, 12, 0.25);
        }
        .chart-bar:hover {
            transform: scaleY(1.02);
            box-shadow: 0 4px 12px rgba(61, 85, 12, 0.4);
            cursor: pointer;
        }
        .chart-bar-label {
            font-size: .8rem;
            color: #555;
            font-weight: 600;
            margin-top: 10px;
            text-align: center;
            white-space: nowrap;
            padding-bottom: 14px;
        }
        .chart-bar-label small {
            color: #aaa;
            font-weight: 400;
        }
        .dash-empty {
            background: #fafafa;
            border-radius: 10px;
            padding: 24px;
            text-align: center;
            color: #999;
        }

        .dash-table {
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            overflow: hidden;
        }
        .pill {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: .85rem;
        }
        .pill-blue { background: #E3F2FD; color: #145DA0; }
        .pill-green { background: #EAF5DA; color: #3D550C; }
    </style>

<?php include 'footer.php'?>
