<div class="container py-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb small">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('kategori/'.$produk->kategori_slug) ?>"><?= esc($produk->nama_kategori) ?></a></li>
      <li class="breadcrumb-item active"><?= esc($produk->nama_ternak) ?></li>
    </ol>
  </nav>

  <div class="row g-4">
    <!-- ===== GALERI FOTO ===== -->
    <div class="col-lg-6">
      <div id="galeriCarousel" class="carousel slide rounded-4 overflow-hidden shadow-sm" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= $produk->foto_utama ? base_url('uploads/produk/'.$produk->foto_utama) : 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=800' ?>" class="d-block w-100" style="height:420px;object-fit:cover;">
          </div>
          <?php foreach ($galeri as $g): ?>
            <div class="carousel-item">
              <img src="<?= base_url('uploads/produk/'.$g->path_foto) ?>" class="d-block w-100" style="height:420px;object-fit:cover;">
            </div>
          <?php endforeach; ?>
        </div>
        <?php if (!empty($galeri)): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#galeriCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#galeriCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
        <?php endif; ?>
      </div>

      <?php if ($produk->video_url): ?>
        <div class="ratio ratio-16x9 mt-3 rounded-4 overflow-hidden">
          <iframe src="<?= esc($produk->video_url) ?>" allowfullscreen></iframe>
        </div>
      <?php endif; ?>
    </div>

    <!-- ===== INFO PRODUK ===== -->
    <div class="col-lg-6">
      <span class="badge bg-light text-success border border-success mb-2"><?= esc($produk->nama_kategori) ?></span>
      <?= badge_status_verifikasi($produk->status_verifikasi) ?>
      <h2 class="fw-bold mt-2"><?= esc($produk->nama_ternak) ?></h2>
      <h3 class="text-success fw-bold"><?= format_rupiah($produk->harga) ?></h3>

      <div class="row g-2 my-3">
        <div class="col-6"><small class="text-muted d-block">Jenis Kelamin</small><strong><?= esc($produk->jenis_kelamin) ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Ras</small><strong><?= esc($produk->ras ?: '-') ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Umur</small><strong><?= umur_ternak_text($produk->umur_tahun, $produk->umur_bulan) ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Bobot</small><strong><?= esc($produk->bobot_kg) ?> kg</strong></div>
        <div class="col-6"><small class="text-muted d-block">Warna</small><strong><?= esc($produk->warna ?: '-') ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Status Kesehatan</small><strong><?= esc($produk->status_kesehatan) ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Status Vaksin</small><strong><?= esc($produk->status_vaksin) ?></strong></div>
        <div class="col-6"><small class="text-muted d-block">Tanggal Upload</small><strong><?= date('d M Y', strtotime($produk->created_at)) ?></strong></div>
      </div>

      <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-success"></i> <?= esc($produk->alamat_lengkap ?: 'Lokasi tidak dicantumkan') ?></p>
      <p class="text-muted"><i class="bi bi-eye-fill text-success"></i> <?= number_format($produk->jumlah_dilihat) ?> kali dilihat</p>

      <hr>

      <!-- ===== INFO PETERNAK ===== -->
      <div class="d-flex align-items-center gap-3 mb-3">
        <img src="<?= $produk->foto_peternak ? base_url('uploads/profil/'.$produk->foto_peternak) : 'https://ui-avatars.com/api/?name='.urlencode($produk->nama_peternak).'&background=198754&color=fff' ?>" class="rounded-circle" style="width:56px;height:56px;object-fit:cover;">
        <div>
          <p class="mb-0 fw-semibold"><?= esc($produk->nama_peternak) ?> <?php if($produk->peternak_verified === 'disetujui'): ?><i class="bi bi-patch-check-fill text-success"></i><?php endif; ?></p>
          <a href="<?= base_url('peternak-terpercaya/'.$produk->peternak_id) ?>" class="small">Lihat profil peternak</a>
        </div>
      </div>

      <!-- ===== TOMBOL AKSI ===== -->
      <div class="d-flex gap-2 mb-3">
        <a href="<?= $wa_link ?>" target="_blank" id="btnWhatsapp" data-produk-id="<?= $produk->id ?>"
           class="btn btn-success btn-lg flex-grow-1"><i class="bi bi-whatsapp"></i> Hubungi Penjual via WhatsApp</a>
        <button class="btn btn-outline-danger btn-lg" id="btnFavorit"><i class="bi bi-heart"></i></button>
      </div>

      <!-- ===== BAGIKAN ===== -->
      <div class="d-flex align-items-center gap-2">
        <span class="small text-muted">Bagikan:</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i></a>
        <a href="https://wa.me/?text=<?= urlencode($produk->nama_ternak.' - '.current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-success"><i class="bi bi-whatsapp"></i></a>
        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($produk->nama_ternak) ?>" target="_blank" class="btn btn-sm btn-outline-dark"><i class="bi bi-twitter-x"></i></a>
        <a href="https://t.me/share/url?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($produk->nama_ternak) ?>" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-telegram"></i></a>
      </div>
    </div>
  </div>

  <!-- ===== DESKRIPSI ===== -->
  <div class="row mt-5">
    <div class="col-lg-8">
      <h5 class="section-title">Deskripsi</h5>
      <p style="white-space:pre-line;"><?= esc($produk->deskripsi) ?></p>
    </div>
  </div>
</div>

<script>
document.getElementById('btnWhatsapp').addEventListener('click', function () {
  fetch('<?= base_url('produk/wa-klik/') . $produk->id ?>', { method: 'GET' });
});
</script>
