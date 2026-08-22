<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold text-center mb-1">Masuk ke SISAPI</h4>
        <p class="text-center text-muted small mb-4">Untuk Peternak &amp; Admin Dinas</p>
        <?= form_open('login') ?>
          <div class="mb-3">
            <label class="form-label">Username atau Email</label>
            <input type="text" name="identity" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="d-flex justify-content-between small mb-3">
            <a href="<?= base_url('lupa-password') ?>">Lupa password?</a>
          </div>
          <!-- Google reCAPTCHA v2 -->
          <!-- <div class="g-recaptcha mb-3" data-sitekey="GANTI_DENGAN_SITE_KEY_ANDA"></div> -->
          <button type="submit" class="btn btn-sisapi w-100">Masuk</button>
        <?= form_close() ?>
        <p class="text-center small mt-3 mb-0">Belum punya akun peternak? <a href="<?= base_url('daftar-peternak') ?>">Daftar di sini</a></p>
      </div>
    </div>
  </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
