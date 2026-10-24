<div class="contact">
            <div class="container">
                <div class="section-header text-center">
                    <p><?=$language["k"]  ?></p>
                    <h2><?=$language["kk"]  ?></h2>
                </div>
                <div class="contact-img">
                    <img src="img/contact.jpg" alt="<?= htmlspecialchars($language["alt_kontak"], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                </div>
                <div class="contact-form">
                    <div class="kontak-kirim-group">
                        <a href="https://wa.me/6285297243719?text=Hello%2C%20I%20would%20like%20to%20get%20in%20touch%20with%20Yayasan%20Kolibri" target="_blank" class="btn btn-custom" id="kirimWA">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                        <a href="https://mail.google.com/mail/?<?= htmlspecialchars(http_build_query([
                            'view' => 'cm',
                            'fs'   => 1,
                            'to'   => 'yusufsihotang70@gmail.com',
                            'su'   => 'Inquiry about Yayasan Kolibri',
                            'body' => 'Hello, I would like to get in touch with Yayasan Kolibri.',
                        ], '', '&', PHP_QUERY_RFC3986)) ?>" target="_blank" class="btn btn-custom" id="kirimEmail">
                            <i class="fa fa-envelope"></i> Hubungi via Email
                        </a>
                    </div>
                </div>
            </div>
        </div>

<style>
    .kontak-kirim-group {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .contact .contact-form .kontak-kirim-group .btn.btn-custom {
        width: auto;
        flex: 1 1 220px;
        max-width: 280px;
        text-align: center;
    }
</style>
