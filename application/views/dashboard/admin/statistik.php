<div class="row g-3 mb-4">
  <div class="col-md-4"><div class="stat-box"><div class="angka"><?= $statistik['total_peternak'] ?></div><p class="mb-0">Peternak</p></div></div>
  <div class="col-md-4"><div class="stat-box"><div class="angka"><?= $statistik['total_produk'] ?></div><p class="mb-0">Produk</p></div></div>
  <div class="col-md-4"><div class="stat-box"><div class="angka"><?= $statistik['total_kontak'] ?></div><p class="mb-0">Kontak WhatsApp</p></div></div>
</div>

<div class="card border-0 shadow-sm p-3 mb-3">
  <h6 class="fw-bold mb-3">Upload Ternak (12 Bulan Terakhir)</h6>
  <canvas id="chartUpload12" height="80"></canvas>
</div>
<div class="card border-0 shadow-sm p-3">
  <h6 class="fw-bold mb-3">Pengunjung (30 Hari Terakhir)</h6>
  <canvas id="chartPengunjung30" height="80"></canvas>
</div>

<script>
new Chart(document.getElementById('chartUpload12'), {
  type: 'line',
  data: { labels: <?= json_encode(array_column($upload_per_bulan, 'bulan')) ?>,
    datasets: [{ label: 'Upload', data: <?= json_encode(array_column($upload_per_bulan, 'total')) ?>, borderColor: '#198754', backgroundColor:'rgba(25,135,84,.15)', fill:true, tension:.3 }] }
});
new Chart(document.getElementById('chartPengunjung30'), {
  type: 'bar',
  data: { labels: <?= json_encode(array_column($pengunjung_harian, 'tanggal')) ?>,
    datasets: [{ label: 'Pengunjung', data: <?= json_encode(array_column($pengunjung_harian, 'total_pengunjung')) ?>, backgroundColor:'#75d891' }] }
});
</script>
