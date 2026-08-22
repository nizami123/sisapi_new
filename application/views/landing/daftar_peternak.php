<div class="container py-5">
  <h3 class="section-title">Peternak Terpercaya</h3>
  <p class="text-muted">Seluruh peternak berikut telah melalui proses verifikasi identitas oleh Admin Dinas.</p>
  <div class="row g-3">
    <?php foreach ($peternak as $p): ?>
      <div class="col-6 col-md-3 col-lg-2">
        <a href="<?= base_url('peternak-terpercaya/'.$p->id) ?>" class="text-decoration-none text-dark">
          <div class="peternak-card">
            <img src="<?= $p->foto_profil ? base_url('uploads/profil/'.$p->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($p->nama_lengkap).'&background=198754&color=fff' ?>" alt="<?= esc($p->nama_lengkap) ?>">
            <p class="fw-semibold small mt-2 mb-0"><?= esc($p->nama_lengkap) ?></p>
            <p class="text-muted small mb-0"><i class="bi bi-star-fill text-warning"></i> <?= number_format($p->rating_rata,1) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
    <?php if (empty($peternak)): ?><p class="text-muted">Belum ada peternak terverifikasi.</p><?php endif; ?>
  </div>
</div>
