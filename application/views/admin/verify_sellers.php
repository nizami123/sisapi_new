<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Verifikasi Peternak</h3>
      <?php foreach ($pending as $s): ?>
      <div class="sisapi-filter-card mb-3">
        <div class="row g-3 align-items-center">
          <div class="col-md-2 text-center">
            <img src="<?= $s['photo'] ? base_url($s['photo']) : 'https://api.dicebear.com/7.x/initials/svg?seed='.urlencode($s['farm_name']) ?>" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
          </div>
          <div class="col-md-6">
            <div class="fw-semibold"><?= htmlspecialchars($s['farm_name']) ?></div>
            <div class="small text-muted">Pemilik: <?= htmlspecialchars($s['name']) ?> &middot; <?= htmlspecialchars($s['email']) ?></div>
            <div class="small text-muted"><i class="fa-brands fa-whatsapp"></i> <?= htmlspecialchars($s['phone_whatsapp']) ?></div>
            <div class="small text-muted"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($s['address']) ?></div>
          </div>
          <div class="col-md-4 d-flex gap-2 justify-content-md-end flex-wrap">
            <form method="post" action="<?= base_url('admin/verifikasi-peternak') ?>">
              <input type="hidden" name="seller_id" value="<?= $s['id'] ?>">
              <input type="hidden" name="action" value="verify">
              <button class="btn btn-sisapi-green btn-sm">Verifikasi</button>
            </form>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejSell<?= $s['id'] ?>">Tolak</button>
          </div>
        </div>
      </div>
      <div class="modal fade" id="rejSell<?= $s['id'] ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
          <form method="post" action="<?= base_url('admin/verifikasi-peternak') ?>">
            <div class="modal-header"><h6 class="modal-title">Tolak Pendaftaran: <?= htmlspecialchars($s['farm_name']) ?></h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
              <input type="hidden" name="seller_id" value="<?= $s['id'] ?>">
              <input type="hidden" name="action" value="reject">
              <textarea name="reason" class="form-control" placeholder="Alasan penolakan" required></textarea>
            </div>
            <div class="modal-footer"><button class="btn btn-danger btn-sm">Tolak</button></div>
          </form>
        </div></div>
      </div>
      <?php endforeach; ?>
      <?php if (empty($pending)): ?>
        <p class="text-muted text-center py-5">Tidak ada peternak yang menunggu verifikasi.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
