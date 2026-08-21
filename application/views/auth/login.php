<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="text-center mb-4">
        <div class="brand-logo mx-auto mb-2" style="width:56px;height:56px;font-size:1.6rem;"><i class="fa-solid fa-cow"></i></div>
        <h3 class="fw-bold">Masuk ke SISAPI</h3>
        <p class="text-muted small">Pasar Ternak & Produk Peternakan Digital</p>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger small"><?= $error ?></div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('login') ?>">
        <div class="mb-3">
          <label class="form-label small fw-semibold">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label small fw-semibold">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-sisapi-green w-100 mb-3">Masuk</button>
      </form>

      <p class="text-center small mb-1">Belum punya akun? <a href="<?= base_url('daftar') ?>">Daftar sebagai Pembeli</a></p>
      <p class="text-center small">Ingin jual ternak? <a href="<?= base_url('daftar-peternak') ?>">Daftar sebagai Peternak</a></p>
    </div>
  </div>
</div>
