<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="text-center mb-4">
        <h3 class="fw-bold">Daftar Sebagai Peternak</h3>
        <p class="text-muted small">Gratis — tayangkan ternak dan produk peternakan Anda ke ribuan calon pembeli</p>
      </div>

      <?php if (isset($error)): ?><div class="alert alert-danger small"><?= $error ?></div><?php endif; ?>

      <form method="post" action="<?= base_url('daftar-peternak') ?>" enctype="multipart/form-data">
        <h6 class="fw-bold mb-3 mt-2">Akun</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6"><label class="form-label small fw-semibold">Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
          <div class="col-md-6"><label class="form-label small fw-semibold">Nomor WhatsApp</label><input type="text" name="phone_whatsapp" class="form-control" placeholder="08xxxxxxxxxx" required></div>
          <div class="col-md-6"><label class="form-label small fw-semibold">Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="col-md-6"><label class="form-label small fw-semibold">Password</label><input type="password" name="password" class="form-control" minlength="6" required></div>
          <div class="col-md-6"><label class="form-label small fw-semibold">Foto Profil</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
        </div>

        <h6 class="fw-bold mb-3 mt-4">Profil Peternakan</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6"><label class="form-label small fw-semibold">Nama Peternakan</label><input type="text" name="farm_name" class="form-control" required></div>
          <div class="col-md-6"><label class="form-label small fw-semibold">Alamat</label><input type="text" name="address" class="form-control" required></div>
          <div class="col-12"><label class="form-label small fw-semibold">Deskripsi Peternakan</label><textarea name="description" class="form-control" rows="3"></textarea></div>
        </div>

        <h6 class="fw-bold mb-3 mt-4">Wilayah</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label small fw-semibold">Provinsi</label>
            <select id="loc_province" name="province_id" class="form-select">
              <option value="">Pilih Provinsi...</option>
              <?php foreach ($provinces as $p): ?><option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3"><label class="form-label small fw-semibold">Kabupaten</label><select id="loc_regency" name="regency_id" class="form-select" disabled><option value="">Pilih Kabupaten...</option></select></div>
          <div class="col-md-3"><label class="form-label small fw-semibold">Kecamatan</label><select id="loc_district" name="district_id" class="form-select" disabled><option value="">Pilih Kecamatan...</option></select></div>
          <div class="col-md-3"><label class="form-label small fw-semibold">Desa</label><select id="loc_village" name="village_id" class="form-select" disabled><option value="">Pilih Desa...</option></select></div>
        </div>

        <h6 class="fw-bold mb-2 mt-4">Titik Lokasi Peternakan</h6>
        <p class="text-muted small">Klik pada peta atau geser penanda untuk menentukan titik lokasi peternakan Anda.</p>
        <div id="reg_map" class="mb-3"></div>
        <input type="hidden" id="reg_latitude" name="latitude">
        <input type="hidden" id="reg_longitude" name="longitude">

        <button type="submit" class="btn btn-sisapi-green w-100 mt-3 mb-3">Daftar Sebagai Peternak</button>
      </form>
      <p class="text-center small">Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk</a></p>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  sisapiInitRegionDropdowns('loc');
  sisapiInitMapPicker('reg_map', 'reg_latitude', 'reg_longitude');
});
</script>
