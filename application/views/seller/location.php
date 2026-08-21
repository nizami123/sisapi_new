<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('seller/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Lokasi Peternakan</h3>
      <form method="post" action="<?= base_url('dashboard/lokasi') ?>">
        <div class="sisapi-filter-card mb-3">
          <div class="row g-3 mb-3">
            <div class="col-12"><label class="form-label small fw-semibold">Alamat</label><input type="text" name="address" class="form-control" value="<?= htmlspecialchars($seller['address']) ?>" required></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Provinsi</label><select id="loc_province" name="province_id" class="form-select"><option value="">Pilih...</option><?php foreach ($provinces as $p): ?><option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Kabupaten</label><select id="loc_regency" name="regency_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Kecamatan</label><select id="loc_district" name="district_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Desa</label><select id="loc_village" name="village_id" class="form-select" disabled><option value="">Pilih...</option></select></div>
          </div>
          <p class="text-muted small">Geser penanda atau klik peta untuk memperbarui titik lokasi.</p>
          <div id="edit_map" class="mb-2"></div>
          <input type="hidden" id="edit_latitude" name="latitude" value="<?= $seller['latitude'] ?>">
          <input type="hidden" id="edit_longitude" name="longitude" value="<?= $seller['longitude'] ?>">
        </div>
        <button type="submit" class="btn btn-sisapi-green px-4">Simpan Lokasi</button>
      </form>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  sisapiInitRegionDropdowns('loc');
  sisapiInitMapPicker('edit_map', 'edit_latitude', 'edit_longitude', <?= $seller['latitude'] ?: 'null' ?>, <?= $seller['longitude'] ?: 'null' ?>);
});
</script>
