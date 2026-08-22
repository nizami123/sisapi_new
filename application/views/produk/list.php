<div class="container py-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb small">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
      <li class="breadcrumb-item active">Katalog Ternak</li>
    </ol>
  </nav>

  <div class="row g-4">
    <!-- ===== SIDEBAR FILTER ===== -->
    <div class="col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filter</h6>
        <form method="get" action="<?= base_url('produk') ?>">
          <?php if (!empty($filters['q'])): ?><input type="hidden" name="q" value="<?= esc($filters['q']) ?>"><?php endif; ?>

          <label class="form-label small fw-semibold">Kategori</label>
          <select name="kategori_id" class="form-select form-select-sm mb-3">
            <option value="">Semua</option>
            <?php foreach ($kategori as $k): ?>
              <option value="<?= $k->id ?>" <?= (@$filters['kategori_id']==$k->id)?'selected':'' ?>><?= esc($k->nama_kategori) ?></option>
            <?php endforeach; ?>
          </select>

          <label class="form-label small fw-semibold">Kabupaten/Kota</label>
          <select name="kabupaten_id" class="form-select form-select-sm mb-3">
            <option value="">Semua</option>
            <?php foreach ($kabupaten as $kab): ?>
              <option value="<?= $kab->id ?>" <?= (@$filters['kabupaten_id']==$kab->id)?'selected':'' ?>><?= esc($kab->nama) ?></option>
            <?php endforeach; ?>
          </select>

          <label class="form-label small fw-semibold">Rentang Harga (Rp)</label>
          <div class="d-flex gap-2 mb-3">
            <input type="number" name="harga_min" class="form-control form-control-sm" placeholder="Min" value="<?= @esc($filters['harga_min']) ?>">
            <input type="number" name="harga_max" class="form-control form-control-sm" placeholder="Max" value="<?= @esc($filters['harga_max']) ?>">
          </div>

          <label class="form-label small fw-semibold">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select form-select-sm mb-3">
            <option value="">Semua</option>
            <option value="Jantan" <?= (@$filters['jenis_kelamin']=='Jantan')?'selected':'' ?>>Jantan</option>
            <option value="Betina" <?= (@$filters['jenis_kelamin']=='Betina')?'selected':'' ?>>Betina</option>
          </select>

          <label class="form-label small fw-semibold">Bobot (kg)</label>
          <div class="d-flex gap-2 mb-3">
            <input type="number" name="bobot_min" class="form-control form-control-sm" placeholder="Min" value="<?= @esc($filters['bobot_min']) ?>">
            <input type="number" name="bobot_max" class="form-control form-control-sm" placeholder="Max" value="<?= @esc($filters['bobot_max']) ?>">
          </div>

          <label class="form-label small fw-semibold">Umur Maksimal (tahun)</label>
          <input type="number" name="umur_max" class="form-control form-control-sm mb-3" value="<?= @esc($filters['umur_max']) ?>">

          <button type="submit" class="btn btn-sisapi btn-sm w-100">Terapkan Filter</button>
          <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary btn-sm w-100 mt-2">Reset</a>
        </form>
      </div>
    </div>

    <!-- ===== HASIL LISTING ===== -->
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <p class="mb-0 text-muted">Menampilkan <strong><?= $total ?></strong> ternak</p>
        <form method="get" class="d-flex align-items-center gap-2">
          <?php foreach ($filters as $key => $val) { if ($val) echo '<input type="hidden" name="'.esc($key).'" value="'.esc($val).'">'; } ?>
          <label class="small mb-0">Urutkan:</label>
          <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width:auto;">
            <option value="terbaru" <?= $sort=='terbaru'?'selected':'' ?>>Terbaru</option>
            <option value="termurah" <?= $sort=='termurah'?'selected':'' ?>>Harga Termurah</option>
            <option value="termahal" <?= $sort=='termahal'?'selected':'' ?>>Harga Tertinggi</option>
            <option value="terpopuler" <?= $sort=='terpopuler'?'selected':'' ?>>Paling Banyak Dilihat</option>
          </select>
        </form>
      </div>

      <div class="row g-3">
        <?php if (!empty($produk)): foreach ($produk as $p): ?>
          <div class="col-6 col-md-4">
            <?php $this->load->view('produk/_card', array('p' => $p)); ?>
          </div>
        <?php endforeach; else: ?>
          <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <p class="text-muted mt-2">Tidak ada ternak yang sesuai dengan filter Anda.</p>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($total_page > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_page; $i++): ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($filters, array('sort'=>$sort,'page'=>$i))) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>
