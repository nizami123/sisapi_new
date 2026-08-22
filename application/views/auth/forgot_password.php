<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold text-center mb-3">Lupa Password</h4>
        <p class="text-muted small text-center mb-4">Masukkan email terdaftar, kami akan mengirimkan tautan reset password.</p>
        <?= form_open('lupa-password') ?>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
          <button type="submit" class="btn btn-sisapi w-100">Kirim Tautan Reset</button>
        <?= form_close() ?>
        <p class="text-center small mt-3 mb-0"><a href="<?= base_url('login') ?>">Kembali ke Login</a></p>
      </div>
    </div>
  </div>
</div>
