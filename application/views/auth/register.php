<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="text-center mb-4">
        <h3 class="fw-bold">Daftar Sebagai Pembeli</h3>
        <p class="text-muted small">Simpan favorit dan hubungi peternak lebih mudah</p>
      </div>

      <?php if (isset($error)): ?><div class="alert alert-danger small"><?= $error ?></div><?php endif; ?>

      <form method="post" action="<?= base_url('daftar') ?>">
        <div class="mb-3"><label class="form-label small fw-semibold">Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label small fw-semibold">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label small fw-semibold">Nomor WhatsApp</label><input type="text" name="phone_whatsapp" class="form-control" placeholder="08xxxxxxxxxx" required></div>
        <div class="mb-3"><label class="form-label small fw-semibold">Password</label><input type="password" name="password" class="form-control" minlength="6" required></div>
        <button type="submit" class="btn btn-sisapi-green w-100 mb-3">Daftar</button>
      </form>
      <p class="text-center small">Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk</a></p>
    </div>
  </div>
</div>
