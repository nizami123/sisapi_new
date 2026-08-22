<div class="row g-4">
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Tulis Artikel Baru</h6>
      <?= form_open('admin/artikel') ?>
        <div class="mb-2"><label class="form-label small">Judul</label><input type="text" name="judul" class="form-control" required></div>
        <div class="mb-2"><label class="form-label small">Kategori</label>
          <select name="kategori_artikel" class="form-select" required>
            <option>Peternakan</option><option>Kesehatan Hewan</option><option>Budidaya</option><option>Harga Pasar</option><option>Berita</option>
          </select>
        </div>
        <div class="mb-2"><label class="form-label small">Ringkasan</label><textarea name="ringkasan" class="form-control" rows="2"></textarea></div>
        <div class="mb-2"><label class="form-label small">Konten Lengkap</label><textarea name="konten" class="form-control" rows="6" required></textarea></div>
        <div class="mb-3"><label class="form-label small">Status</label>
          <select name="status" class="form-select"><option value="draft">Draft</option><option value="terbit">Terbitkan</option></select>
        </div>
        <button type="submit" class="btn btn-sisapi w-100"><i class="bi bi-send"></i> Simpan Artikel</button>
      <?= form_close() ?>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="fw-bold mb-3">Daftar Artikel</h6>
      <table class="table table-hover align-middle">
        <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Dilihat</th></tr></thead>
        <tbody>
        <?php foreach ($artikel as $a): ?>
          <tr>
            <td><?= esc($a->judul) ?></td>
            <td><?= esc($a->kategori_artikel) ?></td>
            <td><?= $a->status === 'terbit' ? '<span class="badge bg-success">Terbit</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
            <td><?= number_format($a->jumlah_dilihat) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($artikel)): ?><tr><td colspan="4" class="text-center text-muted py-4">Belum ada artikel.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
