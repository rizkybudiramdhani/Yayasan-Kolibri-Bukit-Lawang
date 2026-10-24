<?php
/*
 * Data pengurus: SATU-SATUNYA tempat untuk mengubah nama, jabatan, atau foto.
 *
 * Dulu setiap orang ditulis dua kali (grid desktop + carousel mobile yang
 * disembunyikan CSS), jadi mengganti satu nama harus di dua tempat dan Google
 * membaca setiap nama dua kali. Sekarang satu markup dipakai untuk semua layar:
 * grid di desktop, geser (swipe) di HP.
 *
 * Ganti 'foto' dengan foto asli tiap pengurus (persegi/potret, ±600px,
 * simpan di img/team/). Selama masih 'img/team.jpg', semua memakai foto sama.
 */
$pengurus = [
    ['nama' => 'Zahara Rita',            'jabatan' => 'Ketua',      'foto' => 'img/team.jpg'],
    ['nama' => 'Mayang Yustapa Sihotang', 'jabatan' => 'Sekretaris', 'foto' => 'img/team.jpg'],
    ['nama' => 'Yusuf Sihotang',         'jabatan' => 'Bendahara',  'foto' => 'img/team.jpg'],
    ['nama' => 'Fazri Imam Ananda Sht',  'jabatan' => 'Kordinator', 'foto' => 'img/team.jpg'],
];
$sosmedYayasan = [
    'Facebook'  => ['https://www.facebook.com/people/Yayasan-Kolibri-Bukit-Lawang-New/100091601498368/', 'fab fa-facebook-f'],
    'Instagram' => ['https://www.instagram.com/yayasan_kolibri_bukit_lawang', 'fab fa-instagram'],
];
$h = function ($t) { return htmlspecialchars((string) $t, ENT_QUOTES, 'UTF-8'); };
?>
<div class="team">
  <div class="container">
    <div class="section-header text-center">
      <p><?= $h($language["team_label"]) ?></p>
      <h2><?= $h($language["tt"]) ?></h2>
    </div>

    <div class="team-list">
      <?php foreach ($pengurus as $orang): ?>
      <div class="team-slot">
        <div class="team-card">
          <div class="team-photo">
            <img src="<?= $h($orang['foto']) ?>"
                 alt="<?= $h($orang['nama'] . ', ' . $orang['jabatan'] . ' Yayasan Kolibri Bukit Lawang') ?>"
                 loading="lazy" width="600" height="600">
          </div>
          <div class="team-info">
            <h3><?= $h($orang['nama']) ?></h3>
            <p><?= $h($orang['jabatan']) ?></p>
            <div class="team-social">
              <?php foreach ($sosmedYayasan as $label => [$url, $ikon]): ?>
                <a href="<?= $h($url) ?>" target="_blank" rel="noopener" aria-label="<?= $h($label) ?> Yayasan Kolibri"><i class="<?= $h($ikon) ?>"></i></a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<style>
/* Desktop & tablet: grid 4 / 2 kolom */
.team-list {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
}

@media (max-width: 991px) {
  .team-list { grid-template-columns: repeat(2, 1fr); }
}

/* HP: deretan kartu yang bisa digeser, kartu berikutnya sedikit mengintip
   sebagai petunjuk bisa di-swipe. Tanpa JavaScript / plugin carousel. */
@media (max-width: 767px) {
  .team-list {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding: 4px 4px 16px;
    margin: 0 -4px;
    scrollbar-width: thin;
  }

  .team-slot {
    flex: 0 0 82%;
    scroll-snap-align: center;
  }

  .team-card { margin-bottom: 0; }
}

.team-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
  padding-bottom: 20px;
  margin-bottom: 30px;
  height: calc(100% - 30px);
}

.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.team-photo img {
  display: block;
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 20px 20px 0 0;
}

.team-info {
  padding: 20px 15px 10px;
}

.team-info h3 {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 8px;
  color: #333;
}

.team-info p {
  font-size: 0.95rem;
  color: #777;
  margin-bottom: 15px;
}

.team-social {
  display: flex;
  justify-content: center;
  gap: 12px;
}

.team-social a {
  width: 35px;
  height: 35px;
  background: #f0f0f0;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #333;
  transition: all 0.3s ease;
}

.team-social a:hover {
  background: #75975e;
  color: #fff;
  transform: scale(1.1);
}

@media (prefers-reduced-motion: reduce) {
  .team-card, .team-social a { transition: none; }
  .team-card:hover { transform: none; }
}
</style>
