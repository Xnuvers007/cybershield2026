<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Vulnerable Components yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A06:2021 — Vulnerable and Outdated Components
 * Solusi    : Dependency audit, version pinning, update policy
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🟢 AMAN — Vulnerable and Outdated Components (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Manajemen dependency yang aman dan proses audit rutin.</p>";
echo "<hr>";

// ✅ AMAN: Menggunakan versi terbaru yang di-maintain
echo "<h3>1. Dependency yang Up-to-date ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: composer.json dengan versi terbaru<br>";
echo "{<br>";
echo "&nbsp;&nbsp;\"require\": {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#51cf66;'>\"phpmailer/phpmailer\": \"^6.9\"</span>,&nbsp;&nbsp;&nbsp;// Versi terbaru<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#51cf66;'>\"symfony/http-kernel\": \"^7.1\"</span>,&nbsp;&nbsp;// LTS supported<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#51cf66;'>\"guzzlehttp/guzzle\": \"^7.9\"</span>,&nbsp;&nbsp;&nbsp;// Patched<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#51cf66;'>\"laravel/framework\": \"^11.0\"</span>&nbsp;&nbsp;&nbsp;// Active LTS<br>";
echo "&nbsp;&nbsp;},<br>";
echo "&nbsp;&nbsp;\"require-dev\": {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#51cf66;'>\"roave/security-advisories\": \"dev-latest\"</span> // Auto-block vulnerable packages<br>";
echo "&nbsp;&nbsp;}<br>";
echo "}";
echo "</div>";

echo "<br>";

// ✅ AMAN: Proses audit dependency
echo "<h3>2. Audit Dependency Rutin ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "# ✅ Jalankan audit secara rutin (mingguan / di CI/CD):<br><br>";
echo "<span style='color:#51cf66;'>composer audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Audit dependency PHP<br>";
echo "<span style='color:#51cf66;'>npm audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Audit dependency Node.js<br>";
echo "<span style='color:#51cf66;'>npm audit fix</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Auto-fix vulnerabilities<br>";
echo "<span style='color:#51cf66;'>pip-audit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Audit dependency Python<br>";
echo "<span style='color:#51cf66;'>snyk test</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Snyk vulnerability scanner<br><br>";
echo "# ✅ CI/CD Pipeline (GitHub Actions):<br>";
echo "- name: Security Audit<br>";
echo "&nbsp;&nbsp;run: |<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;composer audit --format=json<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;npm audit --audit-level=high<br>";
echo "</div>";

echo "<br>";

// ✅ AMAN: Contoh version check script
echo "<h3>3. Script Pengecekan Versi ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";

// Cek versi PHP
$php_version = phpversion();
$php_eol = version_compare($php_version, '8.1.0', '>=');
echo "PHP Version: <strong style='color:" . ($php_eol ? '#51cf66' : '#ff6b6b') . ";'>{$php_version}</strong> ";
echo $php_eol ? "✅ Supported" : "❌ EOL — Segera update!";
echo "<br><br>";

// Cek ekstensi keamanan
$required_extensions = ['openssl', 'mbstring', 'json', 'pdo'];
echo "Ekstensi keamanan:<br>";
foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo ($loaded ? "✅" : "❌") . " {$ext}: " . ($loaded ? "Loaded" : "NOT LOADED") . "<br>";
}
echo "</div>";

echo "<br>";

// ✅ AMAN: Frontend library terbaru
echo "<h3>4. Frontend Library Terbaru ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "&lt;!-- ✅ AMAN: Gunakan versi terbaru dengan SRI --&gt;<br>";
echo "&lt;script src=\"https://code.jquery.com/<span style='color:#51cf66;'>jquery-3.7.1.min.js</span>\"<br>";
echo "&nbsp;&nbsp;<span style='color:#51cf66;'>integrity=\"sha384-...\"</span>&nbsp;&nbsp;// Subresource Integrity<br>";
echo "&nbsp;&nbsp;<span style='color:#51cf66;'>crossorigin=\"anonymous\"</span>&gt;&lt;/script&gt;<br><br>";
echo "&lt;!-- ✅ Bootstrap terbaru --&gt;<br>";
echo "&lt;link rel=\"stylesheet\" href=\"<span style='color:#51cf66;'>bootstrap-5.3.3.css</span>\"<br>";
echo "&nbsp;&nbsp;<span style='color:#51cf66;'>integrity=\"sha384-...\"</span>&gt;";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Version Pinning:</strong> Pin versi dependency, gunakan caret (^) untuk minor updates.</li>";
echo "<li><strong>Dependency Audit:</strong> Jalankan <code>composer audit</code> / <code>npm audit</code> secara rutin.</li>";
echo "<li><strong>Automated Scanning:</strong> Gunakan Dependabot/Snyk di CI/CD pipeline.</li>";
echo "<li><strong>SRI (Subresource Integrity):</strong> Verifikasi integritas file CDN.</li>";
echo "<li><strong>Security Advisories Package:</strong> <code>roave/security-advisories</code> untuk auto-block.</li>";
echo "<li><strong>PHP Version Policy:</strong> Gunakan PHP versi yang masih di-support dan mendapat security patch.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
