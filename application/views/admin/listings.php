<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Kelola Listing</h3>
      <table class="table table-striped" id="listingsTable">
        <thead><tr><th>Produk</th><th>Kategori</th><th>Penjual</th><th>Harga</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($listings as $p): ?>
          <tr>
            <td><a href="<?= base_url('ternak/'.$p['slug']) ?>" target="_blank"><?= htmlspecialchars($p['name']) ?></a></td>
            <td><?= htmlspecialchars($p['category_name']) ?></td>
            <td><?= htmlspecialchars($p['seller_name']) ?></td>
            <td><?= format_rupiah($p['price']) ?></td>
            <td><span class="badge bg-<?= $p['status']=='active'?'success':($p['status']=='pending'?'warning text-dark':($p['status']=='sold'?'danger':'secondary')) ?>"><?= ucfirst($p['status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>$(document).ready(function(){ $('#listingsTable').DataTable(); });</script>
