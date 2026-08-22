<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Data Produk <span class="badge bg-warning text-dark"><?= $jumlah_menunggu ?> menunggu</span></h6>
    <div class="btn-group btn-group-sm">
      <a href="?status=" class="btn btn-outline-secondary <?= !$status_filter?'active':'' ?>">Semua</a>
      <a href="?status=menunggu" class="btn btn-outline-warning <?= $status_filter=='menunggu'?'active':'' ?>">Menunggu</a>
      <a href="?status=disetujui" class="btn btn-outline-success <?= $status_filter=='disetujui'?'active':'' ?>">Disetujui</a>
      <a href="?status=ditolak" class="btn btn-outline-danger <?= $status_filter=='ditolak'?'active':'' ?>">Ditolak</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light"><tr><th>Foto</th><th>Nama Ternak</th><th>Kategori</th><th>Peternak</th><th>Harga</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($produk as $p): ?>
        <tr>
          <td><img src="<?= $p->foto_utama ? base_url('uploads/produk/'.$p->foto_utama) : 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=100' ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;"></td>
          <td><?= esc($p->nama_ternak) ?></td>
          <td><?= esc($p->nama_kategori) ?></td>
          <td><?= esc($p->nama_peternak) ?></td>
          <td><?= format_rupiah($p->harga) ?></td>
          <td><?= badge_status_verifikasi($p->status_verifikasi) ?></td>
          <td><a href="<?= base_url('admin/produk/verifikasi/'.$p->id) ?>" class="btn btn-sm btn-sisapi">Detail / Verifikasi</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($produk)): ?><tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
