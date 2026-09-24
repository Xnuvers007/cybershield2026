-- ============================================================================
-- 🛡️ CYBERSHIELD 2026 — Database Setup
-- ============================================================================
-- DISCLAIMER: Database ini HANYA untuk lab edukasi. Jangan gunakan di production!
-- ============================================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS cybershield_lab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cybershield_lab;

-- ============================================================================
-- Tabel: users
-- ============================================================================
-- Digunakan oleh: 01_Broken_Access_Control, 03_Injection, 07_Auth_Failures
-- ============================================================================

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL COMMENT 'Bcrypt hash',
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================================
-- 📋 DAFTAR PASSWORD (PLAINTEXT → HASH)
-- ============================================================================
-- | Username | Password (Plaintext) | Role  |
-- |----------|----------------------|-------|
-- | admin    | admin123             | admin |
-- | user1    | user1234             | user  |
-- | user2    | belajar567           | user  |
-- ============================================================================

INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$12$WEQtNabzoSx1MX.huCGDwO2jcDgfpSarvYHGSikNcGA3K6dZRgpRG', 'admin@cybershield.lab', 'admin'),
-- ^ Plaintext: admin123

('user1', '$2y$12$W2Mpn1u.f3ZuKac7FczoD.65bwjq35YR/E2LsLJXM0Ibi/TYgIu4O', 'user1@cybershield.lab', 'user'),
-- ^ Plaintext: user1234

('user2', '$2y$12$81/862K754/4eHORfTZxn.EHaoEHMKNyw73omHRY2eSWTDNlMUNka', 'user2@cybershield.lab', 'user');
-- ^ Plaintext: belajar567


-- ============================================================================
-- Tabel: products
-- ============================================================================
-- Digunakan oleh: 03_Injection (SQL Injection lab)
-- ============================================================================

DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    category VARCHAR(50)
) ENGINE=InnoDB;

INSERT INTO products (name, description, price, category) VALUES
('Laptop Pro X1', 'Laptop premium untuk developer dengan CPU terbaru dan RAM 32GB', 15000000.00, 'elektronik'),
('Mechanical Keyboard RGB', 'Keyboard mekanik Cherry MX Brown dengan backlight RGB', 1500000.00, 'aksesoris'),
('Monitor 4K UltraWide', 'Monitor 34 inch 4K HDR untuk produktivitas', 5000000.00, 'elektronik'),
('Mouse Wireless Ergonomis', 'Mouse wireless dengan desain ergonomis untuk kerja seharian', 750000.00, 'aksesoris'),
('SSD NVMe 1TB', 'SSD M.2 NVMe Gen4 kecepatan baca 7000MB/s', 1200000.00, 'komponen'),
('Webcam Full HD', 'Webcam 1080p dengan auto-focus dan noise cancelling mic', 650000.00, 'aksesoris'),
('Standing Desk Electric', 'Meja berdiri elektrik dengan memory preset', 3500000.00, 'furnitur'),
('Headphone ANC Pro', 'Headphone wireless Active Noise Cancelling premium', 2800000.00, 'aksesoris');


-- ============================================================================
-- Tabel: comments
-- ============================================================================
-- Digunakan oleh: bonus_XSS (Cross-Site Scripting lab)
-- ============================================================================

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) DEFAULT 'Anonymous',
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO comments (username, comment) VALUES
('Budi', 'Website ini keren! Saya belajar banyak tentang keamanan web.'),
('Siti', 'Terima kasih materinya sangat bermanfaat untuk tugas kuliah saya.'),
('Ahmad', 'OWASP Top 10 memang wajib dipelajari semua developer.'),
('Dewi', 'Kapan ada workshop lanjutan tentang penetration testing?'),
('Riko', 'Lab praktiknya sangat membantu memahami konsep secure coding.');


-- ============================================================================
-- Verifikasi data
-- ============================================================================

SELECT '=== USERS ===' AS info;
SELECT id, username, LEFT(password, 30) AS password_hash_preview, email, role FROM users;

SELECT '=== PRODUCTS ===' AS info;
SELECT id, name, FORMAT(price, 0) AS harga, category FROM products;

SELECT '=== COMMENTS ===' AS info;
SELECT id, username, LEFT(comment, 50) AS comment_preview FROM comments;

SELECT '✅ Database cybershield_lab berhasil di-setup!' AS status;
