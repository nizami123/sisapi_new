<div class="row g-4">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-4">
      <h6 class="fw-bold mb-3">Detail Produk <?= badge_status_verifikasi($produk->status_verifikasi) ?></h6>

      <?php if ($produk->status_peternak !== 'disetujui'): ?>
        <div class="alert alert-warning small"><i class="bi bi-exclamation-triangle"></i> Peringatan: akun peternak pemilik produk ini belum/tidak berstatus disetujui.</div>
      <?php endif; ?>

      <div class="row g-2 mb-3">
        <?php if ($produk->foto_utama): ?>
          <div class="col-3"><img src="<?= base_url('uploads/produk/'.$produk->foto_utama) ?>" class="img-fluid rounded"></div>
        <?php endif; ?>
        <?php foreach ($galeri as $g): ?>
          <div class="col-3"><img src="<?= base_url('uploads/produk/'.$g->path_foto) ?>" class="img-fluid rounded"></div>
        <?php endforeach; ?>
      </div>

      <div class="row g-2 mb-4">
        <div class="col-md-6"><small class="text-muted d-block">Nama Ternak</small><strong><?= esc($produk->nama_ternak) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Peternak</small><strong><?= esc($produk->nama_peternak) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Harga</small><strong><?= format_rupiah($produk->harga) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Ras</small><strong><?= esc($produk->ras) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Umur</small><strong><?= umur_ternak_text($produk->umur_tahun, $produk->umur_bulan) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Bobot</small><strong><?= esc($produk->bobot_kg) ?> kg</strong></div>
        <div class="col-12"><small class="text-muted d-block">Deskripsi</small><p><?= esc($produk->deskripsi) ?></p></div>
      </div>

      <h6 class="fw-bold mb-3">Form Verifikasi</h6>
      <?= form_open('admin/produk/verifikasi/'.$produk->id) ?>
        <div class="mb-3">
          <label class="form-label">Catatan Verifikasi</label>
          <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Foto tidak jelas / harga tidak wajar."><?= esc($produk->catatan_verifikasi) ?></textarea>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="aksi" value="disetujui" class="btn btn-success"><i class="bi bi-check-circle"></i> Approve</button>
          <button type="submit" name="aksi" value="ditolak" class="btn btn-danger"><i class="bi bi-x-circle"></i> Reject</button>
        </div>
      <?= form_close() ?>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Statistik Produk</h6>
      <p class="mb-1"><i class="bi bi-eye"></i> <?= number_format($produk->jumlah_dilihat) ?> dilihat</p>
      <p class="mb-1"><i class="bi bi-whatsapp"></i> <?= number_format($produk->jumlah_klik_wa) ?> klik WhatsApp</p>
      <p class="mb-0"><i class="bi bi-calendar"></i> Diunggah <?= date('d M Y', strtotime($produk->created_at)) ?></p>
    </div>
  </div>
</div>
