<!-- ===== HERO / BANNER SLIDER ===== -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php if (!empty($banners)): foreach ($banners as $i => $b): ?>
      <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
        <img src="<?= base_url('uploads/banner/' . $b->gambar) ?>" class="d-block w-100" alt="<?= esc($b->judul) ?>">
        <div class="carousel-caption d-none d-md-block">
          <h1><?= esc($b->judul) ?></h1>
        </div>
      </div>
    <?php endforeach; else: ?>
      <div class="carousel-item active">
        <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=1600&h=500&fit=crop" class="d-block w-100" alt="SISAPI">
        <div class="carousel-caption d-none d-md-block">
          <h1>Marketplace Peternakan Terpercaya di Indonesia</h1>
          <p>Seluruh ternak yang tampil telah diverifikasi oleh Dinas Peternakan</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- ===== SEARCH & FILTER CARD ===== -->
<div class="container">
  <div class="hero-search-card">
    <form action="<?= base_url('produk') ?>" method="get" class="row g-2 align-items-end">
      <div class="col-lg-4 col-md-6 position-relative">
        <label class="form-label small fw-semibold">Cari Ternak</label>
        <input type="text" name="q" id="autocompleteSearch" class="form-control" placeholder="Contoh: Sapi Limosin, Kambing Etawa...">
        <div id="autocompleteBox" class="list-group position-absolute w-100" style="z-index:20;"></div>
      </div>
      <div class="col-lg-3 col-md-6">
        <label class="form-label small fw-semibold">Kategori</label>
        <select name="kategori_id" class="form-select">
          <option value="">Semua Kategori</option>
          <?php foreach ($kategori as $k): ?>
            <option value="<?= $k->id ?>"><?= esc($k->nama_kategori) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-lg-3 col-md-6">
        <label class="form-label small fw-semibold">Kabupaten/Kota</label>
        <select name="kabupaten_id" class="form-select">
          <option value="">Semua Wilayah</option>
          <?php foreach ($kabupaten as $kab): ?>
            <option value="<?= $kab->id ?>"><?= esc($kab->nama) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-lg-2 col-md-6 d-grid">
        <button type="submit" class="btn btn-sisapi"><i class="bi bi-search"></i> Cari Ternak</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== KATEGORI ===== -->
<div class="container py-5">
  <h3 class="section-title">Kategori Ternak</h3>
  <div class="row g-3">
    <?php foreach ($kategori as $k): ?>
      <div class="col-6 col-md-2">
        <a href="<?= base_url('kategori/' . $k->slug) ?>" class="text-decoration-none text-dark">
          <div class="kategori-card">
            <i class="bi <?= esc($k->icon ?: 'bi-box') ?>"></i>
            <p class="mb-0 mt-2 small fw-semibold"><?= esc($k->nama_kategori) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ===== STATISTIK ===== -->
<div class="bg-light-gray py-5">
  <div class="container">
    <div class="row g-3 text-center">
      <div class="col-md-4">
        <div class="stat-box">
          <div class="angka"><?= number_format($statistik['total_peternak']) ?>+</div>
          <p class="mb-0">Peternak Terverifikasi</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-box">
          <div class="angka"><?= number_format($statistik['total_produk']) ?>+</div>
          <p class="mb-0">Ternak Tersedia</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-box">
          <div class="angka"><?= number_format($statistik['total_kontak']) ?>+</div>
          <p class="mb-0">Transaksi Kontak via WhatsApp</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===== PRODUK TERBARU ===== -->
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="section-title mb-0">Ternak Terbaru</h3>
    <a href="<?= base_url('produk?sort=terbaru') ?>" class="small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
  </div>
  <div class="row g-3">
    <?php if (!empty($produk_terbaru)): foreach ($produk_terbaru as $p): ?>
      <div class="col-6 col-md-3">
        <?php $this->load->view('produk/_card', array('p' => $p)); ?>
      </div>
    <?php endforeach; else: ?>
      <p class="text-muted">Belum ada ternak yang tersedia saat ini.</p>
    <?php endif; ?>
  </div>
</div>

<!-- ===== PRODUK TERPOPULER ===== -->
<div class="bg-light-gray py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="section-title mb-0">Ternak Terpopuler</h3>
      <a href="<?= base_url('produk?sort=terpopuler') ?>" class="small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
      <?php if (!empty($produk_terpopuler)): foreach ($produk_terpopuler as $p): ?>
        <div class="col-6 col-md-3">
          <?php $this->load->view('produk/_card', array('p' => $p)); ?>
        </div>
      <?php endforeach; else: ?>
        <p class="text-muted">Belum ada data.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- ===== PETERNAK TERPERCAYA ===== -->
<div class="container py-5">
  <h3 class="section-title">Peternak Terpercaya</h3>
  <div class="row g-3">
    <?php if (!empty($peternak_terpercaya)): foreach ($peternak_terpercaya as $pt): ?>
      <div class="col-6 col-md-2">
        <div class="peternak-card">
          <img src="<?= $pt->foto_profil ? base_url('uploads/profil/'.$pt->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($pt->nama_lengkap).'&background=198754&color=fff' ?>" alt="<?= esc($pt->nama_lengkap) ?>">
          <p class="fw-semibold small mt-2 mb-0"><?= esc($pt->nama_lengkap) ?></p>
          <p class="text-muted small mb-0"><i class="bi bi-star-fill text-warning"></i> <?= number_format($pt->rating_rata,1) ?></p>
        </div>
      </div>
    <?php endforeach; else: ?>
      <p class="text-muted">Belum ada peternak terverifikasi.</p>
    <?php endif; ?>
  </div>
</div>

<!-- ===== ARTIKEL ===== -->
<div class="bg-light-gray py-5">
  <div class="container">
    <h3 class="section-title">Artikel Peternakan</h3>
    <div class="row g-3">
      <?php if (!empty($artikel)): foreach ($artikel as $a): ?>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <img src="<?= $a->gambar_sampul ? base_url('uploads/artikel/'.$a->gambar_sampul) : 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=500' ?>" class="card-img-top" style="height:180px;object-fit:cover;">
            <div class="card-body">
              <span class="badge bg-light text-success border border-success mb-2"><?= esc($a->kategori_artikel) ?></span>
              <h6><a href="<?= base_url('artikel/'.$a->slug) ?>" class="text-dark"><?= esc($a->judul) ?></a></h6>
              <p class="small text-muted"><?= esc(mb_substr(strip_tags($a->ringkasan ?: $a->konten), 0, 90)) ?>...</p>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <p class="text-muted">Belum ada artikel.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
