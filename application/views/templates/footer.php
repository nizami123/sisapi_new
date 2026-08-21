  <footer class="sisapi-footer mt-5 pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="brand-logo"><i class="fa-solid fa-cow"></i></div>
            <strong class="text-white fs-5">SISAPI</strong>
          </div>
          <p class="small mb-0">Sistem Informasi & Marketplace Peternakan — mempertemukan peternak dan pembeli ternak/produk peternakan secara langsung dan terpercaya.</p>
        </div>
        <div class="col-md-2">
          <h6 class="text-white mb-3">Jelajahi</h6>
          <ul class="list-unstyled small">
            <li class="mb-2"><a href="<?= base_url('cari') ?>">Cari Ternak</a></li>
            <li class="mb-2"><a href="<?= base_url('peternak') ?>">Peternak</a></li>
            <li class="mb-2"><a href="<?= base_url('ternak-terdekat') ?>">Ternak Terdekat</a></li>
          </ul>
        </div>
        <div class="col-md-2">
          <h6 class="text-white mb-3">Akun</h6>
          <ul class="list-unstyled small">
            <li class="mb-2"><a href="<?= base_url('login') ?>">Login</a></li>
            <li class="mb-2"><a href="<?= base_url('daftar-peternak') ?>">Daftar Peternak</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6 class="text-white mb-3">Tentang</h6>
          <p class="small mb-0">SISAPI bukan sistem pembayaran online — transaksi dan komunikasi dilakukan langsung antara pembeli dan peternak melalui WhatsApp.</p>
        </div>
      </div>
      <hr class="border-secondary my-4">
      <p class="small text-center mb-0">&copy; <?= date('Y') ?> SISAPI. Seluruh hak cipta dilindungi.</p>
    </div>
  </footer>

<!-- Bootstrap Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<!-- jQuery (untuk DataTables) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>const SISAPI_BASE_URL = "<?= base_url() ?>";</script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
