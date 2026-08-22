<?php if ($peternak->status_verifikasi !== 'disetujui'): ?>
  <div class="alert alert-<?= $peternak->status_verifikasi=='menunggu'?'warning':($peternak->status_verifikasi=='ditolak'?'danger':'info') ?>">
    <?php if ($peternak->status_verifikasi=='menunggu'): ?>
      <i class="bi bi-hourglass-split"></i> Akun Anda sedang <strong>menunggu verifikasi</strong> Admin Dinas. Anda belum dapat mengunggah ternak.
    <?php elseif ($peternak->status_verifikasi=='ditolak'): ?>
      <i class="bi bi-x-circle"></i> Pendaftaran Anda <strong>ditolak</strong>. Catatan: <?= esc($peternak->catatan_verifikasi) ?>
    <?php else: ?>
      <i class="bi bi-pencil-square"></i> Admin meminta <strong>perbaikan data</strong>. Catatan: <?= esc($peternak->catatan_verifikasi) ?> — silakan hubungi Admin Dinas untuk perbaikan.
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="stat-box"><div class="angka"><?= $jumlah_produk ?></div><p class="mb-0">Total Ternak Diunggah</p></div>
  </div>
  <div class="col-md-4">
    <div class="stat-box"><div class="angka"><?= badge_status_verifikasi($peternak->status_verifikasi) ?></div><p class="mb-0">Status Akun</p></div>
  </div>
  <div class="col-md-4">
    <div class="stat-box">
      <a href="<?= base_url('dashboard/produk/tambah') ?>" class="btn btn-sisapi w-100 mt-2"><i class="bi bi-plus-circle"></i> Tambah Ternak Baru</a>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm p-3">
  <h6 class="fw-bold mb-3">Ternak Terbaru Saya</h6>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light"><tr><th>Nama</th><th>Harga</th><th>Status</th><th>Dilihat</th></tr></thead>
      <tbody>
        <?php foreach ($produk_terbaru as $p): ?>
        <tr>
          <td><?= esc($p->nama_ternak) ?></td>
          <td><?= format_rupiah($p->harga) ?></td>
          <td><?= badge_status_verifikasi($p->status_verifikasi) ?></td>
          <td><?= number_format($p->jumlah_dilihat) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($produk_terbaru)): ?><tr><td colspan="4" class="text-center text-muted py-4">Belum ada ternak yang diunggah.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
