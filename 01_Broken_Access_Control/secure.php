<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Broken Access Control yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A01:2021 — Broken Access Control
 * Solusi    : Validasi otorisasi, RBAC, indirect reference
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// Koneksi database
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

session_start();
$_SESSION['user_id'] = 2;
$_SESSION['role'] = 'user';

echo "<h1>🟢 AMAN — Broken Access Control (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Validasi otorisasi di server-side sebelum menampilkan data.</p>";
echo "<hr>";

// ✅ AMAN: Ambil parameter ID dengan filter
$requested_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// ✅ AMAN: Validasi input
if ($requested_id === false || $requested_id === null) {
    die("<p style='color:red;'>❌ Parameter ID tidak valid.</p>");
}

// ✅ AMAN: Cek otorisasi — user hanya boleh melihat data miliknya sendiri
$current_user_id = $_SESSION['user_id'];
$current_role = $_SESSION['role'];

if ($current_role !== 'admin' && $requested_id !== $current_user_id) {
    // ✅ AMAN: Log percobaan akses tidak sah
    error_log("[SECURITY] User ID {$current_user_id} mencoba mengakses profil User ID {$requested_id} — DITOLAK");
    
    http_response_code(403);
    die("<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>
        <h3>🚫 Akses Ditolak (403 Forbidden)</h3>
        <p>Anda tidak memiliki izin untuk melihat profil user lain.</p>
        <p>Percobaan akses ini telah <strong>dicatat dalam log keamanan</strong>.</p>
    </div>");
}

// ✅ AMAN: Gunakan Prepared Statement untuk mencegah SQL Injection
$stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $requested_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<div style='background:#1a1a2e;color:#eee;padding:20px;border-radius:8px;font-family:monospace;'>";
    echo "<h3>📋 Profil User (Akses Terotorisasi)</h3>";
    echo "<p><strong>ID:</strong> {$user['id']}</p>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><strong>Role:</strong> " . htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') . "</p>";
    echo "</div>";
} else {
    echo "<p>User tidak ditemukan.</p>";
}

$stmt->close();

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Validasi Otorisasi:</strong> Cek apakah user yang login berhak mengakses data yang diminta.</li>";
echo "<li><strong>Role-Based Access Control (RBAC):</strong> Hanya admin yang bisa melihat semua profil.</li>";
echo "<li><strong>Prepared Statement:</strong> Mencegah SQL Injection pada parameter ID.</li>";
echo "<li><strong>Input Validation:</strong> Filter dan validasi parameter sebelum digunakan.</li>";
echo "<li><strong>Output Encoding:</strong> <code>htmlspecialchars()</code> untuk mencegah XSS.</li>";
echo "<li><strong>Security Logging:</strong> Catat percobaan akses tidak sah.</li>";
echo "<li><strong>HTTP Status Code:</strong> Kembalikan 403 untuk akses tidak sah.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php?id=1'>⬅️ Lihat versi RENTAN</a>";
?>
