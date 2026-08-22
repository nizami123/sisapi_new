<div class="container py-5">
  <div class="card border-0 shadow-sm p-4 mb-4">
    <div class="d-flex align-items-center gap-3">
      <img src="<?= $peternak->foto_profil ? base_url('uploads/profil/'.$peternak->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($peternak->nama_lengkap).'&background=198754&color=fff' ?>" class="rounded-circle" style="width:90px;height:90px;object-fit:cover;">
      <div>
        <h4 class="fw-bold mb-1"><?= esc($peternak->nama_lengkap) ?> <i class="bi bi-patch-check-fill text-success"></i></h4>
        <p class="text-muted mb-1"><?= esc($peternak->nama_kelompok_ternak ?: 'Peternak Mandiri') ?></p>
        <p class="text-muted small mb-0"><i class="bi bi-geo-alt"></i> <?= esc($peternak->alamat) ?></p>
      </div>
    </div>
  </div>

  <h5 class="section-title">Ternak dari Peternak Ini</h5>
  <div class="row g-3">
    <?php foreach ($produk as $p): ?>
      <div class="col-6 col-md-3">
        <?php $this->load->view('produk/_card', array('p' => $p)); ?>
      </div>
    <?php endforeach; ?>
    <?php if (empty($produk)): ?><p class="text-muted">Belum ada ternak tersedia dari peternak ini.</p><?php endif; ?>
  </div>
</div>
