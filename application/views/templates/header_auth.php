<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($meta_title) ? esc($meta_title) : 'SISAPI' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<style>body{background:var(--sisapi-gray);font-family:'Poppins',sans-serif;}</style>
</head>
<body>
<nav class="navbar navbar-sisapi py-3 mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url() ?>"><i class="bi bi-flower2"></i> SISAPI</a>
  </div>
</nav>

<?php if ($this->session->flashdata('success')): ?>
  <div class="container"><div class="alert alert-success"><?= esc($this->session->flashdata('success')) ?></div></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div class="container"><div class="alert alert-danger"><?= esc($this->session->flashdata('error')) ?></div></div>
<?php endif; ?>
<?php if (validation_errors()): ?>
  <div class="container"><div class="alert alert-danger"><?= validation_errors() ?></div></div>
<?php endif; ?>
