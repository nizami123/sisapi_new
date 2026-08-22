<footer class="sisapi-footer pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5 class="text-white"><i class="bi bi-flower2"></i> SISAPI</h5>
        <p class="small">Sistem Informasi dan Marketplace Peternakan Indonesia. Menghubungkan peternak terverifikasi dengan calon pembeli di seluruh Indonesia secara aman dan transparan.</p>
        <div class="d-flex gap-3 fs-5">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-md-2">
        <h6 class="text-white">Menu</h6>
        <ul class="list-unstyled small">
          <li><a href="<?= base_url() ?>">Beranda</a></li>
          <li><a href="<?= base_url('produk') ?>">Katalog Ternak</a></li>
          <li><a href="<?= base_url('peternak-terpercaya') ?>">Peternak Terpercaya</a></li>
          <li><a href="<?= base_url('artikel') ?>">Artikel</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h6 class="text-white">Kategori</h6>
        <ul class="list-unstyled small">
          <li><a href="<?= base_url('kategori/sapi') ?>">Sapi</a></li>
          <li><a href="<?= base_url('kategori/kambing') ?>">Kambing</a></li>
          <li><a href="<?= base_url('kategori/domba') ?>">Domba</a></li>
          <li><a href="<?= base_url('kategori/unggas') ?>">Unggas</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6 class="text-white">Kontak</h6>
        <ul class="list-unstyled small">
          <li><i class="bi bi-geo-alt"></i> Dinas Peternakan Provinsi</li>
          <li><i class="bi bi-envelope"></i> admin@sisapi.go.id</li>
          <li><i class="bi bi-whatsapp"></i> +62 812-3456-7890</li>
        </ul>
      </div>
    </div>
    <hr class="border-secondary">
    <p class="small text-center mb-0">&copy; <?= date('Y') ?> SISAPI - Dinas Peternakan. Seluruh data ternak telah melalui proses verifikasi.</p>
  </div>
</footer>

<a href="https://wa.me/6281234567890" target="_blank" class="wa-float-btn"><i class="bi bi-whatsapp"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>const BASE_URL = "<?= base_url() ?>";</script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
