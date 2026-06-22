<div class="testimonial py-5">
  <div class="container">
    <div class="section-header text-center mb-5">
      <p><?=$language["work"]?></p>
      <h2><?=$language["work2"]?></h2>
    </div>

    <div class="owl-carousel testimonials-carousel">
      
      <!-- Item 1 -->
      <div class="testimonial-item card-style p-4">
        <div class="text-center">
          <img src="img/leuser.jpeg" alt="Leuser Tours & Trekking" class="testimonial-photo mb-3">
          <h3 class="testimonial-title mb-1">Leuser Tours & Trekking</h3>
          <p class="testimonial-subtitle mb-3 text-muted">
            Tour • Accommodation • Jungle Trekking • Car • Around Village
          </p>
        </div>
        <div class="testimonial-body text-center">
          <p class="font-weight-bold text-success mb-1">Social Media</p>
          <a href="https://www.facebook.com/leusertrekking?mibextid=rS40aB7S9Ucbxw6v" 
             target="_blank" class="social-link">
            <i class="fab fa-facebook-f mr-2"></i> Leuser Tours & Trekking
          </a>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="testimonial-item card-style p-4">
        <div class="text-center">
          <img src="img/yusri.jpeg" alt="Yusri Cafe" class="testimonial-photo mb-3">
          <h3 class="testimonial-title mb-1">Yusri Cafe</h3>
          <p class="testimonial-subtitle mb-3 text-muted">
            Restaurant • Traditional Dance
          </p>
        </div>
        <div class="testimonial-body text-center">
          <p class="font-weight-bold text-success mb-1">Social Media</p>
          <a href="https://www.facebook.com/YusriCafe?mibextid=rS40aB7S9Ucbxw6v" 
             target="_blank" class="social-link">
            <i class="fab fa-facebook-f mr-2"></i> Yusri Cafe
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
<style>
/* === CARD TESTIMONIAL MODERN STYLE === */

.card-style {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  overflow: hidden; /* pastikan radius terpotong rapi */
  min-height: 480px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 2rem;
}


.card-style:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

.testimonial-photo {
  width: 100%;
  max-width: 240px;      /* biar proporsional di dalam card */
  height: auto;
  border-radius: 20px;   /* sebelumnya 50%, sekarang lembut */
  object-fit: cover;
  margin: 0 auto 1rem;
  display: block;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* sedikit depth biar elegan */
}


.testimonial-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #222;
}

.testimonial-subtitle {
  font-size: 0.95rem;
  color: #666;
}

.social-link {
  color: #75975e;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s ease;
}

.social-link:hover {
  color: #0056b3;
  text-decoration: underline;
}

/* Carousel item spacing */
.owl-carousel .testimonial-item {
  margin: 10px;
}

/* Responsive tweaks */
@media (max-width: 768px) {
  .testimonial-photo {
    width: 110px;
    height: 110px;
  }
  .card-style {
    min-height: 350px;
    padding: 1.5rem;
  }
}
</style>