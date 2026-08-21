<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Dashboard Admin</h3>

      <?php if ($pending_sellers_count > 0): ?>
      <div class="alert alert-warning d-flex align-items-center justify-content-between">
        <span><i class="fa-solid fa-triangle-exclamation me-2"></i><?= $pending_sellers_count ?> peternak menunggu verifikasi</span>
        <a href="<?= base_url('admin/verifikasi-peternak') ?>" class="btn btn-sm btn-dark">Tinjau Sekarang</a>
      </div>
      <?php endif; ?>
      <?php if ($total_pending > 0): ?>
      <div class="alert alert-info d-flex align-items-center justify-content-between">
        <span><i class="fa-solid fa-circle-info me-2"></i><?= $total_pending ?> listing menunggu moderasi</span>
        <a href="<?= base_url('admin/moderasi') ?>" class="btn btn-sm btn-sisapi-green">Moderasi Sekarang</a>
      </div>
      <?php endif; ?>

      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold"><?= $total_users ?></div><div class="small text-muted">Total Pengguna</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold"><?= $total_sellers ?></div><div class="small text-muted">Total Peternak</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold"><?= $total_buyers ?></div><div class="small text-muted">Total Pembeli</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold"><?= $total_listing ?></div><div class="small text-muted">Total Listing</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold text-success"><?= $total_active ?></div><div class="small text-muted">Listing Aktif</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold"><?= $total_sold ?></div><div class="small text-muted">Terjual</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold text-warning"><?= $total_pending ?></div><div class="small text-muted">Menunggu Moderasi</div></div></div>
        <div class="col-6 col-md-3"><div class="sisapi-filter-card text-center"><div class="fs-3 fw-bold text-success"><?= $total_whatsapp_clicks ?></div><div class="small text-muted">Klik WhatsApp</div></div></div>
      </div>

      <div class="row g-4">
        <div class="col-md-6">
          <h6 class="fw-bold mb-2">Produk Paling Banyak Dilihat</h6>
          <ul class="list-group">
            <?php foreach ($most_viewed as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center small">
                <?= htmlspecialchars($p['name']) ?> <span class="badge bg-secondary"><?= $p['view_count'] ?> views</span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="col-md-6">
          <h6 class="fw-bold mb-2">Produk Paling Banyak Klik WhatsApp</h6>
          <ul class="list-group">
            <?php foreach ($most_clicked as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center small">
                <?= htmlspecialchars($p['name']) ?> <span class="badge bg-success"><?= $p['whatsapp_click_count'] ?> klik</span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
