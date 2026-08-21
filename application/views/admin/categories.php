<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Kategori</h3>
        <button class="btn btn-sisapi-green btn-sm" data-bs-toggle="modal" data-bs-target="#addCatModal">+ Tambah Kategori</button>
      </div>
      <table class="table table-striped">
        <thead><tr><th>Icon</th><th>Nama</th><th>Slug</th><th>Tipe</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php foreach ($categories as $c): ?>
          <tr>
            <td><i class="fa-solid <?= $c['icon'] ?>"></i></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><code><?= $c['slug'] ?></code></td>
            <td><?= $c['type'] === 'livestock' ? 'Ternak' : 'Produk' ?></td>
            <td><span class="badge bg-<?= $c['is_active']?'success':'secondary' ?>"><?= $c['is_active']?'Aktif':'Nonaktif' ?></span></td>
            <td>
              <form method="post" action="<?= base_url('admin/kategori') ?>" class="d-inline">
                <input type="hidden" name="category_id" value="<?= $c['id'] ?>"><input type="hidden" name="action" value="toggle">
                <button class="btn btn-sm btn-outline-sisapi"><?= $c['is_active']?'Nonaktifkan':'Aktifkan' ?></button>
              </form>
              <form method="post" action="<?= base_url('admin/kategori') ?>" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                <input type="hidden" name="category_id" value="<?= $c['id'] ?>"><input type="hidden" name="action" value="delete">
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addCatModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" action="<?= base_url('admin/kategori') ?>">
      <div class="modal-header"><h6 class="modal-title">Tambah Kategori</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" name="action" value="add">
        <div class="mb-2"><label class="form-label small">Nama Kategori</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-2"><label class="form-label small">Icon (Font Awesome, cth: fa-cow)</label><input type="text" name="icon" class="form-control" placeholder="fa-cow"></div>
        <div class="mb-2"><label class="form-label small">Tipe</label>
          <select name="type" class="form-select"><option value="livestock">Ternak</option><option value="product">Produk</option></select>
        </div>
        <div class="mb-2"><label class="form-label small">Urutan</label><input type="number" name="sort_order" class="form-control" value="0"></div>
      </div>
      <div class="modal-footer"><button class="btn btn-sisapi-green btn-sm">Simpan</button></div>
    </form>
  </div></div>
</div>
