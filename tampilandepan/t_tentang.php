<div class="section-header text-center mb-0">
    <p><?=$language["ht1"]?></p>
    <h2><?=$language["ht2"]?></h2>
</div>
<div class="about pt-0">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="about-img" data-parallax="scroll" data-image-src="img/about.jpg"></div>
            </div>
            <div class="col-lg-6">
                <div class="about-tab p-4">
                    <ul class="nav nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab-content-1"><?=$language["ht1"]?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-content-2"><?=$language["kegiatan"]?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-content-3"><?=$language["vs"]?> <?=$language["ms"]?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-content-1" class="container tab-pane active">
                            <?=$language["tentang"]?>
                            <br><br>
                            <?=$language["tentang2"]?>
                        </div>
                        <div id="tab-content-2" class="container tab-pane fade">
    <?=$language["desc"]?>
    
    <!-- Grid Foto Kegiatan -->
    <div class="kegiatan-gallery mt-4">
        <div class="row g-3">
            <div class="col-6">
                <div class="gallery-item mb-3">
                    <img src="img/galerif/foto1760246813.jpg" alt="Kegiatan 1" class="img-fluid">
                    <div class="gallery-caption">Traditional Dance Art</div>
                </div>
            </div>
            <div class="col-6">
                <div class="gallery-item mb-3">
                    <img src="img/galerif/foto1733839953.jpg" alt="Kegiatan 2" class="img-fluid">
                    <div class="gallery-caption">Gymnastics with Tourists</div>
                </div>
            </div>
            <div class="col-6">
                <div class="gallery-item">
                    <img src="img/galerif/foto1733839621.jpg" alt="Kegiatan 3" class="img-fluid">
                    <div class="gallery-caption">Studying English Together</div>
                </div>
            </div>
            <div class="col-6">
                <div class="gallery-item">
                    <img src="img/galerif/foto1733840415.jpg" alt="Kegiatan 4" class="img-fluid">
                    <div class="gallery-caption">Eating together by the river</div>
                </div>
            </div>
        </div>
    </div>
</div>
                        <div id="tab-content-3" class="container tab-pane fade">
                            <?=$language["visi"]?>, dan <?=$language["misi"]?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Sponsor -->
<div class="sponsor-section">
    <div class="container">
        <div class="section-header text-center">
            <p><?= $language["sponsor"]?></p>
            <h2>Program Sponsor</h2>
        </div>

        <div class="sponsor-content">
            <div class="row align-items-center g-5">
                <!-- Gambar / Icon -->
                <div class="col-lg-5">
                    <div class="sponsor-image">
                        <img src="img/galerif/foto1760283891.jpg" alt="Program Sponsor" class="img-fluid rounded-3 shadow">
                        <!-- Atau pakai icon -->
                        <div class="sponsor-icon-wrapper text-center">
                            <div class="sponsor-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Penjelasan -->
                <div class="col-lg-7">
                    <div class="sponsor-description">
                        <h3><?= $language["sponsor2"]?></h3>
                        <p>
                            <strong><?= $language["sponsor33"]?></strong> <?= $language["sponsor3"]?>
                        </p>

                        <div class="sponsor-benefits">
                            <h4><i class="fas fa-graduation-cap"></i> <?= $language["sponsor4"]?></h4>
                            <ul class="benefit-list">
                                <li><i class="fas fa-check-circle"></i> <strong>Transportation</strong> - Daily commuting costs to school</li>
                                <li><i class="fas fa-check-circle"></i> <strong>School Uniform </strong> - Shirt, pants/skirt, tie, and complete accessories</li>
                                <li><i class="fas fa-check-circle"></i> <strong>Shoes & Socks </strong> - Proper and Comfortable School Shoes</li>
                                <li><i class="fas fa-check-circle"></i> <strong>School Bag</strong> - A strong and quality bag</li>
                                <li><i class="fas fa-check-circle"></i> <strong>Books & Stationery</strong> - Textbooks, pens, pencils, and other supplies</li>
                                <li><i class="fas fa-check-circle"></i> <strong>Tuition Fee</strong> - Monthly School Payment</li>
                            </ul>
                        </div>

                        <div class="sponsor-commitment">
                            <div class="commitment-box">
                                <i class="fas fa-heart"></i>
                                <div>
                                    <h5><?= $language["sponsor5"]?></h5>
                                    <p><?= $language["sponsor6"]?></p>
                                </div>
                            </div>
                        </div>

                        <div class="sponsor-cta">
                            <a href="https://wa.me/6285297243719?text=Halo,%20saya%20tertarik%20dengan%20program%20sponsor" class="btn-sponsor">
                                <i class="fas fa-hands-helping"></i> <?= $language["sponsor7"]?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Header teks */
.section-header p {
    color: #4caf50;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 8px;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}

.section-header h2 {
    color: #2c2c2c;
    font-weight: 700;
    font-size: 1.8rem;
    line-height: 1.3;
}

/* Tab container */
.about-tab {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.about-tab:hover {
    box-shadow: 0 6px 25px rgba(0,0,0,0.12);
}

/* Tombol tab */
.about-tab .nav-pills .nav-link {
    color: #333;
    border-radius: 12px;
    margin: 0 6px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.about-tab .nav-pills .nav-link.active {
    background: #4CAF50;
    color: #fff;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.about-tab .nav-pills .nav-link:hover:not(.active) {
    background: #e8f5e9;
    color: #388e3c;
}

/* Konten tab */
.about-tab .tab-content {
    color: #444;
    line-height: 1.7;
    font-size: 0.96rem;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}

/* ===== SPONSOR SECTION ===== */
.sponsor-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
}

.sponsor-content {
    margin-top: 50px;
}

.sponsor-image {
    position: relative;
}

.sponsor-image img {
    width: 100%;
    border-radius: 15px;
}

.sponsor-icon-wrapper {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.sponsor-icon {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
}

.sponsor-icon i {
    font-size: 70px;
    color: #fff;
}

.sponsor-description h3 {
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
}

.sponsor-description p {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
}

.sponsor-benefits {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.sponsor-benefits h4 {
    font-size: 20px;
    font-weight: 600;
    color: #4CAF50;
    margin-bottom: 20px;
}

.sponsor-benefits h4 i {
    margin-right: 10px;
}

.benefit-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.benefit-list li {
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 15px;
    color: #555;
}

.benefit-list li:last-child {
    border-bottom: none;
}

.benefit-list li i {
    color: #4CAF50;
    margin-right: 12px;
    font-size: 18px;
}

.benefit-list li strong {
    color: #2c3e50;
}

.sponsor-commitment {
    margin-bottom: 30px;
}

.commitment-box {
    background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
    padding: 25px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 6px 25px rgba(255, 107, 107, 0.3);
}

.commitment-box i {
    font-size: 50px;
    color: #fff;
    flex-shrink: 0;
}

.commitment-box h5 {
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
}

.commitment-box p {
    color: rgba(255,255,255,0.95);
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
}

.sponsor-cta {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-sponsor {
    display: inline-flex;
    align-items: center;p
    gap: 10px;
    padding: 15px 35px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
    border: none;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.btn-sponsor:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(76, 175, 80, 0.4);
    color: #fff;
}

.btn-sponsor-outline {
    background: transparent;
    border: 2px solid #4CAF50;
    color: #4CAF50;
    box-shadow: none;
}

.btn-sponsor-outline:hover {
    background: #4CAF50;
    color: #fff;
}

/* Responsive */
@media (max-width: 992px) {
    .sponsor-section {
        padding: 60px 0;
    }
    
    .sponsor-description h3 {
        font-size: 24px;
    }
    
    .sponsor-icon {
        width: 120px;
        height: 120px;
    }
    
    .sponsor-icon i {
        font-size: 60px;
    }
}

@media (max-width: 576px) {
    .sponsor-section {
        padding: 40px 0;
    }
    
    .sponsor-description h3 {
        font-size: 22px;
    }
    
    .sponsor-description p {
        font-size: 15px;
    }
    
    .benefit-list li {
        font-size: 14px;
    }
    
    .commitment-box {
        flex-direction: column;
        text-align: center;
    }
    
    .sponsor-cta {
        flex-direction: column;
    }
    
    .btn-sponsor {
        width: 100%;
        justify-content: center;
    }
}
/* Gallery Kegiatan di Tab */
.kegiatan-gallery {
    margin-top: 20px;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.gallery-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: #fff;
    padding: 15px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    transform: translateY(0);
}

/* Responsive untuk mobile */
@media (max-width: 576px) {
    .gallery-item img {
        height: 150px;
    }
    
    .gallery-caption {
        font-size: 12px;
        padding: 10px;
    }
}
</style>