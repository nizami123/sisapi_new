<!-- ============ HERO ============ -->
<section class="sisapi-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <h1>Temukan Ternak &amp; <span class="highlight">Produk Peternakan</span> Terbaik di Sekitar Anda</h1>
        <p class="lead mt-3">SISAPI adalah platform yang mempertemukan peternak dengan pembeli secara mudah, cepat, dan terpercaya.</p>

        <form action="<?= base_url('cari') ?>" method="get" class="sisapi-search-box mt-4">
          <i class="fa-solid fa-magnifying-glass text-muted ms-2"></i>
          <input type="text" name="q" placeholder="Cari sapi, kambing, domba, pakan, produk hewan...">
          <button type="submit" class="btn btn-sisapi-green px-4">Cari</button>
        </form>

        <div class="sisapi-hero-badges">
          <div class="badge-item"><span class="badge-icon"><i class="fa-solid fa-shield-check"></i></span> Peternak Terverifikasi</div>
          <div class="badge-item"><span class="badge-icon"><i class="fa-solid fa-circle-info"></i></span> Informasi Lengkap</div>
          <div class="badge-item"><span class="badge-icon"><i class="fa-solid fa-location-dot"></i></span> Lokasi Akurat</div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="sisapi-hero-image">
          <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=900&q=80" alt="Ternak sapi, kambing, domba di peternakan">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ KATEGORI ============ -->
<section class="py-4">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h2 class="section-title mb-1">Kategori Produk</h2>
        <p class="section-sub mb-0">Temukan berbagai pilihan ternak dan produk peternakan</p>
      </div>
      <a href="<?= base_url('cari') ?>" class="btn btn-sisapi-green btn-sm">Lihat Semua Kategori <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
    <div class="row g-3 row-cols-3 row-cols-md-5 row-cols-lg-8">
      <?php foreach ($categories as $cat): ?>
      <div class="col">
        <a href="<?= base_url('kategori/' . $cat['slug']) ?>" class="sisapi-category-card d-block">
          <div class="icon-wrap"><i class="fa-solid <?= $cat['icon'] ?>"></i></div>
          <span><?= htmlspecialchars($cat['name']) ?></span>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ TERNAK TERDEKAT + PETERNAK TERVERIFIKASI ============ -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <h2 class="section-title mb-1">Ternak Terdekat</h2>
            <p class="section-sub mb-0">
              <?php if (!empty($nearby_products)): ?>
                <i class="fa-solid fa-location-dot"></i> Berdasarkan lokasi Anda saat ini
              <?php else: ?>
                Lihat ternak di sekitar lokasi Anda
              <?php endif; ?>
            </p>
          </div>
          <?php if (empty($nearby_products)): ?>
          <button onclick="sisapiUseMyLocation()" class="btn btn-outline-sisapi btn-sm"><i class="fa-solid fa-location-crosshairs me-1"></i> Gunakan Lokasi Saya</button>
          <?php else: ?>
          <a href="<?= base_url('ternak-terdekat') ?>" class="btn btn-sisapi-green btn-sm">Lihat Semua</a>
          <?php endif; ?>
        </div>

        <div class="row g-3 row-cols-2 row-cols-md-4">
          <?php $show = !empty($nearby_products) ? $nearby_products : array_slice($newest_products, 0, 4); ?>
          <?php foreach ($show as $p): ?>
          <div class="col"><?php $this->load->view('frontend/partials/product_card', array('p' => $p)); ?></div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="section-title mb-0" style="font-size:1.2rem;">Peternak Terverifikasi</h2>
          <a href="<?= base_url('peternak') ?>" class="small text-decoration-none">Lihat Semua &rarr;</a>
        </div>
        <div class="d-flex flex-column gap-2">
          <?php foreach ($verified_sellers as $s): ?>
          <a href="<?= base_url('peternak/' . $s['id']) ?>" class="sisapi-seller-card text-decoration-none">
            <div class="d-flex align-items-center gap-2">
              <img src="<?= $s['photo'] ? base_url($s['photo']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($s['farm_name']) ?>" class="avatar" alt="<?= htmlspecialchars($s['farm_name']) ?>">
              <div>
                <div class="seller-name"><?= htmlspecialchars($s['farm_name']) ?> <i class="fa-solid fa-circle-check verified-tick"></i></div>
                <div class="seller-loc"><?= htmlspecialchars($s['address']) ?></div>
              </div>
            </div>
            <div class="text-warning small"><i class="fa-solid fa-star"></i> <?= number_format($s['rating_avg'],1) ?></div>
          </a>
          <?php endforeach; ?>
          <?php if (empty($verified_sellers)): ?>
            <p class="text-muted small mb-0">Belum ada peternak terverifikasi.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ TERNAK TERBARU ============ -->
<section class="py-4">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h2 class="section-title mb-1">Ternak &amp; Produk Terbaru</h2>
        <p class="section-sub mb-0">Listing yang baru saja ditambahkan peternak</p>
      </div>
      <a href="<?= base_url('cari?sort=terbaru') ?>" class="btn btn-outline-sisapi btn-sm">Lihat Semua</a>
    </div>
    <div class="row g-3 row-cols-2 row-cols-md-4">
      <?php foreach ($newest_products as $p): ?>
      <div class="col"><?php $this->load->view('frontend/partials/product_card', array('p' => $p)); ?></div>
      <?php endforeach; ?>
      <?php if (empty($newest_products)): ?>
        <p class="text-muted">Belum ada listing aktif saat ini.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ CTA JADI PETERNAK ============ -->
<section class="py-5">
  <div class="container">
    <div class="sisapi-cta-banner">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <h3 class="fw-bold mb-2">Jual Ternak &amp; Produk Anda di SISAPI</h3>
          <p class="mb-4" style="opacity:.9;">Bergabunglah dengan ribuan peternak lainnya dan perluas jangkauan pasar Anda secara gratis!</p>
          <div class="d-flex flex-wrap gap-4 mb-4">
            <div class="d-flex align-items-center gap-2"><span class="icon-check"><i class="fa-solid fa-check"></i></span> Gratis — Biaya Pendaftaran</div>
            <div class="d-flex align-items-center gap-2"><span class="icon-check"><i class="fa-solid fa-check"></i></span> Mudah — Proses Cepat</div>
            <div class="d-flex align-items-center gap-2"><span class="icon-check"><i class="fa-solid fa-check"></i></span> Luas — Jangkauan Pasar</div>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <a href="<?= base_url('daftar-peternak') ?>" class="btn btn-light fw-semibold px-4">Daftar Sebagai Peternak</a>
            <a href="<?= base_url('tentang') ?>" class="btn btn-outline-light px-4">Pelajari Lebih Lanjut</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
