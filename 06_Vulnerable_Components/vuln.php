<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A06:2021 — Vulnerable and Outdated Components
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan penggunaan komponen/library
 *             yang usang dan memiliki kerentanan yang diketahui.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🔴 RENTAN — Vulnerable and Outdated Components</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Aplikasi menggunakan library/framework yang usang dan memiliki CVE.</p>";
echo "<hr>";

// ⚠️ RENTAN: Contoh penggunaan library versi lama dengan CVE
echo "<h3>1. Library dengan Kerentanan Diketahui (CVE) ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: composer.json dengan versi lama<br>";
echo "{<br>";
echo "&nbsp;&nbsp;\"require\": {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#ff6b6b;'>\"phpmailer/phpmailer\": \"5.2.21\"</span>,&nbsp;// CVE-2016-10033 (RCE!)<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#ff6b6b;'>\"symfony/http-kernel\": \"2.7.0\"</span>,&nbsp;&nbsp;// CVE-2019-10913<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#ff6b6b;'>\"guzzlehttp/guzzle\": \"6.3.0\"</span>,&nbsp;&nbsp;&nbsp;// CVE-2022-29248<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#ff6b6b;'>\"laravel/framework\": \"5.4.0\"</span>&nbsp;&nbsp;&nbsp;&nbsp;// End of Life!<br>";
echo "&nbsp;&nbsp;}<br>";
echo "}<br>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Menggunakan fungsi PHP yang deprecated
echo "<h3>2. Fungsi PHP yang Deprecated/Removed ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Fungsi yang sudah deprecated/dihapus<br><br>";
echo "<span style='color:#ff6b6b;'>mysql_connect()</span>; // Dihapus di PHP 7.0! Gunakan mysqli/PDO<br>";
echo "<span style='color:#ff6b6b;'>ereg()</span>;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Dihapus di PHP 7.0! Gunakan preg_match()<br>";
echo "<span style='color:#ff6b6b;'>mcrypt_encrypt()</span>;// Dihapus di PHP 7.2! Gunakan openssl<br>";
echo "<span style='color:#ff6b6b;'>create_function()</span>; // Deprecated PHP 7.2! Gunakan closure<br>";
echo "<span style='color:#ff6b6b;'>each()</span>;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Deprecated PHP 7.2! Gunakan foreach<br>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Tidak ada dependency scanning
echo "<h3>3. Tidak Ada Proses Audit Dependency ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Tidak pernah menjalankan audit keamanan<br><br>";
echo "# Ini TIDAK PERNAH dijalankan:<br>";
echo "<span style='color:#ff6b6b;'>composer audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Cek CVE di dependency PHP<br>";
echo "<span style='color:#ff6b6b;'>npm audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Cek CVE di dependency Node.js<br>";
echo "<span style='color:#ff6b6b;'>pip-audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Cek CVE di dependency Python<br><br>";
echo "// Versi PHP sendiri sudah End of Life!<br>";
echo "<span style='color:#ff6b6b;'>PHP 5.6</span> — EOL sejak Desember 2018 ❌<br>";
echo "<span style='color:#ff6b6b;'>PHP 7.0</span> — EOL sejak Desember 2018 ❌<br>";
echo "<span style='color:#ff6b6b;'>PHP 7.4</span> — EOL sejak November 2022 ❌<br>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Contoh menggunakan jQuery versi lama
echo "<h3>4. Frontend Library Usang ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "&lt;!-- ⚠️ RENTAN: jQuery versi lama dengan XSS vulnerability --&gt;<br>";
echo "&lt;script src=<span style='color:#ff6b6b;'>\"https://code.jquery.com/jquery-1.6.1.min.js\"</span>&gt;&lt;/script&gt;<br>";
echo "// CVE-2012-6708, CVE-2015-9251, CVE-2019-11358, CVE-2020-11022<br><br>";
echo "&lt;!-- ⚠️ Bootstrap versi lama --&gt;<br>";
echo "&lt;link rel=\"stylesheet\" href=<span style='color:#ff6b6b;'>\"bootstrap-3.3.5.css\"</span>&gt;<br>";
echo "// CVE-2018-14040, CVE-2019-8331<br>";
echo "</div>";

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>CVE Diketahui:</strong> Library memiliki kerentanan yang sudah dipublikasi (RCE, XSS, dll).</li>";
echo "<li><strong>End of Life:</strong> Versi PHP/framework sudah tidak mendapat security update.</li>";
echo "<li><strong>Deprecated Functions:</strong> Fungsi yang tidak aman masih digunakan.</li>";
echo "<li><strong>Tidak Ada Audit:</strong> Tidak ada proses rutin untuk memeriksa kerentanan dependency.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
