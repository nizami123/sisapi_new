<div class="container py-4">
  <h3 class="fw-bold mb-1">Ternak di Sekitar Saya</h3>
  <p class="text-muted mb-4">Izinkan akses lokasi untuk melihat ternak & produk terdekat dari posisi Anda saat ini.</p>
  <div id="nearby-loading" class="text-center py-5">
    <button class="btn btn-sisapi-green px-4" onclick="sisapiLoadNearby()"><i class="fa-solid fa-location-crosshairs me-1"></i> Gunakan Lokasi Saya</button>
  </div>
  <div id="nearby-results" class="row g-3 row-cols-2 row-cols-md-4"></div>
</div>
<script>
function sisapiLoadNearby() {
  if (!navigator.geolocation) { Swal.fire('Tidak didukung', 'Browser tidak mendukung lokasi.', 'warning'); return; }
  document.getElementById('nearby-loading').innerHTML = '<div class="spinner-border text-success"></div>';
  navigator.geolocation.getCurrentPosition(function (pos) {
    window.location.href = SISAPI_BASE_URL + 'cari?lat=' + pos.coords.latitude + '&lng=' + pos.coords.longitude + '&sort=terdekat';
  }, function () {
    Swal.fire('Lokasi ditolak', 'Aktifkan izin lokasi di browser untuk menggunakan fitur ini.', 'info');
    document.getElementById('nearby-loading').innerHTML = '<button class="btn btn-sisapi-green px-4" onclick="sisapiLoadNearby()">Coba Lagi</button>';
  });
}
</script>
