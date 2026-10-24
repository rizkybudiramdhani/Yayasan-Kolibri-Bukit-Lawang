<?php
/**
 * Daftar artikel/berita dari tabel `berita`, menaut ke detail-berita.php.
 *
 * Kenapa penting untuk SEO: sebelumnya halaman detail-berita.php tidak ditautkan
 * dari mana pun, sehingga Google tidak punya jalan untuk menemukan artikelnya.
 * Setiap artikel yang ditautkan = satu halaman lagi yang bisa muncul di Google.
 *
 * Cara pakai (set sebelum include):
 *   $artikelBatas    = jumlah artikel per tampilan (default 9)
 *   $artikelPaginasi = true untuk menampilkan navigasi halaman (?page=)
 * Jika tabel berita kosong, section ini tidak ditampilkan sama sekali.
 */
include_once __DIR__ . '/../koneksi.php';

$artikelBatas    = isset($artikelBatas) ? max(1, (int) $artikelBatas) : 9;
$artikelPaginasi = $artikelPaginasi ?? false;
$artikelHalaman  = $artikelPaginasi ? max(1, (int) ($_GET['page'] ?? 1)) : 1;

if (!function_exists('ringkas_teks')) {
    /** Potong teks bersih (tanpa tag & spasi berlebih) jadi ringkasan pendek. */
    function ringkas_teks(string $teks, int $panjang = 140): string
    {
        $bersih = trim(preg_replace('/\s+/u', ' ', strip_tags($teks)));
        return mb_strimwidth($bersih, 0, $panjang, '…', 'UTF-8');
    }
}

$artikelTotal = (int) mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM berita'))[0];
$artikelList  = [];

if ($artikelTotal > 0) {
    $jumlahHalaman  = (int) ceil($artikelTotal / $artikelBatas);
    $artikelHalaman = min($artikelHalaman, $jumlahHalaman);
    $offset         = ($artikelHalaman - 1) * $artikelBatas;

    $stmt = mysqli_prepare($conn, 'SELECT id, judul, keterangan, gambar FROM berita ORDER BY id DESC LIMIT ? OFFSET ?');
    mysqli_stmt_bind_param($stmt, 'ii', $artikelBatas, $offset);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $aId, $aJudul, $aIsi, $aGambar);
    while (mysqli_stmt_fetch($stmt)) {
        $artikelList[] = ['id' => $aId, 'judul' => $aJudul, 'isi' => $aIsi, 'gambar' => $aGambar];
    }
    mysqli_stmt_close($stmt);
}

$h = function ($t) { return htmlspecialchars((string) $t, ENT_QUOTES, 'UTF-8'); };
// Bahasa ikut dibawa di link, supaya pengunjung/Google versi Inggris tetap di versi Inggris
$artikelParamBahasa = (isset($lang) && $lang === 'en') ? '&lang=en' : '';
?>
<?php if ($artikelList): ?>
<section class="artikel">
    <div class="container">
        <div class="section-header text-center">
            <p><?= $h($language['artikel_label']) ?></p>
            <h2><?= $h($language['artikel_judul']) ?></h2>
        </div>

        <div class="artikel-grid">
            <?php foreach ($artikelList as $a):
                $urlArtikel = 'detail-berita.php?id=' . (int) $a['id'] . $artikelParamBahasa; ?>
            <article class="artikel-card">
                <a href="<?= $h($urlArtikel) ?>" class="artikel-gambar" tabindex="-1" aria-hidden="true">
                    <img src="img/upload/<?= $h(rawurlencode($a['gambar'])) ?>" alt="<?= $h($a['judul']) ?>" loading="lazy">
                </a>
                <div class="artikel-isi">
                    <h3><a href="<?= $h($urlArtikel) ?>"><?= $h($a['judul']) ?></a></h3>
                    <p><?= $h(ringkas_teks($a['isi'])) ?></p>
                    <a href="<?= $h($urlArtikel) ?>" class="artikel-lanjut">
                        <?= $h($language['artikel_baca']) ?> <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <?php if ($artikelPaginasi && $jumlahHalaman > 1): ?>
        <nav class="artikel-paginasi" aria-label="Navigasi halaman berita">
            <?php if ($artikelHalaman > 1): ?>
                <a href="berita.php?page=<?= $artikelHalaman - 1 . $h($artikelParamBahasa) ?>" rel="prev">&laquo; <?= $h($language['artikel_sebelumnya']) ?></a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <?php if ($i === $artikelHalaman): ?>
                    <span aria-current="page"><?= $i ?></span>
                <?php else: ?>
                    <a href="berita.php?page=<?= $i . $h($artikelParamBahasa) ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($artikelHalaman < $jumlahHalaman): ?>
                <a href="berita.php?page=<?= $artikelHalaman + 1 . $h($artikelParamBahasa) ?>" rel="next"><?= $h($language['artikel_berikutnya']) ?> &raquo;</a>
            <?php endif; ?>
        </nav>
        <?php elseif (!$artikelPaginasi && $artikelTotal > count($artikelList)): ?>
        <div class="text-center artikel-semua">
            <a href="berita.php<?= $artikelParamBahasa ? '?lang=en' : '' ?>" class="btn btn-custom"><?= $h($language['artikel_semua']) ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.artikel { padding: 45px 0 15px; }

.artikel-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

@media (max-width: 991px) { .artikel-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 575px) { .artikel-grid { grid-template-columns: 1fr; gap: 20px; } }

.artikel-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 10px;
    overflow: hidden;
    transition: transform .25s ease, box-shadow .25s ease;
}

.artikel-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
}

.artikel-gambar {
    display: block;
    aspect-ratio: 16 / 10;
    background: #eef2ea;
    overflow: hidden;
}

.artikel-gambar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.artikel-card:hover .artikel-gambar img { transform: scale(1.04); }

.artikel-isi {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 18px 20px 20px;
}

.artikel-isi h3 {
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.35;
    margin-bottom: 10px;
}

.artikel-isi h3 a { color: #4a4c70; }
.artikel-isi h3 a:hover { color: #75975e; text-decoration: none; }

.artikel-isi p {
    color: #666;
    font-size: .95rem;
    line-height: 1.6;
    margin-bottom: 16px;
}

.artikel-lanjut {
    margin-top: auto;
    font-weight: 600;
    color: #75975e;
}

.artikel-lanjut:hover { color: #5a7a47; text-decoration: none; }
.artikel-lanjut i { font-size: .8em; margin-left: 4px; transition: margin .2s ease; }
.artikel-lanjut:hover i { margin-left: 8px; }

.artikel-semua { margin-top: 30px; }

.artikel-paginasi {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
    margin-top: 35px;
}

.artikel-paginasi a,
.artikel-paginasi span {
    min-width: 42px;
    padding: 8px 14px;
    border-radius: 6px;
    border: 1px solid #ddd;
    text-align: center;
    color: #4a4c70;
}

.artikel-paginasi a:hover { border-color: #75975e; color: #75975e; text-decoration: none; }
.artikel-paginasi span[aria-current] { background: #75975e; border-color: #75975e; color: #fff; }

@media (prefers-reduced-motion: reduce) {
    .artikel-card, .artikel-gambar img, .artikel-lanjut i { transition: none; }
    .artikel-card:hover, .artikel-card:hover .artikel-gambar img { transform: none; }
}
</style>
<?php endif; ?>
