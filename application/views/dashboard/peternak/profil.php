<div class="row g-4">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-4">
      <h6 class="fw-bold mb-3">Profil Saya <?= badge_status_verifikasi($peternak->status_verifikasi) ?></h6>
      <?= form_open('dashboard/profil') ?>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="<?= esc($peternak->nama_lengkap) ?>" disabled>
            <small class="text-muted">Hubungi Admin Dinas untuk mengubah data identitas.</small>
          </div>
          <div class="col-md-6"><label class="form-label">NIK</label><input type="text" class="form-control" value="<?= esc($peternak->nik) ?>" disabled></div>
          <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?= esc($peternak->alamat) ?></textarea></div>
          <div class="col-md-6"><label class="form-label">Nama Kelompok Ternak</label><input type="text" name="nama_kelompok_ternak" class="form-control" value="<?= esc($peternak->nama_kelompok_ternak) ?>"></div>
          <div class="col-md-6"><label class="form-label">Jenis Usaha</label><input type="text" name="jenis_usaha" class="form-control" value="<?= esc($peternak->jenis_usaha) ?>"></div>
        </div>
        <button type="submit" class="btn btn-sisapi mt-3"><i class="bi bi-save"></i> Simpan Perubahan</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3 text-center">
      <img src="<?= $peternak->foto_profil ? base_url('uploads/profil/'.$peternak->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($peternak->nama_lengkap).'&background=198754&color=fff' ?>" class="rounded-circle mx-auto mb-3" style="width:100px;height:100px;object-fit:cover;">
      <p class="fw-bold mb-0"><?= esc($peternak->nama_lengkap) ?></p>
      <p class="text-muted small"><?= esc($peternak->username) ?></p>
      <?php if ($peternak->status_verifikasi === 'ditolak' || $peternak->status_verifikasi === 'perbaikan'): ?>
        <div class="alert alert-warning small mt-2 text-start"><?= esc($peternak->catatan_verifikasi) ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>
