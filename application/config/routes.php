<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

// ---------- Publik ----------
$route['/']                                = 'landing/index';
$route['tentang']                          = 'landing/tentang';
$route['produk']                           = 'produk/index';
$route['produk/(:any)']                    = 'produk/detail/$1';
$route['produk/wa-klik/(:num)']            = 'produk/catat_klik_wa/$1';
$route['kategori/(:any)']                  = 'produk/index/$1';
$route['peternak-terpercaya']              = 'landing/daftar_peternak';
$route['peternak-terpercaya/(:any)']       = 'landing/profil_peternak/$1';
$route['artikel']                          = 'artikel/index';
$route['artikel/(:any)']                   = 'artikel/detail/$1';
$route['cari']                             = 'produk/cari';
$route['cari/autocomplete']                = 'produk/autocomplete';
$route['sitemap.xml']                      = 'seo/sitemap';
$route['robots.txt']                       = 'seo/robots';

// ---------- AJAX Wilayah (dropdown berjenjang) ----------
$route['wilayah/ajax/(:any)/(:num)']       = 'wilayah/ajax/$1/$2';

// ---------- Auth ----------
$route['login']                            = 'auth/login';
$route['logout']                           = 'auth/logout';
$route['daftar-peternak']                  = 'auth/register';
$route['lupa-password']                    = 'auth/forgot_password';
$route['reset-password/(:any)']            = 'auth/reset_password/$1';

// ---------- Dashboard Peternak ----------
$route['dashboard']                             = 'dashboard/peternak/index';
$route['dashboard/profil']                      = 'dashboard/peternak/profil';
$route['dashboard/produk']                      = 'dashboard/peternak/produk';
$route['dashboard/produk/tambah']               = 'dashboard/peternak/tambah_produk';
$route['dashboard/produk/edit/(:num)']          = 'dashboard/peternak/edit_produk/$1';
$route['dashboard/produk/hapus/(:num)']         = 'dashboard/peternak/hapus_produk/$1';
$route['dashboard/statistik']                   = 'dashboard/peternak/statistik';
$route['dashboard/pesan']                       = 'dashboard/peternak/pesan';
$route['dashboard/pengaturan']                  = 'dashboard/peternak/pengaturan';

// ---------- Dashboard Admin (Dinas) ----------
$route['admin']                                    = 'dashboard/admin/index';
$route['admin/kategori']                           = 'dashboard/admin/kategori';
$route['admin/wilayah']                            = 'dashboard/admin/wilayah';
$route['admin/peternak']                           = 'dashboard/admin/data_peternak';
$route['admin/peternak/verifikasi/(:num)']         = 'dashboard/admin/verifikasi_peternak/$1';
$route['admin/produk']                             = 'dashboard/admin/data_produk';
$route['admin/produk/verifikasi/(:num)']           = 'dashboard/admin/verifikasi_produk/$1';
$route['admin/artikel']                            = 'dashboard/admin/artikel';
$route['admin/banner']                             = 'dashboard/admin/banner';
$route['admin/laporan']                            = 'dashboard/admin/laporan';
$route['admin/statistik']                          = 'dashboard/admin/statistik';
$route['admin/pengaturan']                         = 'dashboard/admin/pengaturan';
$route['admin/user']                               = 'dashboard/admin/manajemen_user';
$route['admin/log-aktivitas']                      = 'dashboard/admin/log_aktivitas';

