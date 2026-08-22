<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Data Peternak <span class="badge bg-warning text-dark"><?= $jumlah_menunggu ?> menunggu</span></h6>
    <div class="btn-group btn-group-sm">
      <a href="?status=" class="btn btn-outline-secondary <?= !$status_filter?'active':'' ?>">Semua</a>
      <a href="?status=menunggu" class="btn btn-outline-warning <?= $status_filter=='menunggu'?'active':'' ?>">Menunggu</a>
      <a href="?status=disetujui" class="btn btn-outline-success <?= $status_filter=='disetujui'?'active':'' ?>">Disetujui</a>
      <a href="?status=ditolak" class="btn btn-outline-danger <?= $status_filter=='ditolak'?'active':'' ?>">Ditolak</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light"><tr><th>Nama</th><th>Username/Email</th><th>Kelompok Ternak</th><th>Tgl Daftar</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($peternak as $p): ?>
        <tr>
          <td><?= esc($p->nama_lengkap) ?></td>
          <td><?= esc($p->username) ?><br><small class="text-muted"><?= esc($p->email) ?></small></td>
          <td><?= esc($p->nama_kelompok_ternak ?: '-') ?></td>
          <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
          <td><?= badge_status_verifikasi($p->status_verifikasi) ?></td>
          <td><a href="<?= base_url('admin/peternak/verifikasi/'.$p->id) ?>" class="btn btn-sm btn-sisapi">Detail / Verifikasi</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($peternak)): ?><tr><td colspan="6" class="text-center text-muted py-4">Belum ada data.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
