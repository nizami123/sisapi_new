<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('seller/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Tambah Ternak / Produk</h3>

      <?php if (isset($error)): ?><div class="alert alert-danger small"><?= $error ?></div><?php endif; ?>

      <form method="post" action="<?= base_url('dashboard/tambah-ternak') ?>" enctype="multipart/form-data">
        <div class="sisapi-filter-card mb-3">
          <h6 class="mb-3">Informasi Dasar</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Kategori</label>
              <select name="category_id" id="category_select" class="form-select" required>
                <option value="">Pilih Kategori...</option>
                <?php foreach ($categories as $c): ?>
                  <option value="<?= $c['id'] ?>" data-type="<?= $c['type'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Harga (Rp)</label>
              <input type="number" name="price" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Nama Produk</label>
              <input type="text" name="name" class="form-control" placeholder="Contoh: Sapi Limousin Jantan 2 Tahun" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Deskripsi</label>
              <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
          </div>
        </div>

        <!-- FIELD DINAMIS UNTUK TERNAK -->
        <div class="sisapi-filter-card mb-3" id="livestock_fields" style="display:none;">
          <h6 class="mb-3">Informasi Ternak</h6>
          <div class="row g-3">
            <div class="col-md-4"><label class="form-label small fw-semibold">Jenis</label><input type="text" name="jenis" class="form-control"></div>
            <div class="col-md-4"><label class="form-label small fw-semibold">Ras</label><input type="text" name="ras" class="form-control"></div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select"><option value="">Pilih...</option><option value="Jantan">Jantan</option><option value="Betina">Betina</option></select>
            </div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Umur</label><input type="text" name="umur" class="form-control" placeholder="cth: 2 Tahun"></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Berat</label><input type="text" name="berat" class="form-control" placeholder="cth: ±450 Kg"></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Warna</label><input type="text" name="warna" class="form-control"></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Kondisi Kesehatan</label><input type="text" name="kondisi_kesehatan" class="form-control" placeholder="Sehat"></div>
            <div class="col-md-6"><label class="form-label small fw-semibold">Status Vaksinasi</label><input type="text" name="status_vaksinasi" class="form-control" placeholder="Lengkap / Belum"></div>
          </div>
        </div>

        <div class="sisapi-filter-card mb-3">
          <h6 class="mb-3">Foto Produk</h6>
          <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
          <small class="text-muted">Foto pertama akan menjadi foto utama. Bisa unggah lebih dari satu foto.</small>
        </div>

        <div class="sisapi-filter-card mb-3">
          <h6 class="mb-3">Lokasi</h6>
          <div class="row g-3 mb-3">
            <div class="col-12"><label class="form-label small fw-semibold">Alamat</label><input type="text" name="address" class="form-control" required></div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold">Provinsi</label>
              <select id="loc_province" name="province_id" class="form-select">
                <option value="">Pilih...</option>
                <?php foreach ($provinces as $p): ?><option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option><?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Kabupaten</label><select id="loc_regency" name="regency_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Kecamatan</label><select id="loc_district" name="district_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Desa</label><select id="loc_village" name="village_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
          </div>
          <p class="text-muted small">Klik pada peta untuk menentukan titik lokasi ternak.</p>
          <div id="prod_map" class="mb-2"></div>
          <input type="hidden" id="prod_latitude" name="latitude">
          <input type="hidden" id="prod_longitude" name="longitude">
        </div>

        <button type="submit" class="btn btn-sisapi-green px-4">Simpan & Kirim untuk Moderasi</button>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  sisapiInitRegionDropdowns('loc');
  sisapiInitMapPicker('prod_map', 'prod_latitude', 'prod_longitude');

  const catSelect = document.getElementById('category_select');
  const livestockFields = document.getElementById('livestock_fields');
  catSelect.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    livestockFields.style.display = (opt.dataset.type === 'livestock') ? 'block' : 'none';
  });
});
</script>
