<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Laporan Produk Disetujui</h6>
    <div class="btn-group btn-group-sm">
      <button class="btn btn-outline-danger" disabled title="Butuh library Dompdf - lihat README"><i class="bi bi-file-earmark-pdf"></i> Ekspor PDF</button>
      <button class="btn btn-outline-success" disabled title="Butuh library PhpSpreadsheet - lihat README"><i class="bi bi-file-earmark-excel"></i> Ekspor Excel</button>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead class="table-light"><tr><th>Nama Ternak</th><th>Kategori</th><th>Peternak</th><th>Harga</th><th>Dilihat</th><th>Klik WA</th><th>Tgl Approve</th></tr></thead>
      <tbody>
      <?php foreach ($produk as $p): ?>
        <tr>
          <td><?= esc($p->nama_ternak) ?></td>
          <td><?= esc($p->nama_kategori) ?></td>
          <td><?= esc($p->nama_peternak) ?></td>
          <td><?= format_rupiah($p->harga) ?></td>
          <td><?= number_format($p->jumlah_dilihat) ?></td>
          <td><?= number_format($p->jumlah_klik_wa) ?></td>
          <td><?= $p->tanggal_approve ? date('d M Y', strtotime($p->tanggal_approve)) : '-' ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
