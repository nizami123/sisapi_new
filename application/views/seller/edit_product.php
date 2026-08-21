<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('seller/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Edit Listing</h3>
      <?php if (isset($error)): ?><div class="alert alert-danger small"><?= $error ?></div><?php endif; ?>
      <form method="post" action="<?= base_url('dashboard/edit/'.$product['id']) ?>" enctype="multipart/form-data">
        <div class="sisapi-filter-card mb-3">
          <div class="row g-3">
            <div class="col-12"><label class="form-label small fw-semibold">Nama Produk</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required></div>
            <div class="col-md-6"><label class="form-label small fw-semibold">Harga (Rp)</label><input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required></div>
            <div class="col-12"><label class="form-label small fw-semibold">Deskripsi</label><textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea></div>
          </div>
        </div>
        <div class="sisapi-filter-card mb-3">
          <h6 class="mb-2">Tambah Foto Baru (opsional)</h6>
          <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
          <div class="d-flex gap-2 mt-3 flex-wrap">
            <?php foreach ($images as $img): ?>
              <img src="<?= base_url($img['image_path']) ?>" style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
            <?php endforeach; ?>
          </div>
        </div>
        <div class="alert alert-info small">Perubahan pada listing ini akan dikirim ulang untuk moderasi admin sebelum tayang kembali.</div>
        <button type="submit" class="btn btn-sisapi-green px-4">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</div>
