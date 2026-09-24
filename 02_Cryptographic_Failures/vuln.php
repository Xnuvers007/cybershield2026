<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A02:2021 — Cryptographic Failures
 * Risiko    : CRITICAL
 * Deskripsi : Kode ini mendemonstrasikan kegagalan kriptografi:
 *             menyimpan password plaintext, hash lemah (MD5), 
 *             dan transmisi data sensitif tanpa enkripsi.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini di production!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🔴 RENTAN — Cryptographic Failures</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Sistem menyimpan password dalam bentuk tidak aman.</p>";
echo "<hr>";

// ⚠️ RENTAN: Menyimpan password dalam PLAINTEXT
$password_plaintext = "rahasia123";
echo "<h3>1. Password Plaintext (SANGAT BERBAHAYA)</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Password disimpan apa adanya<br>";
echo "\$password = <span style='color:#ff6b6b;'>\"rahasia123\"</span>;<br>";
echo "INSERT INTO users (password) VALUES (<span style='color:#ff6b6b;'>'{$password_plaintext}'</span>);<br><br>";
echo "Password tersimpan di DB: <strong style='color:#ff6b6b;'>{$password_plaintext}</strong>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Menggunakan MD5 untuk hash password
$password_md5 = md5("rahasia123");
echo "<h3>2. Hash MD5 (LEMAH — Mudah Di-crack)</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: MD5 sudah tidak aman untuk password<br>";
echo "\$hash = md5(<span style='color:#ff6b6b;'>\"rahasia123\"</span>);<br><br>";
echo "Hash MD5: <strong style='color:#ff6b6b;'>{$password_md5}</strong><br>";
echo "Bisa di-crack di: <a href='https://crackstation.net' style='color:#4da6ff;'>crackstation.net</a>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Menggunakan SHA1 tanpa salt
$password_sha1 = sha1("rahasia123");
echo "<h3>3. Hash SHA1 Tanpa Salt (LEMAH)</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: SHA1 tanpa salt mudah terkena rainbow table attack<br>";
echo "\$hash = sha1(<span style='color:#ff6b6b;'>\"rahasia123\"</span>);<br><br>";
echo "Hash SHA1: <strong style='color:#ff6b6b;'>{$password_sha1}</strong>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Enkripsi data sensitif dengan algoritma lemah
echo "<h3>4. Menyimpan Data Sensitif Tanpa Enkripsi</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
$nomor_ktp = "3275012345678901";
$nomor_kartu_kredit = "4532-1234-5678-9012";
echo "// ⚠️ RENTAN: Data sensitif disimpan tanpa enkripsi<br>";
echo "\$nomor_ktp = <span style='color:#ff6b6b;'>\"{$nomor_ktp}\"</span>;<br>";
echo "\$nomor_kartu = <span style='color:#ff6b6b;'>\"{$nomor_kartu_kredit}\"</span>;<br><br>";
echo "// Langsung masuk ke database tanpa enkripsi!<br>";
echo "INSERT INTO personal_data VALUES ('{$nomor_ktp}', '{$nomor_kartu_kredit}');";
echo "</div>";

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>Plaintext Password:</strong> Jika database bocor, semua password langsung terekspos.</li>";
echo "<li><strong>MD5/SHA1:</strong> Hash lemah, rentan terhadap rainbow table dan brute-force.</li>";
echo "<li><strong>Tanpa Salt:</strong> Password yang sama menghasilkan hash yang sama.</li>";
echo "<li><strong>Data Sensitif Tidak Terenkripsi:</strong> KTP dan kartu kredit tersimpan terbuka.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
