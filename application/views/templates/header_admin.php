<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($title) ? esc($title) . ' - Admin SISAPI' : 'Admin Dinas - SISAPI' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<style>body{font-family:'Poppins',sans-serif;} .sidebar-sisapi{overflow-y:auto;max-height:100vh;position:sticky;top:0;}</style>
</head>
<body class="bg-light-gray">
<div class="d-flex">
  <aside class="sidebar-sisapi p-3" style="width:260px;min-height:100vh;">
    <a href="<?= base_url() ?>" class="d-block text-center mb-4">
      <span class="fw-bold fs-5" style="color:var(--sisapi-green)"><i class="bi bi-flower2"></i> SISAPI Admin</span>
    </a>
    <nav class="nav flex-column">
      <a class="nav-link <?= (@$active=='dashboard')?'active':'' ?>" href="<?= base_url('admin') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>

      <small class="text-muted text-uppercase mt-3 mb-1 px-2" style="font-size:.7rem;">Master Data</small>
      <a class="nav-link <?= (@$active=='kategori')?'active':'' ?>" href="<?= base_url('admin/kategori') ?>"><i class="bi bi-tags"></i> Master Kategori</a>
      <a class="nav-link <?= (@$active=='wilayah')?'active':'' ?>" href="<?= base_url('admin/wilayah') ?>"><i class="bi bi-map"></i> Master Wilayah</a>

      <small class="text-muted text-uppercase mt-3 mb-1 px-2" style="font-size:.7rem;">Verifikasi Berjenjang</small>
      <a class="nav-link <?= (@$active=='peternak')?'active':'' ?>" href="<?= base_url('admin/peternak') ?>"><i class="bi bi-people"></i> Data &amp; Verifikasi Peternak</a>
      <a class="nav-link <?= (@$active=='produk')?'active':'' ?>" href="<?= base_url('admin/produk') ?>"><i class="bi bi-box-seam"></i> Data &amp; Verifikasi Produk</a>

      <small class="text-muted text-uppercase mt-3 mb-1 px-2" style="font-size:.7rem;">Konten</small>
      <a class="nav-link <?= (@$active=='artikel')?'active':'' ?>" href="<?= base_url('admin/artikel') ?>"><i class="bi bi-newspaper"></i> Artikel</a>
      <a class="nav-link <?= (@$active=='banner')?'active':'' ?>" href="<?= base_url('admin/banner') ?>"><i class="bi bi-images"></i> Banner</a>

      <small class="text-muted text-uppercase mt-3 mb-1 px-2" style="font-size:.7rem;">Laporan</small>
      <a class="nav-link <?= (@$active=='laporan')?'active':'' ?>" href="<?= base_url('admin/laporan') ?>"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
      <a class="nav-link <?= (@$active=='statistik')?'active':'' ?>" href="<?= base_url('admin/statistik') ?>"><i class="bi bi-bar-chart"></i> Statistik</a>

      <small class="text-muted text-uppercase mt-3 mb-1 px-2" style="font-size:.7rem;">Sistem</small>
      <a class="nav-link <?= (@$active=='pengaturan')?'active':'' ?>" href="<?= base_url('admin/pengaturan') ?>"><i class="bi bi-gear"></i> Pengaturan Website</a>
      <a class="nav-link <?= (@$active=='user')?'active':'' ?>" href="<?= base_url('admin/user') ?>"><i class="bi bi-person-badge"></i> Manajemen User</a>
      <a class="nav-link <?= (@$active=='log')?'active':'' ?>" href="<?= base_url('admin/log-aktivitas') ?>"><i class="bi bi-journal-text"></i> Log Aktivitas</a>
      <hr>
      <a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Keluar</a>
    </nav>
  </aside>

  <main class="flex-grow-1">
    <div class="topbar-dashboard px-4 py-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 fw-bold"><?= isset($title) ? esc($title) : 'Dashboard Admin' ?></h5>
      <a href="<?= base_url() ?>" class="btn btn-sm btn-outline-sisapi"><i class="bi bi-globe"></i> Lihat Website</a>
    </div>
    <div class="p-4">
      <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= esc($this->session->flashdata('success')) ?></div><?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger"><?= esc($this->session->flashdata('error')) ?></div><?php endif; ?>
