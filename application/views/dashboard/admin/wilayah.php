<div class="row g-4">
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Tambah Data Wilayah</h6>
      <?= form_open('admin/wilayah') ?>
        <div class="mb-2"><label class="form-label small">Tingkat</label>
          <select name="tingkat" id="tingkatWilayah" class="form-select" required>
            <option value="provinsi">Provinsi</option>
            <option value="kabupaten">Kabupaten/Kota</option>
            <option value="kecamatan">Kecamatan</option>
            <option value="desa">Desa/Kelurahan</option>
          </select>
        </div>
        <div class="mb-2" id="wrapParentWilayah" style="display:none;">
          <label class="form-label small">Wilayah Induk</label>
          <select name="parent_id" id="parentWilayah" class="form-select">
            <option value="">-- Pilih --</option>
            <?php foreach ($provinsi as $p): ?><option value="<?= $p->id ?>"><?= esc($p->nama) ?> (Provinsi)</option><?php endforeach; ?>
          </select>
          <small class="text-muted">Untuk kabupaten pilih provinsi. Kecamatan/desa: gunakan halaman ini berulang sesuai kebutuhan atau import massal via SQL (lihat README).</small>
        </div>
        <div class="mb-2"><label class="form-label small">Kode Wilayah (opsional)</label><input type="text" name="kode" class="form-control"></div>
        <div class="mb-3"><label class="form-label small">Nama Wilayah</label><input type="text" name="nama" class="form-control" required></div>
        <button type="submit" class="btn btn-sisapi w-100"><i class="bi bi-plus-circle"></i> Tambah</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Daftar Provinsi</h6>
      <ul class="list-group">
        <?php foreach ($provinsi as $p): ?>
          <li class="list-group-item d-flex justify-content-between"><?= esc($p->nama) ?> <span class="badge bg-light text-dark border">provinsi</span></li>
        <?php endforeach; ?>
        <?php if (empty($provinsi)): ?><li class="list-group-item text-muted">Belum ada data. Import data wilayah Indonesia via database/sisapi.sql atau tambahkan manual di sini.</li><?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<script>
document.getElementById('tingkatWilayah').addEventListener('change', function () {
  document.getElementById('wrapParentWilayah').style.display = this.value === 'provinsi' ? 'none' : 'block';
});
</script>
