<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($title) ? $title : 'SISAPI - Pasar Ternak & Produk Peternakan' ?></title>
<meta name="description" content="<?= isset($meta_description) ? $meta_description : 'SISAPI mempertemukan peternak dan pembeli ternak/produk peternakan di seluruh Indonesia.' ?>">
<meta property="og:title" content="<?= isset($title) ? $title : 'SISAPI' ?>">
<meta property="og:description" content="<?= isset($meta_description) ? $meta_description : 'Pasar ternak digital Indonesia.' ?>">
<meta property="og:type" content="website">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap 5 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<!-- Leaflet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" rel="stylesheet">
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show m-0 rounded-0 text-center" role="alert">
  <?= $this->session->flashdata('success') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if ($this->session->flashdata('warning')): ?>
<div class="alert alert-warning alert-dismissible fade show m-0 rounded-0 text-center" role="alert">
  <?= $this->session->flashdata('warning') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
