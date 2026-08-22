<div class="card border-0 shadow-sm p-3">
  <h6 class="fw-bold mb-3"><i class="bi bi-journal-text"></i> Log Aktivitas (Audit Trail)</h6>
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead class="table-light"><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>Modul</th><th>Deskripsi</th><th>IP</th></tr></thead>
      <tbody>
      <?php foreach ($log as $l): ?>
        <tr>
          <td><?= date('d M Y H:i', strtotime($l->created_at)) ?></td>
          <td><?= esc($l->username ?: 'Sistem') ?></td>
          <td><span class="badge bg-light text-dark border"><?= esc($l->aksi) ?></span></td>
          <td><?= esc($l->modul) ?></td>
          <td class="small"><?= esc($l->deskripsi) ?></td>
          <td class="small text-muted"><?= esc($l->ip_address) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($log)): ?><tr><td colspan="6" class="text-center text-muted py-4">Belum ada log aktivitas.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
