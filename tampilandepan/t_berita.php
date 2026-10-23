<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) session_start();
include 'koneksi.php';
$tb = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 1 ");
$d = mysqli_fetch_object($tb);
$nama_admin = isset($_SESSION['uname']) ? $_SESSION['uname'] : 'Admin';
?>
<style>
    .blog-item {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .blog-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .blog-img {
        height: 220px;
        background-size: cover;
        background-position: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .blog-text {
        padding: 15px;
        background-color: #fff;
    }

    .blog-meta {
        padding: 10px 15px;
        background-color: #fafafa;
        border-top: 1px solid #eee;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Styling untuk Brosur Section */
    .brosur-section {
        width: 100%;
        background: #f5f5f5;
        padding: 60px 0;
        margin-bottom: 45px;
    }

    .brosur-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        text-align: center;
    }

    .brosur-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        cursor: zoom-in;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    @media (hover: hover) and (pointer: fine) {
        .brosur-image:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.22);
        }
    }

    .brosur-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 30px;
        overflow: hidden;
        cursor: zoom-out;
    }

    .brosur-lightbox.is-open {
        display: flex;
    }

    .brosur-lightbox img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 8px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
        cursor: zoom-in;
        touch-action: none;
        user-select: none;
        -webkit-user-drag: none;
        will-change: transform;
    }

    .brosur-lightbox img.is-zoomed {
        cursor: grab;
    }

    .brosur-lightbox img.is-zoomed.is-dragging {
        cursor: grabbing;
    }

    .brosur-lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 32px;
        line-height: 1;
        cursor: pointer;
        background: none;
        border: none;
    }

    .brosur-cta {
        margin-top: 30px;
    }

    .btn-tanya {
        display: inline-block;
        padding: 15px 40px;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #75975e 0%, #5a7a47 100%);
        border: none;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(117, 151, 94, 0.3);
        margin: 5px;
    }

    .btn-tanya:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(117, 151, 94, 0.4);
        color: #ffffff;
    }

    .btn-tanya i {
        margin-right: 8px;
    }

    /* Video Carousel Styling */
    .video-carousel-wrapper {
        margin: 40px 0;
        position: relative;
    }

    .video-carousel {
        margin: 0 auto;
        max-width: 900px;
    }

    .video-item {
        padding: 0 15px;
    }

    .video-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        background-color: #000;
    }

    .local-video {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        object-fit: cover;
        background-color: #000;
    }

    .video-description {
        padding: 20px;
        text-align: left;
    }

    .video-description h4 {
        font-size: 18px;
        font-weight: 600;
        color: #4a4c70;
        margin-bottom: 10px;
    }

    .video-description p {
        font-size: 14px;
        color: #777;
        line-height: 1.6;
        margin: 0;
    }

    /* Video Grid Styling */
    .video-grid-wrapper {
        margin: 40px 0;
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .video-grid-item {
        width: 100%;
    }

    .video-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        background-color: #000;
    }

    .local-video {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        object-fit: cover;
        background-color: #000;
    }

    .video-description {
        padding: 15px;
        text-align: left;
    }

    .video-description h4 {
        font-size: 16px;
        font-weight: 600;
        color: #4a4c70;
        margin-bottom: 8px;
    }

    .video-description p {
        font-size: 13px;
        color: #777;
        line-height: 1.5;
        margin: 0;
    }

    /* Responsive Grid */
    @media (max-width: 992px) {
        .video-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .video-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .video-description h4 {
            font-size: 15px;
        }

        .video-description p {
            font-size: 12px;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .brosur-section {
            padding: 40px 0;
        }

        .btn-tanya {
            padding: 12px 30px;
            font-size: 16px;
        }

        .video-description h4 {
            font-size: 16px;
        }

        .video-description p {
            font-size: 13px;
        }
    }

    .video-more {
        text-align: center;
        margin-top: 30px;
        font-size: 15px;
        color: #555;
    }

    .video-more a {
        color: #75975e;
        font-weight: 600;
        text-decoration: underline;
    }

    .video-more a:hover {
        color: #5a7a47;
    }
</style>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p><?= $language["n"]  ?></p>
            <h2><?= $language["nn"] ?></h2>
        </div>

        <!-- Brosur Section -->
        <div class="brosur-section">
            <div class="brosur-container">
                <img src="img/Brosur.webp" alt="Brosur Yayasan Kolibri" class="brosur-image" loading="lazy" id="brosurImage">

                <div class="brosur-lightbox" id="brosurLightbox">
                    <button type="button" class="brosur-lightbox-close" aria-label="Tutup">&times;</button>
                    <img src="img/Brosur.webp" alt="Brosur Yayasan Kolibri" draggable="false">
                </div>

                <div class="brosur-cta">
                    <h3 style="margin-bottom: 20px; color: #4a4c70; font-size: 24px;">
                        <?= $language["t"] ?>
                    </h3>

                    <!-- Video Grid -->
                    <div class="video-grid-wrapper">
                        <h3 style="margin-bottom: 30px; color: #4a4c70; font-size: 24px; text-align: center;">
                            <?= $language["w"] ?>
                        </h3>
                        <div class="video-grid">

                            <!-- Video 1 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1760248785.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v1t"] ?></h4>
                                        <p><?= $language["v1d"] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Video 2 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1760248243.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v2t"] ?></h4>
                                        <p><?= $language["v2d"] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Video 3 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1733827781.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v3t"] ?></h4>
                                        <p><?= $language["v3d"] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Video 4 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1760247230.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v4t"] ?></h4>
                                        <p><?= $language["v4d"] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Video 5 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1760247347.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v5t"] ?></h4>
                                        <p><?= $language["v5d"] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Video 6 -->
                            <div class="video-grid-item">
                                <div class="video-card">
                                    <div class="video-wrapper">
                                        <div class="vid-placeholder" data-src="img/galeriv/video1760247603.mp4" data-type="video/mp4"></div>
                                    </div>
                                    <div class="video-description">
                                        <h4><?= $language["v6t"] ?></h4>
                                        <p><?= $language["v6d"] ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="video-more">
                            <?= $language["v_more"] ?> <a href="video.php"><?= $language["v_more_link"] ?></a>
                        </div>
                    </div>

                    <p style="text-align: justify; max-width: 900px; margin: 30px auto; line-height: 1.8; color: #555;">
                        <?= $language["desc"] ?>
                    </p>
                    <p style="text-align: justify; max-width: 900px; margin: 30px auto; line-height: 1.8; color: #555;"><span class="text-danger">*</span>
                        <?= $language["desc2"] ?>
                    </p>



                    <h3 style="margin-bottom: 20px; color: #4a4c70; font-size: 24px;"><?= $language["tb"] ?></h3>

                    <a href="https://wa.me/6285297243719?text=Hello%2C%20I%20would%20like%20to%20ask%20about%20the%20Kolibri%20Foundation%20and%20booking%20a%20Kolibri%20Foundation%20tour" class="btn-tanya" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <?= $language["tb2"] ?>
                    <a href="https://mail.google.com/mail/?<?= htmlspecialchars(http_build_query([
                        'view' => 'cm',
                        'fs'   => 1,
                        'to'   => 'yusufsihotang70@gmail.com',
                        'su'   => 'Kolibri Foundation Tour Booking',
                        'body' => 'Hello, I would like to ask about the Kolibri Foundation and booking a Kolibri Foundation tour.',
                    ], '', '&', PHP_QUERY_RFC3986)) ?>" class="btn-tanya" target="_blank">
                        <i class="fa fa-envelope"></i> <?= $language["tbm"] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Vid placeholder sudah didefinisi di video.php — duplikasi bersih di sini untuk halaman lain */
    .video-wrapper .vid-placeholder {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        background: linear-gradient(135deg, #1a2a1a 0%, #2d4a2d 100%);
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .video-wrapper .vid-placeholder:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .35);
    }

    .video-wrapper .vid-placeholder::before {
        content: '\f144';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: rgba(255, 255, 255, .7);
    }

    .video-wrapper video {
        display: block;
        width: 100%;
        border-radius: 8px;
    }

    /* Saat video diputar, lepaskan kotak rasio 16:9 paksa dan ikuti rasio asli video */
    .video-wrapper.is-playing {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        height: auto !important;
    }

    .video-wrapper.is-playing video {
        position: static;
        width: 100%;
        height: auto;
        object-fit: contain;
    }
</style>
<script>
    (function() {
        var img = document.getElementById('brosurImage');
        var lightbox = document.getElementById('brosurLightbox');
        var closeBtn = lightbox ? lightbox.querySelector('.brosur-lightbox-close') : null;
        var zoomImg = lightbox ? lightbox.querySelector('img') : null;
        if (!img || !lightbox || !zoomImg) return;

        var MIN_SCALE = 1;
        var MAX_SCALE = 4;
        var scale = 1;
        var posX = 0;
        var posY = 0;
        var isDragging = false;
        var dragMoved = false;
        var dragStartX = 0;
        var dragStartY = 0;

        function applyTransform() {
            zoomImg.style.transform = 'translate(' + posX + 'px, ' + posY + 'px) scale(' + scale + ')';
            zoomImg.classList.toggle('is-zoomed', scale > MIN_SCALE);
        }

        function resetZoom() {
            scale = 1;
            posX = 0;
            posY = 0;
            applyTransform();
        }

        function openLightbox() {
            resetZoom();
            lightbox.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            resetZoom();
            document.body.style.overflow = '';
        }

        img.addEventListener('click', openLightbox);

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) closeLightbox();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                closeLightbox();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });

        zoomImg.addEventListener('click', function(e) {
            e.stopPropagation();
            if (dragMoved) {
                dragMoved = false;
                return;
            }
            if (scale === MIN_SCALE) {
                scale = 2;
            } else {
                scale = MIN_SCALE;
                posX = 0;
                posY = 0;
            }
            applyTransform();
        });

        zoomImg.addEventListener('wheel', function(e) {
            e.preventDefault();
            var delta = e.deltaY < 0 ? 0.25 : -0.25;
            scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, scale + delta));
            if (scale === MIN_SCALE) {
                posX = 0;
                posY = 0;
            }
            applyTransform();
        }, {
            passive: false
        });

        zoomImg.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });

        zoomImg.addEventListener('mousedown', function(e) {
            if (scale === MIN_SCALE) return;
            e.preventDefault();
            isDragging = true;
            dragMoved = false;
            dragStartX = e.clientX - posX;
            dragStartY = e.clientY - posY;
            zoomImg.classList.add('is-dragging');
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            var newX = e.clientX - dragStartX;
            var newY = e.clientY - dragStartY;
            if (Math.abs(newX - posX) > 2 || Math.abs(newY - posY) > 2) dragMoved = true;
            posX = newX;
            posY = newY;
            applyTransform();
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
            zoomImg.classList.remove('is-dragging');
        });
    })();

    document.querySelectorAll('.video-wrapper .vid-placeholder').forEach(function(ph) {
        ph.addEventListener('click', function() {
            var wrapper = ph.closest('.video-wrapper');
            var video = document.createElement('video');
            video.controls = true;
            video.autoplay = true;
            video.style.display = 'block';
            var source = document.createElement('source');
            source.src = ph.dataset.src;
            source.type = ph.dataset.type;
            video.appendChild(source);
            ph.replaceWith(video);

            video.addEventListener('loadedmetadata', function() {
                if (wrapper) wrapper.classList.add('is-playing');
            });

            video.play().catch(function() {});
        });
    });
</script>