<?php
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Hapus tabel lama jika ada
$conn->query("DROP TABLE IF EXISTS news");
$conn->query("DROP TABLE IF EXISTS hidden_credentials");

// Buat tabel news
$conn->query("CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    content TEXT,
    author VARCHAR(50)
)");

// Isi tabel news
$conn->query("INSERT INTO news (title, content, author) VALUES 
('Serangan Siber Meningkat', 'Serangan siber di tahun 2026 meningkat tajam...', 'Admin IT'),
('Pentingnya Update Patch', 'Selalu perbarui sistem Anda untuk menghindari eksploitasi...', 'Security Team'),
('Webinar Keamanan Gratis', 'Ikuti webinar kami minggu depan!', 'Event Organizer')");

// Buat tabel rahasia untuk target DIOS
$conn->query("CREATE TABLE hidden_credentials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    secret_key VARCHAR(100)
)");

// Isi tabel rahasia
$conn->query("INSERT INTO hidden_credentials (username, secret_key) VALUES 
('superadmin', 'FLAG{d10s_sqli_m4st3r_2026}'),
('db_admin', 'p4ssw0rd_s4ng4t_r4h4s1a')");

echo "<h1>✅ Setup Berhasil!</h1>";
echo "<p>Tabel 'news' dan 'hidden_credentials' telah dibuat beserta isinya di database Anda.</p>";
echo "<a href='vuln.php'>➡️ Lanjut ke Lab SQLi Portal Berita</a>";
?>
