<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <span class="badge bg-light text-success border border-success mb-2"><?= esc($artikel->kategori_artikel) ?></span>
      <h2 class="fw-bold"><?= esc($artikel->judul) ?></h2>
      <p class="text-muted small mb-4"><i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($artikel->tanggal_terbit)) ?> · <i class="bi bi-eye"></i> <?= number_format($artikel->jumlah_dilihat) ?> dilihat</p>
      <?php if ($artikel->gambar_sampul): ?>
        <img src="<?= base_url('uploads/artikel/'.$artikel->gambar_sampul) ?>" class="img-fluid rounded-4 mb-4 w-100" style="max-height:400px;object-fit:cover;">
      <?php endif; ?>
      <div style="white-space:pre-line;line-height:1.8;"><?= esc($artikel->konten) ?></div>
    </div>
  </div>
</div>
