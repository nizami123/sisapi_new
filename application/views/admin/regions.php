<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Kelola Wilayah</h3>
      <p class="text-muted small">Data wilayah (Provinsi, Kabupaten, Kecamatan, Desa) diimpor melalui <code>database/sisapi.sql</code> atau seeder terpisah. Gunakan data resmi Kemendagri/BPS untuk kelengkapan wilayah Indonesia.</p>
      <table class="table table-striped">
        <thead><tr><th>#</th><th>Provinsi</th></tr></thead>
        <tbody>
        <?php foreach ($provinces as $i => $p): ?>
          <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($p['name']) ?></td></tr>
        <?php endforeach; ?>
        <?php if (empty($provinces)): ?><tr><td colspan="2" class="text-center text-muted py-4">Belum ada data provinsi. Silakan import data wilayah.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
