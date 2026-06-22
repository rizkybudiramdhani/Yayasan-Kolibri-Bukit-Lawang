# Yayasan Kolibri — Website Resmi

Website profil dan donasi resmi Yayasan Kolibri. Dibangun di atas template **HELPZ** oleh [HTML Codex](https://htmlcodex.com) dan dikembangkan dengan PHP + MySQL.

## Fitur

- **Beranda** — slider, profil singkat yayasan, dan statistik kegiatan
- **Berita** — daftar dan detail artikel berita kegiatan yayasan
- **Galeri Foto** — dokumentasi foto kegiatan
- **Video** — embed video kegiatan
- **Donasi** — halaman informasi donasi
- **Kontak** — formulir kontak
- **Panel Admin** — manajemen konten (berita, foto, video, pengguna)

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | PHP (prosedural) |
| Database | MySQL (MySQLi) |
| Frontend | Bootstrap 4, jQuery, HTML/CSS |
| Template dasar | [HELPZ - Free Charity Website Template](https://htmlcodex.com/free-charity-website-template) |
| Server lokal | Laragon (Windows) |

## Struktur Direktori

```
kolibri/
├── admin/              # Panel admin (CRUD berita, foto, video, pengguna)
├── css/                # Stylesheet kustom
├── img/                # Aset gambar statis
├── js/                 # JavaScript
├── lang/               # File bahasa
├── lib/                # Library vendor (Bootstrap, jQuery, dll.)
├── mail/               # Konfigurasi pengiriman email
├── tampilandepan/      # Partial views halaman depan (header, navbar, dll.)
├── index.php           # Halaman utama
├── berita.php          # Daftar berita
├── detail-berita.php   # Detail artikel berita
├── foto.php            # Galeri foto
├── video.php           # Halaman video
├── donate.php          # Halaman donasi
├── kontak.php          # Halaman kontak
├── tentang.php         # Halaman tentang yayasan
├── login.php           # Login admin
└── koneksi.php         # Konfigurasi koneksi DB (tidak di-commit — lihat setup)
```

## Setup Lokal

### Prasyarat

- PHP >= 7.4
- MySQL >= 5.7
- Web server (Laragon / XAMPP / WAMP)

### Langkah Instalasi

1. **Clone repositori**
   ```bash
   git clone <url-repo> kolibri
   ```

2. **Import database**
   Buat database baru di MySQL, lalu import skema:
   ```bash
   mysql -u <username> -p <nama_database> < kolibri.sql
   ```
   > File `kolibri.sql` tidak disertakan di repositori karena berisi data sensitif.
   > Minta file ini dari pengelola proyek.

3. **Buat file koneksi**
   Buat file `koneksi.php` di root proyek (file ini tidak di-commit):
   ```php
   <?php
   $conn = mysqli_connect('localhost', 'DB_USER', 'DB_PASS', 'DB_NAME')
       or die('Gagal terhubung ke database');
   ```
   Ganti `DB_USER`, `DB_PASS`, dan `DB_NAME` sesuai konfigurasi lokal kamu.

4. **Jalankan via web server**
   Letakkan folder `kolibri/` di dalam direktori `www/` atau `htdocs/`, lalu akses:
   ```
   http://localhost/kolibri/
   ```

## Kredit

Template: [HELPZ - Free Charity Website Template](https://htmlcodex.com/free-charity-website-template) oleh [HTML Codex](https://htmlcodex.com)
Lisensi template: [htmlcodex.com/license](https://htmlcodex.com/license)

## Lisensi

Proyek ini menggunakan template dengan lisensi dari HTML Codex. Kode kustom (PHP, integrasi DB, panel admin) adalah milik Yayasan Kolibri.
