<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('seller/_sidebar'); ?></div>
    <div class="col-lg-9">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold mb-0">Ternak Saya</h3>
        <a href="<?= base_url('dashboard/tambah-ternak') ?>" class="btn btn-sisapi-green btn-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Ternak</a>
      </div>

      <div class="row g-3">
        <?php foreach ($products as $p): ?>
        <div class="col-md-6">
          <div class="sisapi-product-card flex-row" style="flex-direction:row;">
            <div class="product-img-wrap" style="width:130px;flex-shrink:0;aspect-ratio:1;">
              <img src="<?= $p['main_image'] ? base_url($p['main_image']) : 'https://placehold.co/200x200/e8f5e9/1e7e34?text=Foto' ?>" alt="">
              <span class="status-badge <?= $p['status']=='sold'?'badge-sold':'' ?>" style="background:<?= $p['status']=='active'?'#198754':($p['status']=='pending'?'#ffc107':($p['status']=='rejected'?'#dc3545':'#6c757d')) ?>;color:#fff;"><?= ucfirst($p['status']) ?></span>
            </div>
            <div class="body">
              <div class="p-name"><?= htmlspecialchars($p['name']) ?></div>
              <div class="p-price"><?= format_rupiah($p['price']) ?></div>
              <div class="small text-muted mb-2"><i class="fa-solid fa-eye"></i> <?= $p['view_count'] ?> &nbsp; <i class="fa-brands fa-whatsapp"></i> <?= $p['whatsapp_click_count'] ?></div>
              <div class="d-flex gap-1 flex-wrap">
                <a href="<?= base_url('dashboard/edit/'.$p['id']) ?>" class="btn btn-outline-sisapi btn-sm">Edit</a>
                <?php if ($p['status'] !== 'sold'): ?>
                <form method="post" action="<?= base_url('dashboard/edit/'.$p['id']) ?>" class="d-inline">
                  <input type="hidden" name="action" value="mark_sold">
                  <button class="btn btn-outline-sisapi btn-sm" onclick="return confirm('Tandai listing ini sebagai Terjual?')">Tandai Terjual</button>
                </form>
                <?php endif; ?>
                <?php if ($p['status'] === 'active'): ?>
                <form method="post" action="<?= base_url('dashboard/edit/'.$p['id']) ?>" class="d-inline">
                  <input type="hidden" name="action" value="deactivate">
                  <button class="btn btn-outline-sisapi btn-sm">Nonaktifkan</button>
                </form>
                <?php elseif ($p['status'] === 'inactive'): ?>
                <form method="post" action="<?= base_url('dashboard/edit/'.$p['id']) ?>" class="d-inline">
                  <input type="hidden" name="action" value="reactivate">
                  <button class="btn btn-outline-sisapi btn-sm">Aktifkan Kembali</button>
                </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($products)): ?>
          <p class="text-muted text-center py-5">Belum ada listing. <a href="<?= base_url('dashboard/tambah-ternak') ?>">Tambah ternak pertama Anda</a>.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
