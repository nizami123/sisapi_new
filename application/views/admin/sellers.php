<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-3"><?php $this->load->view('admin/_sidebar'); ?></div>
    <div class="col-lg-9">
      <h3 class="fw-bold mb-4">Kelola Peternak</h3>
      <table class="table table-striped" id="sellersTable">
        <thead><tr><th>Peternakan</th><th>Pemilik</th><th>WhatsApp</th><th>Verifikasi</th><th>Status Akun</th></tr></thead>
        <tbody>
        <?php foreach ($sellers as $s): ?>
          <tr>
            <td><?= htmlspecialchars($s['farm_name']) ?></td>
            <td><?= htmlspecialchars($s['name']) ?> (<?= htmlspecialchars($s['email']) ?>)</td>
            <td><?= htmlspecialchars($s['phone_whatsapp']) ?></td>
            <td><span class="badge bg-<?= $s['is_verified']?'success':'warning text-dark' ?>"><?= $s['is_verified']?'Terverifikasi':'Belum' ?></span></td>
            <td><span class="badge bg-<?= $s['user_status']=='active'?'success':'danger' ?>"><?= ucfirst($s['user_status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>$(document).ready(function(){ $('#sellersTable').DataTable(); });</script>
