<div class="container py-4">
  <h3 class="fw-bold mb-1">Peternak Terverifikasi</h3>
  <p class="text-muted mb-4">Peternak yang telah diverifikasi identitas dan lokasinya oleh tim SISAPI.</p>
  <div class="row g-3">
    <?php foreach ($sellers as $s): ?>
    <div class="col-md-6 col-lg-4">
      <a href="<?= base_url('peternak/'.$s['id']) ?>" class="sisapi-seller-card text-decoration-none d-flex">
        <div class="d-flex align-items-center gap-2">
          <img src="<?= $s['photo'] ? base_url($s['photo']) : 'https://api.dicebear.com/7.x/initials/svg?seed='.urlencode($s['farm_name']) ?>" class="avatar">
          <div>
            <div class="seller-name"><?= htmlspecialchars($s['farm_name']) ?> <i class="fa-solid fa-circle-check verified-tick"></i></div>
            <div class="seller-loc"><?= htmlspecialchars($s['address']) ?></div>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
    <?php if (empty($sellers)): ?><p class="text-muted">Belum ada peternak terverifikasi.</p><?php endif; ?>
  </div>
</div>
