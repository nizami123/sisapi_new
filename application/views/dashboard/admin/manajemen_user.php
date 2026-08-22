<div class="row g-4">
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Tambah User Admin</h6>
      <?= form_open('admin/user') ?>
        <div class="mb-2"><label class="form-label small">Role</label>
          <select name="role_id" class="form-select" required><option value="1">Super Admin (Dinas)</option><option value="2">Admin Peternak</option></select>
        </div>
        <div class="mb-2"><label class="form-label small">Username</label><input type="text" name="username" class="form-control" required></div>
        <div class="mb-2"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label small">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div>
        <button type="submit" class="btn btn-sisapi w-100"><i class="bi bi-person-plus"></i> Tambah User</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Daftar User Sistem</h6>
      <table class="table table-hover align-middle">
        <thead class="table-light"><tr><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= esc($u->username) ?></td>
            <td><?= esc($u->email) ?></td>
            <td><span class="badge bg-light text-dark border"><?= esc($u->nama_role) ?></span></td>
            <td><?= $u->status === 'aktif' ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">'.esc($u->status).'</span>' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
