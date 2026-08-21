<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3">
      <?php $this->load->view('seller/_sidebar'); ?>
    </div>
    <div class="col-lg-9">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Dashboard Peternak</h3>
          <p class="text-muted mb-0"><?= htmlspecialchars($seller['farm_name']) ?>
            <?php if ($seller['is_verified']): ?><span class="badge-verified ms-1">✓ Peternak Terverifikasi</span>
            <?php else: ?><span class="badge bg-warning text-dark ms-1">Menunggu Verifikasi</span><?php endif; ?>
          </p>
        </div>
        <a href="<?= base_url('dashboard/tambah-ternak') ?>" class="btn btn-sisapi-green"><i class="fa-solid fa-plus me-1"></i> Tambah Ternak</a>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="sisapi-filter-card text-center">
            <div class="fs-3 fw-bold text-success"><?= $total_active ?></div>
            <div class="small text-muted">Listing Aktif</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sisapi-filter-card text-center">
            <div class="fs-3 fw-bold"><?= $total_sold ?></div>
            <div class="small text-muted">Terjual</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sisapi-filter-card text-center">
            <div class="fs-3 fw-bold"><?= $total_views ?></div>
            <div class="small text-muted">Jumlah Kunjungan</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sisapi-filter-card text-center">
            <div class="fs-3 fw-bold text-success"><?= $total_whatsapp_clicks ?></div>
            <div class="small text-muted">Klik WhatsApp</div>
          </div>
        </div>
      </div>

      <h5 class="fw-bold mb-3">Listing Terbaru</h5>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Views</th><th>WA</th></tr></thead>
          <tbody>
          <?php foreach ($recent_products as $p): ?>
            <tr>
              <td><a href="<?= base_url('ternak/'.$p['slug']) ?>"><?= htmlspecialchars($p['name']) ?></a></td>
              <td><?= htmlspecialchars($p['category_name']) ?></td>
              <td><?= format_rupiah($p['price']) ?></td>
              <td><span class="badge bg-<?= $p['status']=='active'?'success':($p['status']=='pending'?'warning text-dark':($p['status']=='sold'?'danger':'secondary')) ?>"><?= ucfirst($p['status']) ?></span></td>
              <td><?= $p['view_count'] ?></td>
              <td><?= $p['whatsapp_click_count'] ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($recent_products)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada listing. <a href="<?= base_url('dashboard/tambah-ternak') ?>">Tambah sekarang</a>.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
