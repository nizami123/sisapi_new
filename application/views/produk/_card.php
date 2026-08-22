<div class="produk-card card">
  <div class="position-relative">
    <img src="<?= $p->foto_utama ? base_url('uploads/produk/'.$p->foto_utama) : 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=400' ?>" alt="<?= esc($p->nama_ternak) ?>">
    <span class="badge badge-verified position-absolute top-0 start-0 m-2"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
  </div>
  <div class="card-body">
    <span class="badge bg-light text-success border border-success mb-1"><?= esc($p->nama_kategori) ?></span>
    <h6 class="mb-1 text-truncate"><a href="<?= base_url('produk/'.$p->slug) ?>" class="text-dark"><?= esc($p->nama_ternak) ?></a></h6>
    <p class="harga mb-1"><?= format_rupiah($p->harga) ?></p>
    <p class="meta mb-1"><i class="bi bi-geo-alt"></i> <?= esc($p->alamat_lengkap ?: 'Indonesia') ?></p>
    <p class="meta mb-2"><i class="bi bi-eye"></i> <?= number_format($p->jumlah_dilihat) ?> dilihat</p>
    <a href="<?= base_url('produk/'.$p->slug) ?>" class="btn btn-sisapi btn-sm w-100">Lihat Detail</a>
  </div>
</div>
