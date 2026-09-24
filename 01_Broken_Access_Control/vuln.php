<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A01:2021 — Broken Access Control
 * Risiko    : CRITICAL
 * Deskripsi : Kode ini mendemonstrasikan kelemahan kontrol akses (IDOR)
 *             dimana user biasa bisa mengakses data user lain.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// Simulasi koneksi database
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

// Simulasi session login (user biasa dengan id=2)
session_start();
$_SESSION['user_id'] = 2;     // User yang sedang login = user2
$_SESSION['role'] = 'user';    // Role = user biasa

echo "<h1>🔴 RENTAN — Broken Access Control (IDOR)</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> User biasa bisa melihat profil user lain hanya dengan mengubah parameter ID di URL.</p>";
echo "<p><strong>Coba:</strong> Ubah <code>?id=1</code> untuk melihat data admin!</p>";
echo "<hr>";

// ⚠️ RENTAN: Mengambil ID dari parameter URL tanpa validasi
// Penyerang bisa mengubah ?id=1, ?id=2, ?id=3 dst untuk melihat data semua user
$user_id = $_GET['id'] ?? 2;

// ⚠️ RENTAN: Tidak ada pengecekan apakah user yang login berhak melihat data ini
try {
    $query = "SELECT id, username, email, role FROM users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<div style='background:#1a1a2e;color:#eee;padding:20px;border-radius:8px;font-family:monospace;'>";
        echo "<h3>📋 Profil User</h3>";
        echo "<p><strong>ID:</strong> {$user['id']}</p>";
        echo "<p><strong>Username:</strong> {$user['username']}</p>";
        echo "<p><strong>Email:</strong> {$user['email']}</p>";
        echo "<p><strong>Role:</strong> {$user['role']}</p>";
        echo "</div>";
    } else {
        echo "<p>User tidak ditemukan.</p>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<div style='background:rgba(255,0,0,0.1); border:1px solid red; padding:15px; border-radius:5px;'>";
    echo "<h4 style='color:red; margin:0;'>💥 SQL Syntax Error Terdeteksi!</h4>";
    echo "<p style='margin:5px 0 0 0;'>Payload Anda merusak struktur SQL karena tidak divalidasi. Ini membuktikan adanya celah SQL Injection.</p>";
    echo "<p style='color:orange; font-size:0.8rem; margin:5px 0 0 0;'>Pesan Database: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>IDOR (Insecure Direct Object Reference):</strong> User bisa mengakses data user lain hanya dengan mengubah parameter <code>id</code> di URL.</li>";
echo "<li><strong>Tidak ada otorisasi:</strong> Tidak ada pengecekan apakah user yang login berhak melihat data yang diminta.</li>";
echo "<li><strong>SQL Injection:</strong> Parameter <code>id</code> langsung dimasukkan ke query tanpa sanitasi.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php?id=2'>➡️ Lihat versi AMAN</a>";
?>
