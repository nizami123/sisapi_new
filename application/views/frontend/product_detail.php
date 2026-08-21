<?php
$main_img = !empty($images) ? base_url($images[0]['image_path']) : 'https://placehold.co/800x600/e8f5e9/1e7e34?text=' . urlencode($product['category_name']);
$current_url = current_url();
?>
<div class="container py-4">

  <!-- BREADCRUMB -->
  <nav class="small text-muted mb-3">
    <a href="<?= base_url() ?>" class="text-muted">Beranda</a> &rsaquo;
    <a href="<?= base_url('kategori/'.$product['category_slug']) ?>" class="text-muted"><?= htmlspecialchars($product['category_name']) ?></a> &rsaquo;
    <span><?= htmlspecialchars($product['name']) ?></span>
  </nav>

  <div class="row g-4">
    <!-- GALLERY -->
    <div class="col-lg-7">
      <div class="position-relative">
        <img id="main-product-image" src="<?= $main_img ?>" class="w-100 rounded-4" style="aspect-ratio:4/3;object-fit:cover;" alt="<?= htmlspecialchars($product['name']) ?>">
        <?php if (!empty($product['distance_km'])): ?>
          <span class="distance-badge position-absolute top-0 start-0 m-2"><?= number_format($product['distance_km'],1) ?> km</span>
        <?php endif; ?>
      </div>
      <?php if (count($images) > 1): ?>
      <div class="detail-thumb-strip d-flex gap-2 mt-2 flex-wrap">
        <?php foreach ($images as $i => $img): ?>
          <img src="<?= base_url($img['image_path']) ?>" data-full="<?= base_url($img['image_path']) ?>" class="<?= $i==0?'active':'' ?>">
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- DESKRIPSI -->
      <div class="mt-4">
        <h5 class="fw-bold">Deskripsi</h5>
        <p style="white-space:pre-line;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      </div>

      <!-- INFO TERNAK -->
      <?php if ($livestock): ?>
      <div class="mt-4">
        <h5 class="fw-bold">Informasi Ternak</h5>
        <table class="table sisapi-info-table mb-0">
          <tr><td>Jenis</td><td><?= htmlspecialchars($livestock['jenis'] ?: '-') ?></td></tr>
          <tr><td>Ras</td><td><?= htmlspecialchars($livestock['ras'] ?: '-') ?></td></tr>
          <tr><td>Jenis Kelamin</td><td><?= htmlspecialchars($livestock['jenis_kelamin'] ?: '-') ?></td></tr>
          <tr><td>Umur</td><td><?= htmlspecialchars($livestock['umur'] ?: '-') ?></td></tr>
          <tr><td>Berat</td><td><?= htmlspecialchars($livestock['berat'] ?: '-') ?></td></tr>
          <tr><td>Warna</td><td><?= htmlspecialchars($livestock['warna'] ?: '-') ?></td></tr>
          <tr><td>Kondisi</td><td><?= htmlspecialchars($livestock['kondisi_kesehatan'] ?: '-') ?></td></tr>
          <tr><td>Vaksinasi</td><td><?= htmlspecialchars($livestock['status_vaksinasi'] ?: '-') ?></td></tr>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- SIDEBAR: HARGA, PENJUAL, WHATSAPP, PETA -->
    <div class="col-lg-5">
      <h2 class="fw-bold fs-4 mb-1"><?= htmlspecialchars($product['name']) ?></h2>
      <div class="fs-3 fw-800 mb-2" style="color:var(--sisapi-green-dark);font-weight:800;"><?= format_rupiah($product['price']) ?></div>
      <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($product['address']) ?>, <?= htmlspecialchars($product['district_name']) ?>, <?= htmlspecialchars($product['regency_name']) ?></p>

      <?php if ($product['status'] === 'sold'): ?>
        <div class="alert alert-danger py-2 mb-3"><i class="fa-solid fa-circle-xmark me-1"></i> Produk ini sudah <strong>Terjual</strong></div>
      <?php else: ?>
        <button class="btn btn-whatsapp mb-2" onclick="sisapiTrackWhatsapp(<?= $product['id'] ?>, '<?= $whatsapp_link ?>')">
          <i class="fa-brands fa-whatsapp me-1"></i> Hubungi Penjual via WhatsApp
        </button>
      <?php endif; ?>

      <div class="d-flex gap-2 mb-3">
        <button class="btn btn-outline-sisapi btn-sm flex-fill" onclick="sisapiToggleFavorite(<?= $product['id'] ?>, this)"><i class="fa-regular fa-heart me-1"></i> Favorit</button>
        <button class="btn btn-outline-sisapi btn-sm flex-fill" onclick="sisapiShareProduct('<?= htmlspecialchars($product['name']) ?>', '<?= $current_url ?>')"><i class="fa-solid fa-share-nodes me-1"></i> Bagikan</button>
        <button class="btn btn-outline-sisapi btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="fa-solid fa-flag"></i></button>
      </div>

      <!-- INFO PENJUAL -->
      <a href="<?= base_url('peternak/' . $product['seller_profile_id']) ?>" class="sisapi-seller-card text-decoration-none d-flex mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="https://api.dicebear.com/7.x/initials/svg?seed=<?= urlencode($product['farm_name']) ?>" class="avatar" alt="">
          <div>
            <div class="seller-name">Oleh <?= htmlspecialchars($product['seller_name']) ?> <?php if ($product['is_verified']): ?><span class="badge-verified ms-1">✓ Peternak Terverifikasi</span><?php endif; ?></div>
            <div class="seller-loc"><?= htmlspecialchars($product['farm_name']) ?></div>
          </div>
        </div>
      </a>

      <!-- PETA LOKASI -->
      <h6 class="fw-bold mb-2"><i class="fa-solid fa-map-location-dot me-1"></i> Lokasi Ternak</h6>
      <div id="map-detail" class="mb-2"></div>
      <button class="btn btn-outline-sisapi btn-sm w-100" onclick="sisapiNavigateTo(<?= $product['latitude'] ?>, <?= $product['longitude'] ?>)">
        <i class="fa-solid fa-diamond-turn-right me-1"></i> Navigasi ke Lokasi Ternak
      </button>
    </div>
  </div>
</div>

<!-- MODAL LAPORKAN -->
<div class="modal fade" id="reportModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Laporkan Listing</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <textarea id="report_reason" class="form-control" rows="3" placeholder="Jelaskan alasan pelaporan..."></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sisapi-green" onclick="sisapiSubmitReport(<?= $product['id'] ?>)">Kirim Laporan</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  sisapiRenderStaticMap('map-detail', <?= $product['latitude'] ?: 'null' ?>, <?= $product['longitude'] ?: 'null' ?>, '<?= htmlspecialchars($product['name']) ?>');
});
function sisapiSubmitReport(productId) {
  const reason = document.getElementById('report_reason').value;
  if (!reason) return;
  const fd = new FormData(); fd.append('reason', reason);
  fetch(SISAPI_BASE_URL + 'product/report/' + productId, { method: 'POST', body: fd })
    .then(r => r.json()).then(() => {
      bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
      Swal.fire('Terkirim', 'Laporan Anda telah diterima, tim SISAPI akan meninjau listing ini.', 'success');
    });
}
</script>
