<div class="container py-5">
  <h3 class="section-title">Artikel Peternakan</h3>
  <div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="<?= base_url('artikel') ?>" class="btn btn-sm <?= !$kategori_filter?'btn-sisapi':'btn-outline-sisapi' ?>">Semua</a>
    <?php foreach (['Peternakan','Kesehatan Hewan','Budidaya','Harga Pasar','Berita'] as $kat): ?>
      <a href="?kategori=<?= urlencode($kat) ?>" class="btn btn-sm <?= $kategori_filter==$kat?'btn-sisapi':'btn-outline-sisapi' ?>"><?= esc($kat) ?></a>
    <?php endforeach; ?>
  </div>
  <div class="row g-4">
    <?php foreach ($artikel as $a): ?>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?= $a->gambar_sampul ? base_url('uploads/artikel/'.$a->gambar_sampul) : 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=500' ?>" class="card-img-top" style="height:180px;object-fit:cover;">
          <div class="card-body">
            <span class="badge bg-light text-success border border-success mb-2"><?= esc($a->kategori_artikel) ?></span>
            <h6><a href="<?= base_url('artikel/'.$a->slug) ?>" class="text-dark"><?= esc($a->judul) ?></a></h6>
            <p class="small text-muted"><?= esc(mb_substr(strip_tags($a->ringkasan ?: $a->konten), 0, 100)) ?>...</p>
            <p class="small text-muted mb-0"><?= date('d M Y', strtotime($a->tanggal_terbit)) ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (empty($artikel)): ?><p class="text-muted">Belum ada artikel.</p><?php endif; ?>
  </div>
</div>
