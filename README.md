# SISAPI — Sistem Informasi & Marketplace Peternakan

MVP marketplace peternakan berbasis **CodeIgniter 3 + MySQL + Bootstrap 5 + Leaflet/OpenStreetMap**,
sesuai spesifikasi: peternak mendaftar & memposting ternak/produk, pembeli mencari & menghubungi
penjual langsung via **WhatsApp** (tanpa sistem pembayaran online).

## ⚠️ Penting — apa yang ADA dan BELUM ADA di paket ini

Paket ini berisi seluruh kode **application/** (controllers, models, views), skema **database**,
dan **assets/** (CSS/JS) yang sudah siap pakai. Namun paket ini **tidak menyertakan folder
`system/` milik framework CodeIgniter 3 itu sendiri**, karena dibuat di lingkungan tanpa akses
internet. Anda perlu mengunduhnya sendiri (gratis, resmi):

1. Unduh CodeIgniter 3 (versi 3.1.13 ke atas) dari:
   https://codeigniter.com/download atau https://github.com/bcit-ci/CodeIgniter/releases
2. Ekstrak, lalu salin folder **`system/`** dan file **`index.php`** bawaan CodeIgniter 3 ke root
   folder `sisapi/` ini (sejajar dengan folder `application/`, `assets/`, `database/`, `uploads/`).
3. Struktur akhir harus seperti:
   ```
   sisapi/
   ├── application/     <-- sudah disediakan
   ├── assets/          <-- sudah disediakan
   ├── database/         <-- sudah disediakan (sisapi.sql)
   ├── uploads/          <-- sudah disediakan (folder upload foto)
   ├── system/           <-- SALIN dari CodeIgniter 3 resmi
   ├── index.php         <-- SALIN dari CodeIgniter 3 resmi
   └── .htaccess         <-- sudah disediakan
   ```
4. Di `index.php` bawaan CodeIgniter, pastikan baris `$system_path` dan `$application_folder`
   menunjuk ke `'system'` dan `'application'` (default sudah benar bila struktur di atas diikuti).

## Instalasi

1. **Database**: buat database MySQL/MariaDB bernama `sisapi`, lalu import `database/sisapi.sql`
   ```
   mysql -u root -p sisapi < database/sisapi.sql
   ```
   File ini membuat seluruh tabel (users, seller_profiles, categories, products, product_images,
   livestock_details, provinces, regencies, districts, villages, product_views, whatsapp_clicks,
   favorites, product_reports), mengisi 8 kategori default, dan 1 akun admin default.

2. **Data wilayah Indonesia**: tabel `provinces`, `regencies`, `districts`, `villages` masih kosong
   (hanya struktur). Import data resmi wilayah Indonesia (tersedia gratis di beberapa repo publik,
   misalnya "wilayah-indonesia" berbasis data Kemendagri) ke 4 tabel tersebut.

3. **Konfigurasi**: edit `application/config/database.php` (kredensial DB) dan
   `application/config/config.php` → isi `$config['base_url']`, misal:
   ```php
   $config['base_url'] = 'http://localhost/sisapi/';
   ```
   Ganti juga `$config['encryption_key']` dengan string acak Anda sendiri.

4. **Permission folder upload**:
   ```
   chmod -R 755 uploads/
   ```

5. **Login admin default**:
   - Email: `admin@sisapi.id`
   - Password: `admin123`
   - **⚠️ WAJIB ganti password ini setelah instalasi pertama** (belum ada halaman ganti password
     admin di MVP ini — update manual via database dengan `password_hash()` PHP, atau tambahkan
     fitur "Pengaturan" di dashboard admin).

## Alur MVP (sesuai prioritas di spesifikasi)

```
Login/Register → Daftar Peternak (dengan pilih lokasi di peta)
→ Dashboard Peternak → Tambah Ternak (form dinamis + upload foto + titik lokasi)
→ Admin: Verifikasi Peternak → Admin: Moderasi Listing
→ Listing tayang di Beranda/Pencarian → Pembeli lihat Detail Produk (peta + info ternak)
→ Klik "Hubungi Penjual via WhatsApp" (tercatat statistik) → Peternak: Tandai Terjual
```

## Fitur yang sudah diimplementasikan

- ✅ 3 role (admin/seller/buyer) dengan session + role-guard (`MY_Controller.php`)
- ✅ 8 kategori dapat dikelola admin (aktif/nonaktif/hapus/tambah)
- ✅ Landing page modern (hero, kategori, ternak terdekat, peternak terverifikasi, ternak terbaru, CTA)
- ✅ Listing dengan filter (kategori, kabupaten/kecamatan, harga min/max, urutan terbaru/terdekat/harga)
- ✅ Detail produk: gallery foto, info ternak dinamis, peta Leaflet, tombol WhatsApp dengan pesan otomatis
- ✅ Perhitungan jarak (haversine) & "±X km dari lokasi Anda"
- ✅ Pendaftaran peternak dengan pemilihan titik lokasi di peta (klik/drag marker)
- ✅ Dashboard peternak: statistik (listing aktif/terjual/views/klik WA), tambah/edit/tandai terjual
- ✅ Dashboard admin: statistik lengkap, verifikasi peternak, moderasi listing, kelola kategori/pengguna
- ✅ Status listing lengkap (draft/pending/active/sold/rejected/inactive) dengan alur moderasi
- ✅ Tracking view produk & klik WhatsApp (tabel `product_views`, `whatsapp_clicks`)
- ✅ SEO: slug unik otomatis (`/ternak/nama-produk-slug`), meta title/description, Open Graph dasar
- ✅ Keamanan dasar: password_hash (bcrypt), CSRF protection (aktif di config), validasi upload
  (tipe & ukuran file), prepared statements via Query Builder CodeIgniter (anti SQL injection),
  `htmlspecialchars()` di seluruh output view (anti XSS)
- ✅ Fitur tambahan: favorit (AJAX toggle), share produk (Web Share API), laporkan listing,
  badge Baru/Terverifikasi/Terjual, tombol navigasi ke lokasi (Google Maps)

## Yang disarankan untuk pengembangan lanjutan

- Halaman "Pengaturan" admin (ganti password, konfigurasi umum)
- Notifikasi (email/in-app) saat listing disetujui/ditolak, peternak diverifikasi
- Halaman daftar favorit pembeli
- Rate limiting / captcha di form login & register (anti brute-force)
- Kompresi & resize otomatis foto produk saat upload (mis. pakai GD/Imagick)
- Promosi listing / featured product (fitur lanjutan sesuai spesifikasi §22)
- Import data wilayah Indonesia lengkap ke 4 tabel wilayah

## Struktur folder

```
application/
├── controllers/   Home, Product, Auth, Seller, Admin
├── core/          MY_Controller.php (base + role guard)
├── models/        User, Seller, Category, Region, Product, Favorite
├── views/
│   ├── admin/      dashboard, moderasi, verifikasi, kategori, pengguna, listing, laporan, wilayah
│   ├── auth/       login, register, register_seller
│   ├── frontend/   home, product_list, product_detail, nearby, sellers, seller_profile, about
│   ├── seller/     dashboard, my_products, add_product, edit_product, profile, location
│   └── templates/  header, navbar, footer
├── helpers/        whatsapp_helper (link wa.me, haversine, format rupiah), slug_helper
└── config/         routes, database, config, autoload
```
