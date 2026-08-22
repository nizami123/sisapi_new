<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-1">Daftar Sebagai Peternak</h4>
        <p class="text-center text-muted small mb-4">Akun Anda akan diverifikasi Admin Dinas sebelum dapat mengunggah ternak</p>

        <!-- Step indicator -->
        <div class="d-flex justify-content-between mb-4 small fw-semibold" id="stepIndicator">
          <span class="step-label text-success">1. Data Diri</span>
          <span class="step-label text-muted">2. Alamat</span>
          <span class="step-label text-muted">3. Usaha Ternak</span>
          <span class="step-label text-muted">4. Dokumen</span>
          <span class="step-label text-muted">5. Akun</span>
        </div>

        <?= form_open_multipart('daftar-peternak', array('id' => 'formRegister')) ?>

          <!-- STEP 1: Data Diri -->
          <div class="form-step active" data-step="1">
            <div class="row g-3">
              <div class="col-md-8"><label class="form-label">Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
              <div class="col-md-4"><label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
              </div>
              <div class="col-md-6"><label class="form-label">NIK</label><input type="text" name="nik" maxlength="16" class="form-control" required></div>
              <div class="col-md-6"><label class="form-label">Nomor KK</label><input type="text" name="no_kk" maxlength="16" class="form-control" required></div>
              <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" required></div>
              <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" required></div>
            </div>
            <div class="text-end mt-3"><button type="button" class="btn btn-sisapi next-step">Lanjut <i class="bi bi-arrow-right"></i></button></div>
          </div>

          <!-- STEP 2: Alamat -->
          <div class="form-step" data-step="2">
            <div class="row g-3">
              <div class="col-12"><label class="form-label">Alamat Lengkap</label><textarea name="alamat" class="form-control" rows="2" required></textarea></div>
              <div class="col-md-6"><label class="form-label">Provinsi</label>
                <select name="provinsi_id" id="provinsi_id" class="form-select" required>
                  <option value="">-- Pilih Provinsi --</option>
                  <?php foreach ($provinsi as $p): ?><option value="<?= $p->id ?>"><?= esc($p->nama) ?></option><?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6"><label class="form-label">Kabupaten/Kota</label><select name="kabupaten_id" id="kabupaten_id" class="form-select" required><option value="">-- Pilih Provinsi dulu --</option></select></div>
              <div class="col-md-6"><label class="form-label">Kecamatan</label><select name="kecamatan_id" id="kecamatan_id" class="form-select" required><option value="">-- Pilih Kabupaten dulu --</option></select></div>
              <div class="col-md-6"><label class="form-label">Desa/Kelurahan</label><select name="desa_id" id="desa_id" class="form-select" required><option value="">-- Pilih Kecamatan dulu --</option></select></div>
              <div class="col-md-4"><label class="form-label">Kode Pos</label><input type="text" name="kode_pos" class="form-control"></div>
              <div class="col-md-8"><label class="form-label">Koordinat Lokasi (klik peta / isi manual)</label>
                <div class="input-group">
                  <input type="text" name="latitude" class="form-control" placeholder="Latitude">
                  <input type="text" name="longitude" class="form-control" placeholder="Longitude">
                  <button type="button" class="btn btn-outline-sisapi" id="btnLokasiSaya"><i class="bi bi-geo-alt"></i> Lokasi Saya</button>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
              <button type="button" class="btn btn-sisapi next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- STEP 3: Usaha Ternak -->
          <div class="form-step" data-step="3">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Nama Kelompok Ternak</label><input type="text" name="nama_kelompok_ternak" class="form-control"></div>
              <div class="col-md-6"><label class="form-label">Jenis Usaha</label><input type="text" name="jenis_usaha" class="form-control" placeholder="Pembibitan / Penggemukan / dll"></div>
              <div class="col-md-6"><label class="form-label">Jumlah Ternak Saat Ini</label><input type="number" name="jumlah_ternak" class="form-control" min="0"></div>
              <div class="col-md-6"><label class="form-label">Nomor HP (WhatsApp)</label><input type="text" name="nomor_hp" class="form-control" required></div>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
              <button type="button" class="btn btn-sisapi next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- STEP 4: Dokumen -->
          <div class="form-step" data-step="4">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Foto KTP</label><input type="file" name="foto_ktp" class="form-control" accept="image/*" required></div>
              <div class="col-md-6"><label class="form-label">Foto Selfie dengan KTP</label><input type="file" name="foto_selfie_ktp" class="form-control" accept="image/*" required></div>
              <div class="col-md-6"><label class="form-label">Foto Kandang</label><input type="file" name="foto_kandang" class="form-control" accept="image/*" required></div>
              <div class="col-md-6"><label class="form-label">Foto Profil</label><input type="file" name="foto_profil" class="form-control" accept="image/*"></div>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
              <button type="button" class="btn btn-sisapi next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- STEP 5: Akun -->
          <div class="form-step" data-step="5">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
              <div class="col-md-6"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required></div>
              <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div>
              <div class="col-md-6"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirm" class="form-control" minlength="8" required></div>
              <div class="col-12">
                <div class="g-recaptcha" data-sitekey="GANTI_DENGAN_SITE_KEY_ANDA"></div>
              </div>
              <div class="col-12 form-check mt-2">
                <input class="form-check-input" type="checkbox" name="setuju_syarat" value="1" id="setuju" required>
                <label class="form-check-label small" for="setuju">Saya menyatakan data yang diisi benar dan menyetujui syarat &amp; ketentuan SISAPI.</label>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
              <button type="submit" class="btn btn-sisapi">Daftar Sekarang <i class="bi bi-check2-circle"></i></button>
            </div>
          </div>

        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
// ---- Multi-step navigation ----
let currentStep = 1;
const totalSteps = 5;
function showStep(step) {
  document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
  document.querySelector('.form-step[data-step="'+step+'"]').classList.add('active');
  document.querySelectorAll('.step-label').forEach((el, i) => {
    el.classList.toggle('text-success', i < step);
    el.classList.toggle('text-muted', i >= step);
  });
}
document.querySelectorAll('.next-step').forEach(btn => btn.addEventListener('click', () => {
  if (currentStep < totalSteps) { currentStep++; showStep(currentStep); window.scrollTo(0,0); }
}));
document.querySelectorAll('.prev-step').forEach(btn => btn.addEventListener('click', () => {
  if (currentStep > 1) { currentStep--; showStep(currentStep); window.scrollTo(0,0); }
}));

// ---- Wilayah berjenjang (AJAX) ----
document.getElementById('provinsi_id').addEventListener('change', function () {
  fetchWilayah('kabupaten', this.value, 'kabupaten_id');
});
document.getElementById('kabupaten_id').addEventListener('change', function () {
  fetchWilayah('kecamatan', this.value, 'kecamatan_id');
});
document.getElementById('kecamatan_id').addEventListener('change', function () {
  fetchWilayah('desa', this.value, 'desa_id');
});
function fetchWilayah(tingkat, parentId, targetId) {
  // Endpoint contoh: /wilayah/ajax/{tingkat}/{parentId} -> implementasikan di Wilayah controller (lihat README)
  fetch('<?= base_url('wilayah/ajax') ?>/' + tingkat + '/' + parentId)
    .then(r => r.json())
    .then(data => {
      const sel = document.getElementById(targetId);
      sel.innerHTML = '<option value="">-- Pilih --</option>';
      data.forEach(item => sel.innerHTML += `<option value="${item.id}">${item.nama}</option>`);
    });
}

// ---- Ambil lokasi GPS ----
document.getElementById('btnLokasiSaya').addEventListener('click', function () {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (pos) {
      document.querySelector('[name="latitude"]').value = pos.coords.latitude;
      document.querySelector('[name="longitude"]').value = pos.coords.longitude;
    });
  }
});
</script>
