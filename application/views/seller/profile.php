<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('seller/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Profil Peternakan</h3>
      <form method="post" action="<?= base_url('dashboard/profil') ?>">
        <div class="sisapi-filter-card mb-3">
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label small fw-semibold">Nama Anda</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required></div>
            <div class="col-md-6"><label class="form-label small fw-semibold">Nomor WhatsApp</label><input type="text" name="phone_whatsapp" class="form-control" value="<?= htmlspecialchars($user['phone_whatsapp']) ?>" required></div>
            <div class="col-md-6"><label class="form-label small fw-semibold">Nama Peternakan</label><input type="text" name="farm_name" class="form-control" value="<?= htmlspecialchars($seller['farm_name']) ?>" required></div>
            <div class="col-12"><label class="form-label small fw-semibold">Deskripsi Peternakan</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($seller['description']) ?></textarea></div>
          </div>
        </div>
        <button type="submit" class="btn btn-sisapi-green px-4">Simpan Profil</button>
      </form>
    </div>
  </div>
</div>
