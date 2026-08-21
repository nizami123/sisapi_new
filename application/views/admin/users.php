<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Kelola Pengguna</h3>
      <table class="table table-striped" id="usersTable">
        <thead><tr><th>Nama</th><th>Email</th><th>WhatsApp</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['phone_whatsapp']) ?></td>
            <td><span class="badge bg-secondary"><?= ucfirst($u['role']) ?></span></td>
            <td><span class="badge bg-<?= $u['status']=='active'?'success':'danger' ?>"><?= ucfirst($u['status']) ?></span></td>
            <td>
              <?php if ($u['role'] !== 'admin'): ?>
                <?php if ($u['status'] === 'active'): ?>
                  <a href="<?= base_url('admin/suspend_user/'.$u['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Nonaktifkan pengguna ini?')">Nonaktifkan</a>
                <?php else: ?>
                  <a href="<?= base_url('admin/activate_user/'.$u['id']) ?>" class="btn btn-sm btn-outline-sisapi">Aktifkan</a>
                <?php endif; ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>$(document).ready(function(){ $('#usersTable').DataTable(); });</script>
