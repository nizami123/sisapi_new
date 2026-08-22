<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($title) ? esc($title) . ' - SISAPI' : 'Dashboard Peternak - SISAPI' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<style>body{font-family:'Poppins',sans-serif;}</style>
</head>
<body class="bg-light-gray">
<div class="d-flex">
  <!-- SIDEBAR -->
  <aside class="sidebar-sisapi p-3" style="width:250px;min-height:100vh;">
    <a href="<?= base_url() ?>" class="d-block text-center mb-4">
      <span class="fw-bold fs-5" style="color:var(--sisapi-green)"><i class="bi bi-flower2"></i> SISAPI</span>
    </a>
    <nav class="nav flex-column">
      <a class="nav-link <?= (@$active=='dashboard')?'active':'' ?>" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a class="nav-link <?= (@$active=='profil')?'active':'' ?>" href="<?= base_url('dashboard/profil') ?>"><i class="bi bi-person-circle"></i> Profil</a>
      <a class="nav-link <?= (@$active=='produk')?'active':'' ?>" href="<?= base_url('dashboard/produk') ?>"><i class="bi bi-box-seam"></i> Data Ternak</a>
      <a class="nav-link" href="<?= base_url('dashboard/produk/tambah') ?>"><i class="bi bi-plus-circle"></i> Tambah Ternak</a>
      <a class="nav-link <?= (@$active=='statistik')?'active':'' ?>" href="<?= base_url('dashboard/statistik') ?>"><i class="bi bi-graph-up"></i> Statistik Dilihat</a>
      <a class="nav-link <?= (@$active=='pesan')?'active':'' ?>" href="<?= base_url('dashboard/pesan') ?>"><i class="bi bi-chat-dots"></i> Pesan</a>
      <a class="nav-link" href="<?= base_url('artikel') ?>"><i class="bi bi-newspaper"></i> Artikel</a>
      <a class="nav-link <?= (@$active=='pengaturan')?'active':'' ?>" href="<?= base_url('dashboard/pengaturan') ?>"><i class="bi bi-gear"></i> Pengaturan</a>
      <hr>
      <a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Keluar</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-grow-1">
    <div class="topbar-dashboard px-4 py-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 fw-bold"><?= isset($title) ? esc($title) : 'Dashboard' ?></h5>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= base_url() ?>" class="btn btn-sm btn-outline-sisapi"><i class="bi bi-globe"></i> Lihat Website</a>
      </div>
    </div>
    <div class="p-4">
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= esc($this->session->flashdata('success')) ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= esc($this->session->flashdata('error')) ?></div>
      <?php endif; ?>
