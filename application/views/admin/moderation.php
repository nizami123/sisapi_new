<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Moderasi Listing</h3>
      <?php foreach ($pending_products as $p): ?>
      <div class="sisapi-filter-card mb-3">
        <div class="row g-3 align-items-center">
          <div class="col-md-2">
            <img src="<?= $p['main_image'] ? base_url($p['main_image']) : 'https://placehold.co/150x150' ?>" class="w-100 rounded" style="aspect-ratio:1;object-fit:cover;">
          </div>
          <div class="col-md-5">
            <div class="fw-semibold"><?= htmlspecialchars($p['name']) ?></div>
            <div class="small text-muted"><?= htmlspecialchars($p['category_name']) ?> &middot; <?= format_rupiah($p['price']) ?></div>
            <div class="small text-muted">Oleh: <?= htmlspecialchars($p['seller_name']) ?> (<?= htmlspecialchars($p['farm_name']) ?>)</div>
            <div class="small text-muted"><?= htmlspecialchars($p['address']) ?>, <?= htmlspecialchars($p['regency_name']) ?></div>
          </div>
          <div class="col-md-5 d-flex gap-2 justify-content-md-end flex-wrap">
            <a href="<?= base_url('ternak/'.$p['slug']) ?>" target="_blank" class="btn btn-outline-sisapi btn-sm">Lihat Detail</a>
            <form method="post" action="<?= base_url('admin/moderasi') ?>" class="d-inline">
              <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
              <input type="hidden" name="action" value="approve">
              <button class="btn btn-sisapi-green btn-sm">Setujui</button>
            </form>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $p['id'] ?>">Tolak</button>
          </div>
        </div>
      </div>

      <div class="modal fade" id="rejectModal<?= $p['id'] ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
          <form method="post" action="<?= base_url('admin/moderasi') ?>">
            <div class="modal-header"><h6 class="modal-title">Tolak Listing: <?= htmlspecialchars($p['name']) ?></h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
              <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
              <input type="hidden" name="action" value="reject">
              <label class="form-label small">Alasan Penolakan</label>
              <textarea name="reason" class="form-control" required></textarea>
            </div>
            <div class="modal-footer"><button class="btn btn-danger btn-sm">Tolak Listing</button></div>
          </form>
        </div></div>
      </div>
      <?php endforeach; ?>
      <?php if (empty($pending_products)): ?>
        <p class="text-muted text-center py-5">Tidak ada listing yang menunggu moderasi. 🎉</p>
      <?php endif; ?>
    </div>
  </div>
</div>
