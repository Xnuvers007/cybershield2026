<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A05:2021 — Security Misconfiguration
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan konfigurasi keamanan yang salah:
 *             debug mode aktif, default credentials, directory listing.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// ⚠️ RENTAN: Error reporting aktif penuh di production
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>🔴 RENTAN — Security Misconfiguration</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Aplikasi dengan konfigurasi keamanan yang salah.</p>";
echo "<hr>";

// ⚠️ RENTAN: Default credentials yang tidak diubah
$db_config = [
    'host' => 'localhost',
    'user' => 'root',        // ⚠️ Default username
    'pass' => '',             // ⚠️ Password kosong!
    'db'   => 'cybershield_lab'
];

echo "<h3>1. Default Credentials ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Kredensial default tidak diubah<br>";
echo "\$db_user = <span style='color:#ff6b6b;'>\"root\"</span>; // Default!<br>";
echo "\$db_pass = <span style='color:#ff6b6b;'>\"\"</span>;&nbsp;&nbsp;&nbsp;&nbsp; // Kosong!<br>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Menampilkan informasi server
echo "<h3>2. Informasi Server Terekspos ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "PHP Version: <span style='color:#ff6b6b;'>" . phpversion() . "</span><br>";
echo "Server Software: <span style='color:#ff6b6b;'>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . "</span><br>";
echo "Document Root: <span style='color:#ff6b6b;'>" . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "</span><br>";
echo "Server OS: <span style='color:#ff6b6b;'>" . php_uname() . "</span><br>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: phpinfo() accessible
echo "<h3>3. phpinfo() Bisa Diakses ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: phpinfo() menampilkan semua konfigurasi server<br>";
echo "// File: /info.php<br>";
echo "<span style='color:#ff6b6b;'>phpinfo();</span> // Siapa saja bisa mengakses!<br><br>";
echo "Coba akses: <a href='#' style='color:#4da6ff;'>http://target.com/info.php</a><br>";
echo "Ini menampilkan: versi PHP, modul, konfigurasi, environment variables, dll.";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Error message yang terlalu detail
echo "<h3>4. Verbose Error Messages ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
// Trigger error yang menampilkan path
try {
    $result = @file_get_contents("/path/yang/tidak/ada/secret_config.ini");
    if ($result === false) {
        echo "Error: <span style='color:#ff6b6b;'>Failed to open stream: No such file or directory</span><br>";
        echo "File: <span style='color:#ff6b6b;'>/var/www/html/app/config/secret_config.ini</span><br>";
        echo "Line: <span style='color:#ff6b6b;'>42</span><br><br>";
        echo "// ⚠️ Error menampilkan path lengkap file internal!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Security headers tidak di-set
echo "<h3>5. Security Headers Tidak Ada ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Tidak ada security headers<br>";
echo "// Cek dengan: curl -I http://target.com<br><br>";
echo "Headers yang TIDAK ada:<br>";
echo "❌ X-Content-Type-Options<br>";
echo "❌ X-Frame-Options<br>";
echo "❌ Content-Security-Policy<br>";
echo "❌ Strict-Transport-Security<br>";
echo "❌ X-XSS-Protection<br>";
echo "❌ Referrer-Policy";
echo "</div>";

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan Konfigurasi:</h3>";
echo "<ol>";
echo "<li><strong>Debug Mode Aktif:</strong> Error detail terekspos ke pengguna/penyerang.</li>";
echo "<li><strong>Default Credentials:</strong> Username/password bawaan tidak diubah.</li>";
echo "<li><strong>Information Disclosure:</strong> phpinfo(), versi server terekspos.</li>";
echo "<li><strong>Missing Security Headers:</strong> Tidak ada proteksi clickjacking, XSS, dll.</li>";
echo "<li><strong>Verbose Errors:</strong> Error menampilkan path internal dan detail teknis.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
