<div class="row g-4">
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Tambah Banner</h6>
      <?= form_open_multipart('admin/banner') ?>
        <div class="mb-2"><label class="form-label small">Judul</label><input type="text" name="judul" class="form-control"></div>
        <div class="mb-2"><label class="form-label small">Gambar (disarankan 1600x500px)</label><input type="file" name="gambar" class="form-control" accept="image/*" required></div>
        <div class="mb-2"><label class="form-label small">Link Tujuan (opsional)</label><input type="text" name="link_url" class="form-control"></div>
        <div class="mb-3"><label class="form-label small">Urutan</label><input type="number" name="urutan" class="form-control" value="0"></div>
        <button type="submit" class="btn btn-sisapi w-100"><i class="bi bi-upload"></i> Unggah Banner</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Daftar Banner</h6>
      <div class="row g-3">
      <?php foreach ($banner as $b): ?>
        <div class="col-md-6">
          <div class="border rounded overflow-hidden">
            <img src="<?= base_url('uploads/banner/'.$b->gambar) ?>" class="w-100" style="height:120px;object-fit:cover;">
            <div class="p-2 small d-flex justify-content-between">
              <span><?= esc($b->judul ?: '(tanpa judul)') ?></span>
              <?= $b->status ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($banner)): ?><p class="text-muted">Belum ada banner.</p><?php endif; ?>
      </div>
    </div>
  </div>
</div>
