<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Tambah Ternak Baru</h6>
  <?= form_open_multipart('dashboard/produk/tambah') ?>
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-select" required>
          <option value="">-- Pilih --</option>
          <?php foreach ($kategori as $k): ?><option value="<?= $k->id ?>"><?= esc($k->nama_kategori) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Nama Ternak</label><input type="text" name="nama_ternak" class="form-control" required></div>

      <div class="col-md-4"><label class="form-label">Harga (Rp)</label><input type="number" name="harga" class="form-control" required></div>
      <div class="col-md-4"><label class="form-label">Ras</label><input type="text" name="ras" class="form-control"></div>
      <div class="col-md-4"><label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select"><option>Jantan</option><option>Betina</option><option>Tidak Diketahui</option></select>
      </div>

      <div class="col-md-3"><label class="form-label">Umur (tahun)</label><input type="number" name="umur_tahun" class="form-control" value="0"></div>
      <div class="col-md-3"><label class="form-label">Umur (bulan)</label><input type="number" name="umur_bulan" class="form-control" value="0"></div>
      <div class="col-md-3"><label class="form-label">Bobot (kg)</label><input type="number" step="0.1" name="bobot_kg" class="form-control"></div>
      <div class="col-md-3"><label class="form-label">Warna</label><input type="text" name="warna" class="form-control"></div>

      <div class="col-md-6"><label class="form-label">Status Kesehatan</label><input type="text" name="status_kesehatan" class="form-control" value="Sehat"></div>
      <div class="col-md-6"><label class="form-label">Status Vaksin</label>
        <select name="status_vaksin" class="form-select"><option>Sudah</option><option>Belum</option><option>Tidak Diketahui</option></select>
      </div>

      <div class="col-12"><label class="form-label">Deskripsi Lengkap</label><textarea name="deskripsi" class="form-control" rows="4" required></textarea></div>

      <div class="col-md-6"><label class="form-label">Kabupaten/Kota</label>
        <select name="kabupaten_id" class="form-select">
          <option value="">-- Pilih --</option>
          <?php foreach ($kabupaten as $kab): ?><option value="<?= $kab->id ?>"><?= esc($kab->nama) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Alamat Lengkap Lokasi Ternak</label><input type="text" name="alamat_lengkap" class="form-control"></div>

      <div class="col-md-6"><label class="form-label">Koordinat</label>
        <div class="input-group">
          <input type="text" name="latitude" class="form-control" placeholder="Latitude">
          <input type="text" name="longitude" class="form-control" placeholder="Longitude">
        </div>
      </div>
      <div class="col-md-6"><label class="form-label">Nomor WhatsApp Penjual</label><input type="text" name="nomor_wa" class="form-control" placeholder="08xxxxxxxxxx" required></div>

      <div class="col-md-6"><label class="form-label">Foto Utama</label><input type="file" name="foto_utama" class="form-control" accept="image/*" required></div>
      <div class="col-md-6"><label class="form-label">Galeri Foto (bisa lebih dari 1)</label><input type="file" name="galeri[]" class="form-control" accept="image/*" multiple></div>
      <div class="col-12"><label class="form-label">Video (opsional, tautan YouTube embed)</label><input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/embed/xxxx"></div>
    </div>

    <button type="submit" class="btn btn-sisapi mt-4"><i class="bi bi-cloud-upload"></i> Unggah Ternak</button>
    <p class="small text-muted mt-2">Ternak akan tampil di website publik setelah disetujui Admin Dinas.</p>
  <?= form_close() ?>
</div>
