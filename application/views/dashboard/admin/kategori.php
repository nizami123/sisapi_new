<div class="row g-4">
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Tambah Kategori</h6>
      <?= form_open('admin/kategori') ?>
        <div class="mb-2"><label class="form-label small">Nama Kategori</label><input type="text" name="nama_kategori" class="form-control" required></div>
        <div class="mb-2"><label class="form-label small">Icon (Bootstrap Icons class)</label><input type="text" name="icon" class="form-control" placeholder="bi-egg-fried"></div>
        <div class="mb-2"><label class="form-label small">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
        <div class="mb-3"><label class="form-label small">Urutan</label><input type="number" name="urutan" class="form-control" value="0"></div>
        <button type="submit" class="btn btn-sisapi w-100"><i class="bi bi-plus-circle"></i> Tambah</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Daftar Kategori</h6>
      <table class="table table-hover align-middle">
        <thead class="table-light"><tr><th>Icon</th><th>Nama</th><th>Slug</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($kategori as $k): ?>
          <tr>
            <td><i class="bi <?= esc($k->icon ?: 'bi-box') ?> fs-5 text-success"></i></td>
            <td><?= esc($k->nama_kategori) ?></td>
            <td><code><?= esc($k->slug) ?></code></td>
            <td><?= $k->status ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
