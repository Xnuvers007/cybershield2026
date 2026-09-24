<?php
// Script Auto Install & Reset Database (CYBERSHIELD 2026)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database (Sesuai dengan cPanel user)
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

if ($conn->connect_error) {
    die("<div style='color:red; font-family:sans-serif;'><h2>❌ Koneksi Database Gagal</h2><p>" . $conn->connect_error . "</p></div>");
}

function run_sql_file($conn, $filename) {
    if (!file_exists($filename)) {
        echo "<p style='color:red;'>File $filename tidak ditemukan!</p>";
        return;
    }
    
    $lines = file($filename);
    $query = '';
    foreach ($lines as $line) {
        $trimmed = trim($line);
        // Abaikan baris kosong atau komentar SQL
        if (empty($trimmed) || strpos($trimmed, '--') === 0 || strpos($trimmed, '/*') === 0) {
            continue;
        }
        
        $query .= $line;
        
        // Jika menemukan akhir dari satu statement (;) eksekusi
        if (substr(rtrim($query), -1) == ';') {
            // Abaikan query CREATE DATABASE dan USE yang ditolak oleh cPanel
            if (stripos(trim($query), 'CREATE DATABASE') === 0 || stripos(trim($query), 'USE ') === 0) {
                $query = '';
                continue;
            }
            
            if (!$conn->query($query)) {
                echo "<p style='color:orange;'>Warning: " . $conn->error . "<br><small>" . htmlspecialchars(substr($query, 0, 100)) . "...</small></p>";
            }
            $query = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Auto Install & Reset Database</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0a0a16; color: #eee; padding: 40px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; background: #161628; padding: 30px; border-radius: 10px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { color: #06b6d4; margin-top: 0; }
        .success { color: #10b981; font-weight: bold; padding: 10px; background: rgba(16,185,129,0.1); border-radius: 5px; margin-bottom: 10px; border-left: 4px solid #10b981; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn:hover { background: #7c3aed; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔄 Reset & Instalasi Database Lab</h1>
    <p>Menghapus data lama dan menginisialisasi ulang seluruh tabel secara utuh sesuai file <code>.sql</code>...</p>
    <hr style="border: 1px solid #333; margin: 20px 0;">

    <?php
    // 1. Eksekusi setup_database.sql
    echo "<p>Memproses <code>setup_database.sql</code> (users, products, comments)...</p>";
    run_sql_file($conn, 'setup_database.sql');
    echo "<div class='success'>✔️ Tabel Utama berhasil di-reset.</div>";

    // 2. Eksekusi setup_target.sql
    echo "<p>Memproses <code>setup_target.sql</code> (target_users, target_posts)...</p>";
    run_sql_file($conn, 'setup_target.sql');
    echo "<div class='success'>✔️ Tabel Target Web (CyberBoard) berhasil di-reset.</div>";

    // 3. Setup Lab 16 (SQLi News)
    echo "<p>Memproses tabel untuk <code>16_SQLi_News</code>...</p>";
    $conn->multi_query("
        DROP TABLE IF EXISTS news;
        DROP TABLE IF EXISTS hidden_credentials;
        CREATE TABLE news (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100), content TEXT, author VARCHAR(50));
        INSERT INTO news (title, content, author) VALUES 
        ('Serangan Siber Meningkat', 'Serangan siber di tahun 2026 meningkat tajam...', 'Admin IT'),
        ('Pentingnya Update Patch', 'Selalu perbarui sistem Anda untuk menghindari eksploitasi...', 'Security Team'),
        ('Webinar Keamanan Gratis', 'Ikuti webinar kami minggu depan!', 'Event Organizer');
        CREATE TABLE hidden_credentials (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), secret_key VARCHAR(100));
        INSERT INTO hidden_credentials (username, secret_key) VALUES ('superadmin', 'FLAG{d10s_sqli_m4st3r_2026}'), ('db_admin', 'p4ssw0rd_s4ng4t_r4h4s1a');
    ");
    
    // Clear results
    do {
        if ($res = $conn->store_result()) { $res->free(); }
    } while ($conn->more_results() && $conn->next_result());
    
    echo "<div class='success'>✔️ Tabel Lab 16 (news, hidden_credentials) berhasil di-reset.</div>";

    ?>

    <hr style="border: 1px solid #333; margin: 20px 0;">
    <h2 style="color: #10b981;">✅ Instalasi Selesai!</h2>
    <p>Semua tabel telah di-rebuild ulang dari awal sesuai isi file SQL Anda.</p>
    <a href="index.php" class="btn">🏠 Kembali ke Portal Utama</a>
</div>
</body>
</html>
