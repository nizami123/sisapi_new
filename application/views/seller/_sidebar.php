<?php $uri = uri_string(); ?>
<div class="d-flex flex-column gap-1">
  <a href="<?= base_url('dashboard') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='dashboard'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
  <a href="<?= base_url('dashboard/ternak-saya') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='dashboard/ternak-saya'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-cow me-2"></i>Ternak Saya</a>
  <a href="<?= base_url('dashboard/tambah-ternak') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='dashboard/tambah-ternak'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-plus me-2"></i>Tambah Ternak</a>
  <a href="<?= base_url('dashboard/profil') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='dashboard/profil'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-store me-2"></i>Profil Peternakan</a>
  <a href="<?= base_url('dashboard/lokasi') ?>" class="sisapi-cat-list-link p-2 rounded <?= $uri=='dashboard/lokasi'?'bg-success bg-opacity-10 fw-semibold':'' ?>"><i class="fa-solid fa-location-dot me-2"></i>Lokasi Peternakan</a>
</div>
<style>.sisapi-cat-list-link{color:var(--sisapi-text);text-decoration:none;display:block;}</style>
