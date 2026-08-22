<?php if ($status_verif_akun !== 'disetujui'): ?>
  <div class="alert alert-warning"><i class="bi bi-info-circle"></i> Anda belum bisa menambahkan ternak baru sampai akun Anda diverifikasi Admin Dinas.</div>
<?php endif; ?>

<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Data Ternak Saya</h6>
    <a href="<?= base_url('dashboard/produk/tambah') ?>" class="btn btn-sisapi btn-sm <?= $status_verif_akun!=='disetujui'?'disabled':'' ?>"><i class="bi bi-plus-circle"></i> Tambah Ternak</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light"><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Dilihat</th><th>Klik WA</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($produk as $p): ?>
        <tr>
          <td><img src="<?= $p->foto_utama ? base_url('uploads/produk/'.$p->foto_utama) : 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=100' ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;"></td>
          <td><?= esc($p->nama_ternak) ?></td>
          <td><?= esc($p->nama_kategori) ?></td>
          <td><?= format_rupiah($p->harga) ?></td>
          <td><?= badge_status_verifikasi($p->status_verifikasi) ?></td>
          <td><?= number_format($p->jumlah_dilihat) ?></td>
          <td><?= number_format($p->jumlah_klik_wa) ?></td>
          <td>
            <a href="<?= base_url('dashboard/produk/edit/'.$p->id) ?>" class="btn btn-sm btn-outline-sisapi"><i class="bi bi-pencil"></i></a>
            <a href="<?= base_url('dashboard/produk/hapus/'.$p->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus ternak ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($produk)): ?><tr><td colspan="8" class="text-center text-muted py-4">Belum ada ternak yang diunggah.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
