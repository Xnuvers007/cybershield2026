<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Data Integrity Failures yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A08:2021 — Software and Data Integrity Failures
 * Solusi    : JSON instead of serialize, HMAC verification, safe deserialization
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🟢 AMAN — Data Integrity Failures (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> HMAC verification, JSON serialization, integrity checks.</p>";
echo "<hr>";

// ✅ AMAN: Gunakan JSON bukan serialize/unserialize
echo "<h3>1. Gunakan JSON, Bukan unserialize() ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Gunakan json_encode/json_decode — tidak bisa trigger magic methods<br><br>";

$prefs = ['theme' => 'dark', 'language' => 'id', 'font_size' => 14];
$json = json_encode($prefs);
echo "\$prefs = ['theme' => 'dark', 'language' => 'id'];<br>";
echo "\$json = <span style='color:#51cf66;'>json_encode</span>(\$prefs);<br>";
echo "Output: <code style='color:#51cf66;'>{$json}</code><br><br>";

$decoded_prefs = json_decode($json, true);
echo "\$data = <span style='color:#51cf66;'>json_decode</span>(\$json, true);<br>";
echo "// JSON tidak bisa memicu __wakeup(), __destruct(), dll. ✅<br><br>";

echo "// Jika HARUS pakai unserialize, batasi class yang diizinkan:<br>";
echo "\$data = <span style='color:#51cf66;'>unserialize</span>(\$input, [<br>";
echo "&nbsp;&nbsp;'allowed_classes' => <span style='color:#51cf66;'>['UserPreferences']</span> // Whitelist<br>";
echo "]);";
echo "</div>";

echo "<br>";

// ✅ AMAN: Cookie dengan HMAC signature
echo "<h3>2. Cookie dengan HMAC Signature ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";

$secret_key = 'S3cr3t_K3y_Fr0m_3nv_V4r!'; // Di production: dari environment variable
$cookie_data = json_encode(['role' => 'user', 'user_id' => 2]);

// ✅ AMAN: Buat HMAC signature
$signature = hash_hmac('sha256', $cookie_data, $secret_key);
$signed_cookie = base64_encode($cookie_data) . '.' . $signature;

echo "// ✅ AMAN: Sign cookie data dengan HMAC-SHA256<br><br>";
echo "\$secret = getenv('COOKIE_SECRET');<br>";
echo "\$data = json_encode(['role' => 'user', 'user_id' => 2]);<br>";
echo "\$signature = <span style='color:#51cf66;'>hash_hmac</span>('sha256', \$data, \$secret);<br>";
echo "\$cookie = base64_encode(\$data) . '.' . \$signature;<br><br>";
echo "Signed Cookie: <code style='color:#51cf66;'>" . substr($signed_cookie, 0, 50) . "...</code><br><br>";

// ✅ AMAN: Verifikasi HMAC sebelum menggunakan data
echo "// ✅ Verifikasi sebelum menggunakan data:<br>";
$parts = explode('.', $signed_cookie);
$stored_data = base64_decode($parts[0]);
$stored_sig = $parts[1];
$expected_sig = hash_hmac('sha256', $stored_data, $secret_key);

$valid = hash_equals($expected_sig, $stored_sig); // Constant-time comparison
echo "\$valid = <span style='color:#51cf66;'>hash_equals</span>(\$expected_sig, \$stored_sig);<br>";
echo "Verifikasi: <strong style='color:#51cf66;'>" . ($valid ? "✅ VALID — Data tidak diubah" : "❌ INVALID") . "</strong><br><br>";

// ✅ Simulasi tampering
$tampered_data = json_encode(['role' => 'admin', 'user_id' => 1]);
$tampered_sig = hash_hmac('sha256', $tampered_data, 'wrong_key');
$tampered_valid = hash_equals($expected_sig, $tampered_sig);
echo "// Jika penyerang mengubah data:<br>";
echo "Tampered: <strong style='color:#ff6b6b;'>" . ($tampered_valid ? "✅ VALID" : "❌ DITOLAK — Signature tidak cocok!") . "</strong>";
echo "</div>";

echo "<br>";

// ✅ AMAN: Software update dengan integrity check
echo "<h3>3. Software Update dengan Integrity Check ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Verifikasi checksum sebelum install update<br><br>";
echo "// 1. Download update via HTTPS<br>";
echo "\$update = file_get_contents('<span style='color:#51cf66;'>https://</span>updates.example.com/v2.0.zip');<br><br>";
echo "// 2. Download checksum<br>";
echo "\$expected_hash = file_get_contents('https://updates.example.com/v2.0.sha256');<br><br>";
echo "// 3. Verifikasi hash<br>";
echo "\$actual_hash = <span style='color:#51cf66;'>hash</span>('sha256', \$update);<br>";
echo "if (<span style='color:#51cf66;'>hash_equals</span>(\$expected_hash, \$actual_hash)) {<br>";
echo "&nbsp;&nbsp;// ✅ Hash cocok — aman untuk install<br>";
echo "&nbsp;&nbsp;install_update(\$update);<br>";
echo "} else {<br>";
echo "&nbsp;&nbsp;// ❌ Hash tidak cocok — file mungkin diubah!<br>";
echo "&nbsp;&nbsp;log_security_alert('Update integrity check failed');<br>";
echo "&nbsp;&nbsp;abort();<br>";
echo "}";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>JSON Serialization:</strong> Gunakan JSON bukan PHP serialize (anti object injection).</li>";
echo "<li><strong>HMAC Signature:</strong> Tanda tangani data dengan HMAC-SHA256 untuk deteksi tampering.</li>";
echo "<li><strong>hash_equals():</strong> Constant-time comparison untuk anti timing attack.</li>";
echo "<li><strong>Checksum Verification:</strong> Verifikasi hash file sebelum instalasi.</li>";
echo "<li><strong>HTTPS:</strong> Download update via HTTPS untuk anti MITM.</li>";
echo "<li><strong>Allowed Classes:</strong> Jika harus pakai unserialize, whitelist class.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
