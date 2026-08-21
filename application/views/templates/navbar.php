<?php
$is_logged_in = $this->session->userdata('user_id');
$role = $this->session->userdata('role');
$current_uri = uri_string();
?>
<nav class="sisapi-navbar">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a href="<?= base_url() ?>" class="d-flex align-items-center gap-2 text-decoration-none">
      <div class="brand-logo"><i class="fa-solid fa-cow"></i></div>
      <div class="brand-text">
        <strong>SISAPI</strong>
        <small>Pasar Ternak & Produk Peternakan</small>
      </div>
    </a>

    <button class="btn btn-outline-sisapi d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sisapiNavMenu">
      <i class="fa-solid fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse d-lg-flex justify-content-lg-center flex-lg-grow-1" id="sisapiNavMenu">
      <ul class="navbar-nav d-lg-flex flex-lg-row gap-lg-4 mb-2 mb-lg-0 mt-2 mt-lg-0">
        <li class="nav-item"><a class="nav-link <?= $current_uri === '' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a></li>
        <li class="nav-item"><a class="nav-link <?= strpos($current_uri,'kategori')===0 ? 'active':'' ?>" href="<?= base_url('cari') ?>">Kategori</a></li>
        <li class="nav-item"><a class="nav-link <?= $current_uri==='ternak-terdekat'?'active':'' ?>" href="<?= base_url('ternak-terdekat') ?>">Ternak Terdekat</a></li>
        <li class="nav-item"><a class="nav-link <?= $current_uri==='peternak'?'active':'' ?>" href="<?= base_url('peternak') ?>">Peternak</a></li>
        <li class="nav-item"><a class="nav-link <?= $current_uri==='tentang'?'active':'' ?>" href="<?= base_url('tentang') ?>">Tentang SISAPI</a></li>
      </ul>
    </div>

    <div class="d-flex align-items-center gap-2">
      <?php if ($is_logged_in): ?>
        <?php if ($role === 'admin'): ?>
          <a href="<?= base_url('admin') ?>" class="btn btn-outline-sisapi btn-sm px-3">Dashboard Admin</a>
        <?php elseif ($role === 'seller'): ?>
          <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-sisapi btn-sm px-3">Dashboard Saya</a>
        <?php endif; ?>
        <div class="dropdown">
          <a href="#" class="btn btn-sisapi-green btn-sm px-3 dropdown-toggle" data-bs-toggle="dropdown">
            <?= htmlspecialchars($this->session->userdata('name')) ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="<?= base_url('login') ?>" class="btn btn-outline-sisapi btn-sm px-3">Login</a>
        <a href="<?= base_url('daftar') ?>" class="btn btn-sisapi-green btn-sm px-3">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
