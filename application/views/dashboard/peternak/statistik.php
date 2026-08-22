<div class="row g-3 mb-4">
  <div class="col-md-6"><div class="stat-box"><div class="angka"><?= number_format($total_dilihat) ?></div><p class="mb-0">Total Dilihat Semua Ternak</p></div></div>
  <div class="col-md-6"><div class="stat-box"><div class="angka"><?= number_format($total_klik_wa) ?></div><p class="mb-0">Total Klik WhatsApp</p></div></div>
</div>

<div class="card border-0 shadow-sm p-3">
  <h6 class="fw-bold mb-3">Detail per Ternak</h6>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-light"><tr><th>Nama Ternak</th><th>Dilihat</th><th>Klik WA</th></tr></thead>
      <tbody>
      <?php foreach ($produk as $p): ?>
        <tr><td><?= esc($p->nama_ternak) ?></td><td><?= number_format($p->jumlah_dilihat) ?></td><td><?= number_format($p->jumlah_klik_wa) ?></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
