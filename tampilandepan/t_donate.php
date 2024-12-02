<div class="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 position-relative"> <!-- Tambahkan class position-relative -->
                <div class="about-img" data-parallax="scroll" data-image-src="img/about.jpg"></div>
                <div class="about-text"> <!-- Tambahkan div untuk teks -->
                    <h1><?=$language["donasigmb"]  ?></h1>
                    
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-header">
                    <p><?=$language["slidert"]  ?></p>
                                
                                
                           
                     <h2><?=$language["slidertr"]  ?></h2>
                        </div>
                <div class="about-tab">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab-content-1"><?=$language["donasikr"]  ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-content-3"><?=$language["slidert"]  ?></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab-content-1" class="container tab-pane active">
                        <p><?=$language["donasiisi"]  ?></p>
                        <?=$language["donasiisi2"]  ?>
                        <ul>
                            <li><?=$language["donasiisi2.1"]  ?></li>
                            <li><?=$language["donasiisi2.2"]  ?></li>
                            <li><?=$language["donasiisi2.3"]  ?></li>
                        </ul>
                        <?=$language["donasiisi3"]  ?>
                        </div>
                        
                        <div id="tab-content-3" class="container tab-pane fade">
                         <?=$language["donasiisi4"]  ?>
                        <br><br>
                        <div class="donate-form">
                            <form class="donate-form-container">
                                <div class="donate-text-container">
                                    
                                    <p class="donate-text">BANK BRI | 5262 01 015033 53 8</p>
                                    <button class="donate-copy-button" onclick="copytext()">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function copytext() {
        const textToCopy = "5262 01 015033 53 8";
        navigator.clipboard.writeText(textToCopy).then(() => {
            alert("text sudah dicopy: " + textToCopy);
        });
    }
</script>

<style>
    .donate-form-container {
        display: flex;
        justify-content: center; /* Menengahkan konten dalam form */
        align-items: center; /* Memastikan tombol berada di tengah vertikal dengan teks */
    }
    .donate-text-container {
        display: flex;
        align-items: center; /* Memastikan tombol sejajar dengan teks */
    }
    .donate-text {
        color: #000; /* Ganti dengan warna yang Anda inginkan */
        margin-right: 10px; /* Memberikan jarak antara teks dan tombol */
        line-height: 1.5; /* Menyesuaikan tinggi garis untuk penataan yang lebih baik */
    }
    .donate-copy-button {
        background: none; /* Tanpa latar belakang */
        border: none; /* Tanpa border */
        color: inherit; /* Mengambil warna dari elemen induk */
        cursor: pointer; /* Menunjukkan bahwa ini adalah tombol yang dapat diklik */
        margin-top: -2px; /* Mengatur posisi tombol sedikit lebih ke atas */
    }
</style>