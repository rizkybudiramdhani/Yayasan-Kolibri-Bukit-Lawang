<?php
/*
 * ============================================================
 * SEMUA LOGIKA DI BLOK INI HARUS JALAN SEBELUM ADA OUTPUT HTML.
 * session_start() dan setcookie() mengirim HTTP header; begitu satu karakter
 * HTML terkirim, keduanya gagal ("headers already sent"). Dulu setcookie bahasa
 * dipanggil setelah top bar ter-render, sehingga pilihan bahasa tidak pernah
 * tersimpan (ribuan baris warning di error_log).
 * ============================================================
 */
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../koneksi.php';
include_once __DIR__ . '/../track_visit.php';

/* ---------- Bahasa ---------- */
// Whitelist: nilai dari URL/cookie tidak boleh langsung jadi path file.
// Dulu ?lang= dipakai bot untuk mencoba SQL injection / path traversal.
$bahasaDidukung = ['in', 'en'];

$lang = 'in';
if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $bahasaDidukung, true)) {
    $lang = $_COOKIE['lang'];
}
if (isset($_GET['lang']) && in_array($_GET['lang'], $bahasaDidukung, true)) {
    $lang = $_GET['lang'];
    $pakaiHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    setcookie('lang', $lang, time() + (86400 * 30), '/', '', $pakaiHttps, true);
}
$language = parse_ini_file(__DIR__ . "/../lang/$lang.ini");

/* ---------- SEO: title, description, canonical, hreflang ---------- */
$seoKonfigurasi = include __DIR__ . '/seo.php';
$seoHalaman     = basename($_SERVER['SCRIPT_NAME']);
$seoDefault     = $seoKonfigurasi['index.php'][$lang];
$seoData        = $seoKonfigurasi[$seoHalaman][$lang] ?? $seoDefault;

// Halaman boleh menimpa (mis. detail-berita.php pakai judul artikel)
$seoTitle = $pageTitle ?? $seoData['title'];
$seoDesc  = $pageDesc  ?? $seoData['desc'];

// Hanya parameter yang memang mengubah isi halaman yang ikut ke URL kanonik.
// Parameter lain (utm_, fbclid, dll.) dibuang supaya tidak jadi duplikat di Google.
$seoParam = [];
foreach (['id', 'page'] as $kunci) {
    if (isset($_GET[$kunci]) && (int) $_GET[$kunci] > 0) {
        $seoParam[$kunci] = (int) $_GET[$kunci];
    }
}
if (($seoParam['page'] ?? 0) === 1) {
    unset($seoParam['page']); // video.php?page=1 sama dengan video.php
}

/**
 * URL halaman ini untuk bahasa tertentu.
 * Versi Indonesia = URL bersih (default), versi Inggris = ?lang=en.
 * $absolut=true untuk tag <link>, false untuk link biasa di navigasi.
 */
function url_halaman_bahasa(string $kodeBahasa, bool $absolut = true, bool $paksaParamLang = false): string
{
    global $seoHalaman, $seoParam;

    $path  = ($seoHalaman === 'index.php') ? '/' : '/' . $seoHalaman;
    $param = $seoParam;
    if ($kodeBahasa === 'en' || $paksaParamLang) {
        $param['lang'] = $kodeBahasa;
    }
    $url = $path . ($param ? '?' . http_build_query($param) : '');

    return $absolut ? SITE_URL . $url : $url;
}

$seoCanonical = url_halaman_bahasa($lang);
$seoOgImage   = SITE_URL . '/img/slide.jpg';
$e = function ($teks) { return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8'); };
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'id' ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $e($seoTitle) ?></title>
    <meta name="description" content="<?= $e($seoDesc) ?>">

    <!-- Canonical & versi bahasa: memberi tahu Google URL resmi tiap halaman & pasangan bahasanya -->
    <link rel="canonical" href="<?= $e($seoCanonical) ?>">
    <link rel="alternate" hreflang="id" href="<?= $e(url_halaman_bahasa('in')) ?>">
    <link rel="alternate" hreflang="en" href="<?= $e(url_halaman_bahasa('en')) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= $e(url_halaman_bahasa('in')) ?>">

    <!-- Open Graph: tampilan kartu saat link dibagikan di WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= $e(SITE_NAME) ?>">
    <meta property="og:title" content="<?= $e($seoTitle) ?>">
    <meta property="og:description" content="<?= $e($seoDesc) ?>">
    <meta property="og:url" content="<?= $e($seoCanonical) ?>">
    <meta property="og:image" content="<?= $e($seoOgImage) ?>">
    <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'id_ID' ?>">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon: path absolut supaya tetap benar dari halaman/subfolder mana pun -->
    <link rel="icon" href="/img/icon.png" type="image/png" sizes="192x192">
    <link rel="apple-touch-icon" href="/img/icon.png">

<?php if ($seoHalaman === 'index.php'): ?>
    <!-- Data terstruktur: membantu Google mengenali ini sebagai organisasi nirlaba
         (nama, logo, alamat, kontak, media sosial) untuk hasil pencarian brand -->
    <script type="application/ld+json"><?= json_encode([
        '@context'      => 'https://schema.org',
        '@type'         => 'NGO',
        'name'          => SITE_NAME,
        'alternateName' => 'Kolibri Foundation Bukit Lawang',
        'url'           => SITE_URL . '/',
        'logo'          => SITE_URL . '/img/icon.png',
        'image'         => $seoOgImage,
        'description'   => $seoKonfigurasi['index.php']['in']['desc'],
        'foundingDate'  => '2018',
        'email'         => 'yusufsihotang70@gmail.com',
        'telephone'     => '+62-852-9724-3719',
        'address'       => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Perumahan Wisata Bukit Lawang, Blok E19',
            'addressLocality' => 'Bukit Lawang',
            'addressRegion'   => 'Sumatera Utara',
            'postalCode'      => '20774',
            'addressCountry'  => 'ID',
        ],
        'sameAs' => [
            'https://www.facebook.com/people/Yayasan-Kolibri-Bukit-Lawang-New/100091601498368/',
            'https://www.instagram.com/yayasan_kolibri_bukit_lawang',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endif; ?>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <!-- Top Bar Start -->
    <div class="top-bar d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="top-bar-left">

                        <!-- Link bahasa kini mempertahankan halaman & parameter yang sedang dibuka
                             (dulu ?lang=en di detail-berita.php?id=5 menghilangkan id-nya) -->
                        <a href="<?= $e(url_halaman_bahasa('in', false, true)) ?>" hreflang="id"> <img src="img/indonesia-flag.png" alt="Bahasa Indonesia"> </a> ||
                        <a href="<?= $e(url_halaman_bahasa('en', false)) ?>" hreflang="en"> <img src="img/us-of-america.png" alt="English"></a>

                        <div class="text">
                            <i class="fa fa-phone-alt"></i>
                            <p>+62-8529-7243-719</p>
                        </div>
                        <div class="text">
                            <i class="fa fa-phone-alt"></i>
                            <p>+62-851-6160-2446</p>
                        </div>
                        <div class="text">
                            <i class="fa fa-envelope"></i>
                            <p>yusufsihotang70@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="top-bar-right">
                        <div class="social">
                            <a href="https://www.facebook.com/people/Yayasan-Kolibri-Bukit-Lawang-New/100091601498368/" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/yayasan_kolibri_bukit_lawang?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" aria-label="Instagram"><i class="fab fa-instagram"></i></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
