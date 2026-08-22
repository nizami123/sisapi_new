<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($meta_title) ? esc($meta_title) : 'SISAPI - Marketplace Peternakan Indonesia' ?></title>
<meta name="description" content="<?= isset($meta_description) ? esc($meta_description) : 'Marketplace ternak terpercaya di Indonesia' ?>">
<meta property="og:title" content="<?= isset($meta_title) ? esc($meta_title) : 'SISAPI' ?>">
<meta property="og:description" content="<?= isset($meta_description) ? esc($meta_description) : '' ?>">
<meta property="og:type" content="website">
<link rel="canonical" href="<?= current_url() ?>">

<!-- Bootstrap 5 & Bootstrap Icons (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-sisapi sticky-top py-3">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url() ?>"><i class="bi bi-flower2"></i> SISAPI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('produk') ?>">Katalog Ternak</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('peternak-terpercaya') ?>">Peternak Terpercaya</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('artikel') ?>">Artikel</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('tentang') ?>">Tentang</a></li>
      </ul>
      <div class="d-flex gap-2">
        <?php if ($this->session->userdata('logged_in')): ?>
          <?php $role = $this->session->userdata('role_name'); ?>
          <a href="<?= base_url($role === 'peternak' ? 'dashboard' : 'admin') ?>" class="btn btn-outline-sisapi btn-sm">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
          <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-danger">Keluar</a>
        <?php else: ?>
          <a href="<?= base_url('login') ?>" class="btn btn-outline-sisapi btn-sm">Masuk</a>
          <a href="<?= base_url('daftar-peternak') ?>" class="btn btn-sisapi btn-sm">Daftar Jadi Peternak</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0 text-center" role="alert">
    <?= esc($this->session->flashdata('success')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0 text-center" role="alert">
    <?= esc($this->session->flashdata('error')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>
