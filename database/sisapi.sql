-- =========================================================
-- SISAPI - Sistem Informasi & Marketplace Peternakan
-- Database Schema (MySQL / MariaDB)
-- =========================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- WILAYAH (Provinsi -> Kabupaten -> Kecamatan -> Desa)
-- ---------------------------------------------------------
CREATE TABLE provinces (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE regencies (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  province_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  FOREIGN KEY (province_id) REFERENCES provinces(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE districts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  regency_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  FOREIGN KEY (regency_id) REFERENCES regencies(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE villages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  district_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  FOREIGN KEY (district_id) REFERENCES districts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- USERS & PROFILES
-- ---------------------------------------------------------
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone_whatsapp VARCHAR(20) NOT NULL,
  role ENUM('admin','seller','buyer') NOT NULL DEFAULT 'buyer',
  status ENUM('pending','active','rejected','suspended') NOT NULL DEFAULT 'active',
  photo VARCHAR(255) DEFAULT NULL,
  remember_token VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE seller_profiles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  farm_name VARCHAR(150) NOT NULL,
  description TEXT,
  address VARCHAR(255) NOT NULL,
  village_id INT UNSIGNED DEFAULT NULL,
  district_id INT UNSIGNED DEFAULT NULL,
  regency_id INT UNSIGNED DEFAULT NULL,
  province_id INT UNSIGNED DEFAULT NULL,
  latitude DECIMAL(10,7) DEFAULT NULL,
  longitude DECIMAL(10,7) DEFAULT NULL,
  is_verified TINYINT(1) NOT NULL DEFAULT 0,
  verified_at DATETIME DEFAULT NULL,
  verified_by INT UNSIGNED DEFAULT NULL,
  rejection_reason VARCHAR(255) DEFAULT NULL,
  rating_avg DECIMAL(2,1) DEFAULT 0.0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- KATEGORI
-- ---------------------------------------------------------
CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  icon VARCHAR(100) DEFAULT 'fa-paw',
  type ENUM('livestock','product') NOT NULL DEFAULT 'livestock',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT UNSIGNED DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- PRODUK / LISTING
-- ---------------------------------------------------------
CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  seller_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  price DECIMAL(15,2) NOT NULL,
  description TEXT,
  address VARCHAR(255) DEFAULT NULL,
  village_id INT UNSIGNED DEFAULT NULL,
  district_id INT UNSIGNED DEFAULT NULL,
  regency_id INT UNSIGNED DEFAULT NULL,
  province_id INT UNSIGNED DEFAULT NULL,
  latitude DECIMAL(10,7) DEFAULT NULL,
  longitude DECIMAL(10,7) DEFAULT NULL,
  status ENUM('draft','pending','active','sold','rejected','inactive') NOT NULL DEFAULT 'pending',
  rejection_reason VARCHAR(255) DEFAULT NULL,
  meta_title VARCHAR(180) DEFAULT NULL,
  meta_description VARCHAR(255) DEFAULT NULL,
  view_count INT UNSIGNED NOT NULL DEFAULT 0,
  whatsapp_click_count INT UNSIGNED NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME DEFAULT NULL,
  FOREIGN KEY (seller_id) REFERENCES seller_profiles(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE product_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  is_primary TINYINT(1) NOT NULL DEFAULT 0,
  sort_order INT UNSIGNED DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE livestock_details (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  jenis VARCHAR(100) DEFAULT NULL,
  ras VARCHAR(100) DEFAULT NULL,
  jenis_kelamin ENUM('Jantan','Betina') DEFAULT NULL,
  umur VARCHAR(50) DEFAULT NULL,
  berat VARCHAR(50) DEFAULT NULL,
  warna VARCHAR(50) DEFAULT NULL,
  kondisi_kesehatan VARCHAR(100) DEFAULT NULL,
  status_vaksinasi VARCHAR(100) DEFAULT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- STATISTIK
-- ---------------------------------------------------------
CREATE TABLE product_views (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  viewed_at DATETIME NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE whatsapp_clicks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  clicked_at DATETIME NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- FITUR TAMBAHAN (favorit & laporan)
-- ---------------------------------------------------------
CREATE TABLE favorites (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  UNIQUE KEY uniq_fav (user_id, product_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE product_reports (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  reporter_name VARCHAR(100) DEFAULT NULL,
  reason VARCHAR(255) NOT NULL,
  status ENUM('open','reviewed','closed') NOT NULL DEFAULT 'open',
  created_at DATETIME NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- SEED: kategori default
-- ---------------------------------------------------------
INSERT INTO categories (name, slug, icon, type, sort_order) VALUES
('Sapi', 'sapi', 'fa-cow', 'livestock', 1),
('Kambing', 'kambing', 'fa-paw', 'livestock', 2),
('Domba', 'domba', 'fa-paw', 'livestock', 3),
('Unggas', 'unggas', 'fa-kiwi-bird', 'livestock', 4),
('Produk Hewan', 'produk-hewan', 'fa-egg', 'product', 5),
('Pakan Ternak', 'pakan-ternak', 'fa-wheat-awn', 'product', 6),
('Bibit/Anakan Ternak', 'bibit-anakan-ternak', 'fa-seedling', 'livestock', 7),
('Peralatan Peternakan', 'peralatan-peternakan', 'fa-tractor', 'product', 8);

-- ---------------------------------------------------------
-- SEED: admin default (password: admin123 -- GANTI setelah instalasi!)
-- hash contoh dibuat dengan password_hash('admin123', PASSWORD_BCRYPT)
-- ---------------------------------------------------------
INSERT INTO users (name, email, password, phone_whatsapp, role, status, created_at) VALUES
('Administrator', 'admin@sisapi.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '628123456789', 'admin', 'active', NOW());

SET FOREIGN_KEY_CHECKS = 1;
