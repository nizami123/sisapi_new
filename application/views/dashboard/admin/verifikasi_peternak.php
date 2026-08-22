<div class="row g-4">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-4">
      <h6 class="fw-bold mb-3">Data Identitas Peternak <?= badge_status_verifikasi($peternak->status_verifikasi) ?></h6>
      <div class="row g-2 mb-4">
        <div class="col-md-6"><small class="text-muted d-block">Nama Lengkap</small><strong><?= esc($peternak->nama_lengkap) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">NIK</small><strong><?= esc($peternak->nik) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Nomor KK</small><strong><?= esc($peternak->no_kk) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Tempat, Tanggal Lahir</small><strong><?= esc($peternak->tempat_lahir) ?>, <?= date('d M Y', strtotime($peternak->tanggal_lahir)) ?></strong></div>
        <div class="col-md-12"><small class="text-muted d-block">Alamat</small><strong><?= esc($peternak->alamat) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Nomor HP</small><strong><?= esc($peternak->nomor_hp) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Email</small><strong><?= esc($peternak->email) ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Kelompok Ternak</small><strong><?= esc($peternak->nama_kelompok_ternak ?: '-') ?></strong></div>
        <div class="col-md-6"><small class="text-muted d-block">Jenis Usaha</small><strong><?= esc($peternak->jenis_usaha ?: '-') ?></strong></div>
      </div>

      <h6 class="fw-bold mb-3">Dokumen Verifikasi</h6>
      <div class="row g-3 mb-4">
        <div class="col-md-4 text-center">
          <p class="small mb-1">Foto KTP</p>
          <img src="<?= base_url('uploads/ktp/'.$peternak->foto_ktp) ?>" class="img-fluid rounded border" style="max-height:180px;">
        </div>
        <div class="col-md-4 text-center">
          <p class="small mb-1">Selfie dengan KTP</p>
          <img src="<?= base_url('uploads/selfie/'.$peternak->foto_selfie_ktp) ?>" class="img-fluid rounded border" style="max-height:180px;">
        </div>
        <div class="col-md-4 text-center">
          <p class="small mb-1">Foto Kandang</p>
          <img src="<?= base_url('uploads/kandang/'.$peternak->foto_kandang) ?>" class="img-fluid rounded border" style="max-height:180px;">
        </div>
      </div>

      <?php if ($peternak->latitude): ?>
      <h6 class="fw-bold mb-2">Lokasi (Google Maps)</h6>
      <div class="ratio ratio-16x9 mb-4 rounded overflow-hidden border">
        <iframe src="https://maps.google.com/maps?q=<?= $peternak->latitude ?>,<?= $peternak->longitude ?>&z=15&output=embed"></iframe>
      </div>
      <?php endif; ?>

      <h6 class="fw-bold mb-3">Form Verifikasi</h6>
      <?= form_open('admin/peternak/verifikasi/'.$peternak->id) ?>
        <div class="mb-3">
          <label class="form-label">Catatan Verifikasi</label>
          <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Foto KTP kurang jelas, mohon unggah ulang."><?= esc($peternak->catatan_verifikasi) ?></textarea>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="aksi" value="disetujui" class="btn btn-success"><i class="bi bi-check-circle"></i> Approve</button>
          <button type="submit" name="aksi" value="perbaikan" class="btn btn-info text-white"><i class="bi bi-pencil-square"></i> Minta Perbaikan</button>
          <button type="submit" name="aksi" value="ditolak" class="btn btn-danger"><i class="bi bi-x-circle"></i> Reject</button>
        </div>
      <?= form_close() ?>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Riwayat Verifikasi</h6>
      <ul class="list-unstyled small">
        <?php foreach ($riwayat as $r): ?>
          <li class="mb-2 pb-2 border-bottom">
            <strong><?= esc($r->aksi) ?></strong> - <?= date('d M Y H:i', strtotime($r->created_at)) ?><br>
            <span class="text-muted"><?= esc($r->catatan) ?></span>
          </li>
        <?php endforeach; ?>
        <?php if (empty($riwayat)): ?><li class="text-muted">Belum ada riwayat.</li><?php endif; ?>
      </ul>
    </div>
  </div>
</div>
