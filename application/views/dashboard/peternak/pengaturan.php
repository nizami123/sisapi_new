<div class="card border-0 shadow-sm p-4" style="max-width:500px;">
  <h6 class="fw-bold mb-3">Ganti Password</h6>
  <?= form_open('dashboard/pengaturan') ?>
    <div class="mb-3"><label class="form-label">Password Lama</label><input type="password" name="password_lama" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Password Baru</label><input type="password" name="password_baru" class="form-control" minlength="8" required></div>
    <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_baru_confirm" class="form-control" minlength="8" required></div>
    <button type="submit" class="btn btn-sisapi"><i class="bi bi-key"></i> Perbarui Password</button>
  <?= form_close() ?>
</div>
