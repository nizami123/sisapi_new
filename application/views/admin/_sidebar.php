<?php $uri = uri_string(); ?>
<div class="d-flex flex-column gap-1">
  <a href="<?= base_url('admin') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
  <a href="<?= base_url('admin/pengguna') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/pengguna'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-users me-2"></i>Pengguna</a>
  <a href="<?= base_url('admin/peternak') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/peternak'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-tractor me-2"></i>Peternak</a>
  <a href="<?= base_url('admin/verifikasi-peternak') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/verifikasi-peternak'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-user-check me-2"></i>Verifikasi Peternak</a>
  <a href="<?= base_url('admin/kategori') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/kategori'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-tags me-2"></i>Kategori</a>
  <a href="<?= base_url('admin/listing') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/listing'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-list me-2"></i>Listing</a>
  <a href="<?= base_url('admin/moderasi') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/moderasi'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-shield-halved me-2"></i>Moderasi Listing</a>
  <a href="<?= base_url('admin/wilayah') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/wilayah'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-map me-2"></i>Wilayah</a>
  <a href="<?= base_url('admin/laporan') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='admin/laporan'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-flag me-2"></i>Laporan</a>
</div>
<style>.sisapi-cat-list-link{color:var(--sisapi-text);text-decoration:none;display:block;}</style>
