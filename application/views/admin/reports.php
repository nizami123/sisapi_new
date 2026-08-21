<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Laporan Listing</h3>
      <table class="table table-striped">
        <thead><tr><th>Produk</th><th>Pelapor</th><th>Alasan</th><th>Status</th><th>Tanggal</th></tr></thead>
        <tbody>
        <?php foreach ($reports as $r): ?>
          <tr>
            <td><a href="<?= base_url('ternak/'.$r['slug']) ?>" target="_blank"><?= htmlspecialchars($r['product_name']) ?></a></td>
            <td><?= htmlspecialchars($r['reporter_name'] ?: 'Anonim') ?></td>
            <td><?= htmlspecialchars($r['reason']) ?></td>
            <td><span class="badge bg-secondary"><?= ucfirst($r['status']) ?></span></td>
            <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($reports)): ?><tr><td colspan="5" class="text-center text-muted py-4">Belum ada laporan.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
