<?php
/**
 * Partial: card produk. Variabel $p wajib berisi array hasil query Product_model.
 */
$img = $p['main_image'] ? base_url($p['main_image']) : 'https://placehold.co/400x300/e8f5e9/1e7e34?text=' . urlencode($p['category_name']);
$is_new = isset($p['created_at']) && (strtotime($p['created_at']) > strtotime('-7 days'));
?>
<div class="sisapi-product-card">
  <a href="<?= base_url('ternak/' . $p['slug']) ?>" class="text-decoration-none text-reset">
    <div class="product-img-wrap">
      <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">
      <?php if (isset($p['distance_km']) && $p['distance_km'] !== NULL): ?>
        <span class="distance-badge"><?= number_format($p['distance_km'],1) ?> km</span>
      <?php endif; ?>
      <?php if ($p['status'] === 'sold'): ?>
        <span class="status-badge badge-sold">Terjual</span>
      <?php elseif ($is_new): ?>
        <span class="status-badge badge-new">Baru</span>
      <?php endif; ?>
    </div>
    <div class="body">
      <div class="p-name"><?= htmlspecialchars($p['name']) ?></div>
      <div class="p-price"><?= format_rupiah($p['price']) ?><?= in_array($p['category_slug'], array('pakan-ternak')) ? '/50kg' : '' ?></div>
      <div class="p-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($p['district_name'] ?: $p['regency_name']) ?>, <?= htmlspecialchars($p['regency_name']) ?></div>
      <div class="p-footer">
        <span class="seller"><?= htmlspecialchars($p['seller_name'] ?: $p['farm_name']) ?> <?php if ($p['is_verified']): ?><i class="fa-solid fa-circle-check verified-tick"></i><?php endif; ?></span>
        <span><i class="fa-solid fa-star text-warning"></i> <?= number_format($p['rating_avg'],1) ?></span>
      </div>
    </div>
  </a>
</div>
