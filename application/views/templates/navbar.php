<?php
$is_logged_in = $this->session->userdata('user_id');
$role = $this->session->userdata('role');
$current_uri = uri_string();

$menu_items = array(
    array('label' => 'Beranda', 'url' => base_url(), 'active' => $current_uri === ''),
    array('label' => 'Kategori', 'url' => base_url('cari'), 'active' => strpos($current_uri, 'kategori') === 0),
    array('label' => 'Ternak Terdekat', 'url' => base_url('ternak-terdekat'), 'active' => $current_uri === 'ternak-terdekat'),
    array('label' => 'Peternak', 'url' => base_url('peternak'), 'active' => $current_uri === 'peternak'),
    array('label' => 'Tentang SISAPI', 'url' => base_url('tentang'), 'active' => $current_uri === 'tentang'),
);
?>
<nav class="sisapi-navbar">
  <div class="container d-flex align-items-center justify-content-between py-1">

    <!-- BRAND -->
    <a href="<?= base_url() ?>" class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0">
      <div class="brand-logo"><i class="fa-solid fa-cow"></i></div>
      <div class="brand-text">
        <strong>SISAPI</strong>
        <small>Pasar Ternak & Produk Peternakan</small>
      </div>
    </a>

    <!-- MENU DESKTOP (tampil hanya di layar >= lg, satu baris, tidak akan pernah wrap ke bawah) -->
    <ul class="navbar-nav d-none d-lg-flex flex-row gap-4 mb-0 mx-auto">
      <?php foreach ($menu_items as $item): ?>
        <li class="nav-item"><a class="nav-link <?= $item['active'] ? 'active' : '' ?>" href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
      <?php endforeach; ?>
    </ul>

    <!-- AUTH BUTTONS DESKTOP -->
    <div class="d-none d-lg-flex align-items-center gap-2 flex-shrink-0">
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

    <!-- TOMBOL HAMBURGER (hanya tampil di layar < lg) -->
    <button class="btn btn-outline-sisapi d-lg-none flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#sisapiMobileMenu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>

  <!-- MENU MOBILE (drawer terpisah di bawah baris utama, full-width, hanya untuk layar < lg) -->
  <div class="collapse d-lg-none" id="sisapiMobileMenu">
    <div class="container border-top py-3">
      <ul class="navbar-nav mb-3">
        <?php foreach ($menu_items as $item): ?>
          <li class="nav-item mb-1"><a class="nav-link <?= $item['active'] ? 'active' : '' ?>" href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
        <?php endforeach; ?>
      </ul>
      <div class="d-flex gap-2">
        <?php if ($is_logged_in): ?>
          <?php if ($role === 'admin'): ?>
            <a href="<?= base_url('admin') ?>" class="btn btn-outline-sisapi btn-sm px-3 flex-fill">Dashboard Admin</a>
          <?php elseif ($role === 'seller'): ?>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-sisapi btn-sm px-3 flex-fill">Dashboard Saya</a>
          <?php endif; ?>
          <a href="<?= base_url('logout') ?>" class="btn btn-sisapi-green btn-sm px-3 flex-fill">Keluar</a>
        <?php else: ?>
          <a href="<?= base_url('login') ?>" class="btn btn-outline-sisapi btn-sm px-3 flex-fill">Login</a>
          <a href="<?= base_url('daftar') ?>" class="btn btn-sisapi-green btn-sm px-3 flex-fill">Daftar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
