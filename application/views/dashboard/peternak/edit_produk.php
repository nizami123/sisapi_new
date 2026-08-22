<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Edit Ternak <?= badge_status_verifikasi($produk->status_verifikasi) ?></h6>
  <p class="small text-muted">Perubahan data akan dikirim ulang untuk diverifikasi Admin Dinas.</p>
  <?= form_open('dashboard/produk/edit/'.$produk->id) ?>
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Ternak</label><input type="text" name="nama_ternak" class="form-control" value="<?= esc($produk->nama_ternak) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Harga (Rp)</label><input type="number" name="harga" class="form-control" value="<?= esc($produk->harga) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Bobot (kg)</label><input type="number" step="0.1" name="bobot_kg" class="form-control" value="<?= esc($produk->bobot_kg) ?>"></div>
      <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="4"><?= esc($produk->deskripsi) ?></textarea></div>
    </div>
    <button type="submit" class="btn btn-sisapi mt-3"><i class="bi bi-save"></i> Simpan Perubahan</button>
  <?= form_close() ?>
</div>
