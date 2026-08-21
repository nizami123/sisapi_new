<div class="container py-4">
  <div class="sisapi-filter-card mb-4 d-flex flex-wrap align-items-center gap-3">
    <img src="<?= $seller['photo'] ? base_url($seller['photo']) : 'https://api.dicebear.com/7.x/initials/svg?seed='.urlencode($seller['farm_name']) ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
    <div>
      <h3 class="fw-bold mb-1"><?= htmlspecialchars($seller['farm_name']) ?> <?php if ($seller['is_verified']): ?><span class="badge-verified">✓ Peternak Terverifikasi</span><?php endif; ?></h3>
      <p class="text-muted mb-1"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($seller['address']) ?></p>
      <p class="text-muted mb-0"><?= htmlspecialchars($seller['description']) ?></p>
    </div>
  </div>

  <h5 class="fw-bold mb-3">Ternak & Produk dari <?= htmlspecialchars($seller['farm_name']) ?></h5>
  <div class="row g-3 row-cols-2 row-cols-md-4">
    <?php foreach ($products as $p): ?>
      <?php if ($p['status'] === 'active' || $p['status'] === 'sold'): ?>
      <div class="col"><?php $this->load->view('frontend/partials/product_card', array('p' => $p)); ?></div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>
