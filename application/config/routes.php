<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ---------- FRONTEND ----------
$route['cari'] = 'home/search';
$route['kategori/(:any)'] = 'home/category/$1';
$route['peternak'] = 'home/sellers';
$route['peternak/(:any)'] = 'home/seller_profile/$1';
$route['ternak-terdekat'] = 'home/nearby';
$route['tentang'] = 'home/about';
$route['ternak/(:any)'] = 'product/detail/$1';

// ---------- AUTH ----------
$route['login'] = 'auth/login';
$route['daftar'] = 'auth/register';
$route['daftar-peternak'] = 'auth/register_seller';
$route['logout'] = 'auth/logout';

// ---------- SELLER (dashboard peternak) ----------
$route['dashboard'] = 'seller/dashboard';
$route['dashboard/ternak-saya'] = 'seller/my_products';
$route['dashboard/tambah-ternak'] = 'seller/add_product';
$route['dashboard/edit/(:num)'] = 'seller/edit_product/$1';
$route['dashboard/profil'] = 'seller/profile';
$route['dashboard/lokasi'] = 'seller/location';

// ---------- ADMIN ----------
$route['admin'] = 'admin/dashboard';
$route['admin/pengguna'] = 'admin/users';
$route['admin/peternak'] = 'admin/sellers';
$route['admin/verifikasi-peternak'] = 'admin/verify_sellers';
$route['admin/kategori'] = 'admin/categories';
$route['admin/listing'] = 'admin/listings';
$route['admin/moderasi'] = 'admin/moderation';
$route['admin/wilayah'] = 'admin/regions';
$route['admin/laporan'] = 'admin/reports';
