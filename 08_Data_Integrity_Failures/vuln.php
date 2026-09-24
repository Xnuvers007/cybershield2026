<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A08:2021 — Software and Data Integrity Failures
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan insecure deserialization
 *             dan kegagalan verifikasi integritas data.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🔴 RENTAN — Data Integrity Failures</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Insecure deserialization dan data tanpa verifikasi integritas.</p>";
echo "<hr>";

// ⚠️ RENTAN: Insecure Deserialization
echo "<h3>1. Insecure Deserialization ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";

// Contoh class yang bisa dieksploitasi
class UserPreferences {
    public $theme = 'light';
    public $language = 'id';
    
    // ⚠️ RENTAN: __wakeup atau __destruct bisa dieksploitasi
    public function __destruct() {
        // Contoh: method ini bisa digunakan untuk RCE
        // jika penyerang mengontrol properti $this->cleanup_command
        if (isset($this->cleanup_command)) {
            // ⚠️ BAHAYA: system($this->cleanup_command);
            echo "<br><span style='color:#ff6b6b;'>// system(\$this->cleanup_command) — RCE!</span>";
        }
    }
}

// ⚠️ RENTAN: Deserialisasi input dari user tanpa validasi
$user_input = $_GET['prefs'] ?? base64_encode(serialize(new UserPreferences()));

echo "// ⚠️ RENTAN: Deserialisasi langsung dari input user<br>";
echo "\$data = <span style='color:#ff6b6b;'>unserialize</span>(base64_decode(\$_GET['prefs']));<br><br>";

echo "Input (base64): <code>{$user_input}</code><br><br>";

// ⚠️ RENTAN: unserialize() dengan data yang dikontrol user
$decoded = base64_decode($user_input);
echo "Decoded: <code>" . htmlspecialchars($decoded) . "</code><br>";

// Di production, ini akan menjalankan unserialize() — SANGAT BERBAHAYA!
// $prefs = unserialize($decoded); // ⚠️ JANGAN lakukan ini!
echo "<br><span style='color:#ff6b6b;'>// BAHAYA: unserialize() bisa memicu __wakeup(), __destruct(), dll.</span>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Cookie tanpa verifikasi integritas
echo "<h3>2. Cookie Tanpa Verifikasi Integritas ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Data role disimpan di cookie tanpa signature<br>";
echo "\$role = <span style='color:#ff6b6b;'>\$_COOKIE['user_role']</span>;<br><br>";
echo "// Penyerang bisa mengubah cookie:<br>";
echo "// user_role=user → <span style='color:#ff6b6b;'>user_role=admin</span><br>";
echo "// Tanpa verifikasi, server akan mempercayai nilai ini!<br><br>";

$fake_cookie = base64_encode(json_encode(['role' => 'admin', 'user_id' => 1]));
echo "Contoh cookie yang dimanipulasi:<br>";
echo "<code style='color:#ff6b6b;'>{$fake_cookie}</code>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Update tanpa verifikasi
echo "<h3>3. Software Update Tanpa Verifikasi ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Download update tanpa verifikasi checksum/signature<br>";
echo "\$update_url = 'http://updates.example.com/latest.zip'; // HTTP, bukan HTTPS!<br>";
echo "\$update_file = <span style='color:#ff6b6b;'>file_get_contents</span>(\$update_url);<br>";
echo "// Langsung extract tanpa verifikasi hash/signature!<br>";
echo "<span style='color:#ff6b6b;'>extract_zip</span>(\$update_file, '/var/www/html/');<br><br>";
echo "// Man-in-the-Middle bisa mengganti file update dengan malware!";
echo "</div>";

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>Insecure Deserialization:</strong> <code>unserialize()</code> pada data user bisa menyebabkan RCE.</li>";
echo "<li><strong>Cookie Tampering:</strong> Data di cookie bisa diubah tanpa terdeteksi.</li>";
echo "<li><strong>No Integrity Check:</strong> Software update tidak diverifikasi hash/signature-nya.</li>";
echo "<li><strong>Supply Chain Attack:</strong> Dependency bisa disusupi tanpa terdeteksi.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
