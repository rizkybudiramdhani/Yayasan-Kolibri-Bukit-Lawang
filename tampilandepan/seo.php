<?php
/**
 * Title & meta description per halaman, per bahasa.
 *
 * Panduan menulis:
 * - Title  : ±50–60 karakter, kata kunci utama di depan, nama brand di belakang.
 * - Desc   : ±140–160 karakter, kalimat ajakan yang bikin orang mau klik.
 * - Tiap halaman WAJIB beda; title/desc kembar membuat Google sulit membedakan halaman.
 *
 * Halaman bisa menimpa nilai ini dengan mengisi $pageTitle / $pageDesc
 * SEBELUM include t_header.php (contoh: detail-berita.php).
 */

// define() dengan guard supaya aman kalau file ini ter-include lebih dari sekali
if (!defined('SITE_URL'))  define('SITE_URL', 'https://yayasankolibri.com');
if (!defined('SITE_NAME')) define('SITE_NAME', 'Yayasan Kolibri Bukit Lawang');

return [
    'index.php' => [
        'in' => [
            'title' => 'Yayasan Kolibri Bukit Lawang – Sponsor Pendidikan Anak',
            'desc'  => 'Sejak 2018 Yayasan Kolibri membantu anak-anak kurang mampu di Bukit Lawang, Sumatera Utara, agar tetap sekolah. Jadi sponsor, donasi, atau ikut kegiatan kami.',
        ],
        'en' => [
            'title' => 'Kolibri Foundation Bukit Lawang – Sponsor a Child\'s Education',
            'desc'  => 'Since 2018, Kolibri Foundation has helped underprivileged children in Bukit Lawang, North Sumatra, stay in school. Sponsor a child, donate, or visit us.',
        ],
    ],
    'tentang.php' => [
        'in' => [
            'title' => 'Tentang Kami – Yayasan Kolibri Bukit Lawang',
            'desc'  => 'Kenali sejarah, visi misi, dan tim Yayasan Kolibri Bukit Lawang: rumah belajar bahasa Inggris, musik, dan olahraga untuk anak-anak di sekitar Bukit Lawang.',
        ],
        'en' => [
            'title' => 'About Us – Kolibri Foundation Bukit Lawang',
            'desc'  => 'Meet the Kolibri Foundation team in Bukit Lawang: a learning house where local children study English, music and sports, and get support to stay in school.',
        ],
    ],
    'berita.php' => [
        'in' => [
            'title' => 'Jungle Trekking & Kegiatan di Bukit Lawang – Yayasan Kolibri',
            'desc'  => 'Jungle trekking, rafting, BBQ di tepi sungai, hingga cooking class di Bukit Lawang. Setiap tur yang dipesan lewat Yayasan Kolibri ikut membiayai sekolah anak-anak.',
        ],
        'en' => [
            'title' => 'Jungle Trekking & Things to Do in Bukit Lawang – Kolibri',
            'desc'  => 'Jungle trekking, river tubing, riverside BBQ and cooking classes in Bukit Lawang. Every tour booked through Kolibri Foundation helps local children stay in school.',
        ],
    ],
    'foto.php' => [
        'in' => [
            'title' => 'Galeri Foto Kegiatan – Yayasan Kolibri Bukit Lawang',
            'desc'  => 'Lihat momen anak-anak Yayasan Kolibri: belajar bersama, tari tradisional, olahraga dengan wisatawan, dan kegiatan sehari-hari di Bukit Lawang.',
        ],
        'en' => [
            'title' => 'Photo Gallery – Kolibri Foundation Bukit Lawang',
            'desc'  => 'Photos of the children at Kolibri Foundation: studying together, traditional dance, sports with visitors and everyday life in Bukit Lawang.',
        ],
    ],
    'video.php' => [
        'in' => [
            'title' => 'Video Kegiatan – Yayasan Kolibri Bukit Lawang',
            'desc'  => 'Tonton video kegiatan Yayasan Kolibri dan wisata Bukit Lawang: jungle trekking, rafting tradisional, pemantauan satwa liar, dan kesenian anak-anak.',
        ],
        'en' => [
            'title' => 'Activity Videos – Kolibri Foundation Bukit Lawang',
            'desc'  => 'Watch videos of Kolibri Foundation and Bukit Lawang: jungle trekking, traditional rafting, wildlife monitoring and the children\'s art performances.',
        ],
    ],
    'donate.php' => [
        'in' => [
            'title' => 'Donasi & Sponsor Anak Sekolah – Yayasan Kolibri Bukit Lawang',
            'desc'  => 'Donasi mulai 10 euro atau jadi sponsor mulai 20 euro per bulan untuk membiayai seragam, buku, transportasi, dan SPP anak-anak di Bukit Lawang.',
        ],
        'en' => [
            'title' => 'Donate or Sponsor a Child – Kolibri Foundation Bukit Lawang',
            'desc'  => 'Donate from 10 euros or sponsor a child from 20 euros a month to cover uniforms, books, transport and school fees for children in Bukit Lawang.',
        ],
    ],
    'kontak.php' => [
        'in' => [
            'title' => 'Kontak – Yayasan Kolibri Bukit Lawang',
            'desc'  => 'Hubungi Yayasan Kolibri di Perumahan Wisata Bukit Lawang Blok E19, Sumatera Utara, lewat WhatsApp atau email untuk donasi, sponsor, atau booking tur.',
        ],
        'en' => [
            'title' => 'Contact – Kolibri Foundation Bukit Lawang',
            'desc'  => 'Contact Kolibri Foundation in Bukit Lawang, North Sumatra, via WhatsApp or email to donate, sponsor a child, volunteer or book a jungle trek.',
        ],
    ],
];
