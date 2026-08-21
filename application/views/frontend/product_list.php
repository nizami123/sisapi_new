<div class="container py-4">

  <!-- SEARCH BAR ATAS -->
  <form action="<?= base_url('cari') ?>" method="get" class="sisapi-search-box mb-3">
    <i class="fa-solid fa-magnifying-glass text-muted ms-2"></i>
    <input type="text" name="q" value="<?= htmlspecialchars($filters['keyword'] ?: '') ?>" placeholder="Cari ternak atau produk...">
    <button type="submit" class="btn btn-sisapi-green px-4">Cari</button>
    <button type="button" onclick="sisapiUseMyLocation()" class="btn btn-outline-sisapi px-3"><i class="fa-solid fa-location-crosshairs me-1"></i> Lokasi Saya</button>
  </form>

  <!-- FILTER BAR -->
  <div class="row g-2 mb-4">
    <div class="col-6 col-md-3">
      <select class="form-select form-select-sm" onchange="sisapiFilterChange('category_id', this.value)">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= $c['id'] ?>" <?= $filters['category_id']==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <select class="form-select form-select-sm" onchange="sisapiFilterChange('sort', this.value)">
        <option value="terbaru" <?= $filters['sort']=='terbaru'?'selected':'' ?>>Terbaru</option>
        <option value="terdekat" <?= $filters['sort']=='terdekat'?'selected':'' ?>>Terdekat</option>
        <option value="harga_asc" <?= $filters['sort']=='harga_asc'?'selected':'' ?>>Harga Terendah</option>
        <option value="harga_desc" <?= $filters['sort']=='harga_desc'?'selected':'' ?>>Harga Tertinggi</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <input type="number" class="form-control form-control-sm" placeholder="Harga min" id="min_price_input" value="<?= htmlspecialchars($filters['min_price'] ?: '') ?>">
    </div>
    <div class="col-6 col-md-2">
      <input type="number" class="form-control form-control-sm" placeholder="Harga max" id="max_price_input" value="<?= htmlspecialchars($filters['max_price'] ?: '') ?>">
    </div>
    <div class="col-md-1">
      <button class="btn btn-sisapi-green btn-sm w-100" onclick="sisapiFilterChange('min_price', document.getElementById('min_price_input').value, 'max_price', document.getElementById('max_price_input').value)">Filter</button>
    </div>
  </div>

  <div class="row g-4">
    <!-- SIDEBAR KATEGORI -->
    <div class="col-lg-3 d-none d-lg-block">
      <div class="sisapi-filter-card mb-3">
        <h6>Kategori</h6>
        <div class="sisapi-cat-list d-flex flex-column">
          <a href="<?= base_url('cari') ?>" class="<?= !$filters['category_id'] ? 'active':'' ?>"><i class="fa-solid fa-grip"></i> Semua Kategori</a>
          <?php foreach ($categories as $c): ?>
            <a href="<?= base_url('kategori/'.$c['slug']) ?>" class="<?= $filters['category_id']==$c['id']?'active':'' ?>"><i class="fa-solid <?= $c['icon'] ?>"></i> <?= htmlspecialchars($c['name']) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- GRID PRODUK -->
    <div class="col-lg-9">
      <p class="text-muted small mb-3">Menampilkan <?= count($products) ?> dari <?= $total_products ?> produk</p>

      <div class="row g-3 row-cols-2 row-cols-md-3">
        <?php foreach ($products as $p): ?>
        <div class="col"><?php $this->load->view('frontend/partials/product_card', array('p' => $p)); ?></div>
        <?php endforeach; ?>
      </div>

      <?php if (empty($products)): ?>
        <div class="text-center py-5">
          <i class="fa-solid fa-magnifying-glass fa-2x text-muted mb-3"></i>
          <p class="text-muted">Tidak ada produk yang cocok dengan pencarian Anda.</p>
        </div>
      <?php endif; ?>

      <?php if ($total_pages > 1): ?>
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i == $current_page ? 'active':'' ?>">
              <a class="page-link" href="?<?= http_build_query(array_merge($_GET, array('page' => $i))) ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function sisapiFilterChange() {
  const url = new URL(window.location.href);
  const args = arguments;
  for (let i = 0; i < args.length; i += 2) {
    if (args[i+1]) { url.searchParams.set(args[i], args[i+1]); } else { url.searchParams.delete(args[i]); }
  }
  url.searchParams.delete('page');
  window.location.href = url.toString();
}
</script>
