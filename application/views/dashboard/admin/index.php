<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="stat-box"><div class="angka"><?= $statistik['total_peternak'] ?></div><p class="mb-0">Peternak Terverifikasi</p></div></div>
  <div class="col-md-3"><div class="stat-box"><div class="angka"><?= $statistik['total_produk'] ?></div><p class="mb-0">Produk Aktif</p></div></div>
  <div class="col-md-3">
    <div class="stat-box" style="background:#fff3cd;">
      <div class="angka" style="color:#997404;"><?= $statistik['peternak_pending'] ?></div>
      <p class="mb-0">Peternak Menunggu Approval</p>
      <a href="<?= base_url('admin/peternak?status=menunggu') ?>" class="small">Proses sekarang →</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-box" style="background:#fff3cd;">
      <div class="angka" style="color:#997404;"><?= $statistik['produk_pending'] ?></div>
      <p class="mb-0">Produk Menunggu Approval</p>
      <a href="<?= base_url('admin/produk?status=menunggu') ?>" class="small">Proses sekarang →</a>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-6">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Kategori Terlaris</h6>
      <canvas id="chartKategori" height="200"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Lokasi Terbanyak</h6>
      <canvas id="chartLokasi" height="200"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Upload Ternak per Bulan</h6>
      <canvas id="chartUpload" height="200"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Grafik Pengunjung Harian</h6>
      <canvas id="chartPengunjung" height="200"></canvas>
    </div>
  </div>
</div>

<script>
const green = '#198754';

new Chart(document.getElementById('chartKategori'), {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_column($kategori_terlaris, 'nama_kategori')) ?>,
    datasets: [{ data: <?= json_encode(array_column($kategori_terlaris, 'total')) ?>, backgroundColor: ['#198754','#28a745','#40c463','#75d891','#a8e6bc','#d1f2da'] }]
  }
});

new Chart(document.getElementById('chartLokasi'), {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_column($lokasi_terbanyak, 'nama')) ?>,
    datasets: [{ label: 'Jumlah Produk', data: <?= json_encode(array_column($lokasi_terbanyak, 'total')) ?>, backgroundColor: green }]
  },
  options: { plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('chartUpload'), {
  type: 'line',
  data: {
    labels: <?= json_encode(array_column($upload_per_bulan, 'bulan')) ?>,
    datasets: [{ label: 'Upload Ternak', data: <?= json_encode(array_column($upload_per_bulan, 'total')) ?>, borderColor: green, backgroundColor: 'rgba(25,135,84,.15)', fill: true, tension: .3 }]
  }
});

new Chart(document.getElementById('chartPengunjung'), {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_column($pengunjung_harian, 'tanggal')) ?>,
    datasets: [{ label: 'Pengunjung', data: <?= json_encode(array_column($pengunjung_harian, 'total_pengunjung')) ?>, backgroundColor: '#75d891' }]
  }
});
</script>
