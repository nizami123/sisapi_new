<div class="card border-0 shadow-sm p-4" style="max-width:700px;">
  <h6 class="fw-bold mb-3">Pengaturan Website</h6>
  <?= form_open('admin/pengaturan') ?>
    <?php foreach ($pengaturan as $s): ?>
      <div class="mb-3">
        <label class="form-label small"><?= esc(ucwords(str_replace('_',' ',$s->key_setting))) ?></label>
        <input type="text" name="setting[<?= esc($s->key_setting) ?>]" class="form-control" value="<?= esc($s->value_setting) ?>">
      </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-sisapi"><i class="bi bi-save"></i> Simpan Pengaturan</button>
  <?= form_close() ?>
</div>
