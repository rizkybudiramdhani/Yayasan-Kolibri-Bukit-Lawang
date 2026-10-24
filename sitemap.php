<?php
/**
 * Sitemap dinamis, diakses lewat /sitemap.xml (lihat rewrite di .htaccess).
 *
 * Kenapa diganti dari sitemap.xml statis:
 * - Namespace lama salah (skema image-sitemap), sehingga berisiko ditolak Google.
 * - Semua URL lama pakai http://www., padahal situs live di https://yayasankolibri.com
 *   (setiap URL jadi redirect, sinyal yang buruk untuk crawler).
 * - lastmod macet di 2023. Sekarang diambil dari waktu file halaman terakhir diubah.
 * - Ada pasangan bahasa (hreflang) supaya versi Inggris ikut terindeks.
 */
$seoKonfigurasi = include __DIR__ . '/tampilandepan/seo.php';

// Urutan = prioritas kepentingan halaman
$halaman = [
    'index.php'   => '1.0',
    'donate.php'  => '0.9',
    'berita.php'  => '0.8',
    'tentang.php' => '0.8',
    'kontak.php'  => '0.7',
    'foto.php'    => '0.6',
    'video.php'   => '0.6',
];

// Artikel diambil dari database supaya setiap berita baru otomatis masuk sitemap.
// Kalau database bermasalah, sitemap tetap keluar (berisi halaman statis saja).
$artikelIds = [];
try {
    include_once __DIR__ . '/koneksi.php';
    if (isset($conn) && $conn) {
        $hasil = mysqli_query($conn, 'SELECT id FROM berita ORDER BY id DESC');
        while ($hasil && ($baris = mysqli_fetch_row($hasil))) {
            $artikelIds[] = (int) $baris[0];
        }
    }
} catch (Throwable $err) {
    error_log('sitemap: gagal mengambil artikel - ' . $err->getMessage());
}

$urlHalaman = function (string $file, string $bahasa): string {
    $path = ($file === 'index.php') ? '/' : '/' . $file;
    return SITE_URL . $path . ($bahasa === 'en' ? '?lang=en' : '');
};
$x = function (string $teks): string { return htmlspecialchars($teks, ENT_XML1 | ENT_QUOTES, 'UTF-8'); };

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($halaman as $file => $prioritas):
    $lastmod = date('Y-m-d', (int) @filemtime(__DIR__ . '/' . $file));
    foreach (['in', 'en'] as $bahasa): ?>
    <url>
        <loc><?= $x($urlHalaman($file, $bahasa)) ?></loc>
        <lastmod><?= $lastmod ?></lastmod>
        <priority><?= $bahasa === 'in' ? $prioritas : number_format((float) $prioritas - 0.1, 1) ?></priority>
        <xhtml:link rel="alternate" hreflang="id" href="<?= $x($urlHalaman($file, 'in')) ?>"/>
        <xhtml:link rel="alternate" hreflang="en" href="<?= $x($urlHalaman($file, 'en')) ?>"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="<?= $x($urlHalaman($file, 'in')) ?>"/>
    </url>
<?php endforeach; endforeach; ?>
<?php foreach ($artikelIds as $idArtikel):
    $urlId = SITE_URL . '/detail-berita.php?id=' . $idArtikel;
    $urlEn = $urlId . '&lang=en';
    foreach ([$urlId, $urlEn] as $urlArtikel): ?>
    <url>
        <loc><?= $x($urlArtikel) ?></loc>
        <priority>0.6</priority>
        <xhtml:link rel="alternate" hreflang="id" href="<?= $x($urlId) ?>"/>
        <xhtml:link rel="alternate" hreflang="en" href="<?= $x($urlEn) ?>"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="<?= $x($urlId) ?>"/>
    </url>
<?php endforeach; endforeach; ?>
</urlset>
