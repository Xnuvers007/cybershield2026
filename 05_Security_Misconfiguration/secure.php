<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Security Misconfiguration yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A05:2021 — Security Misconfiguration
 * Solusi    : Hardening konfigurasi, security headers, proper error handling
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// ✅ AMAN: Matikan display error di production
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php/error.log'); // Log ke file, bukan ke layar

// ✅ AMAN: Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\'; style-src \'self\' \'unsafe-inline\';');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
// ✅ AMAN: Sembunyikan versi PHP
header_remove('X-Powered-By');

echo "<h1>🟢 AMAN — Security Misconfiguration (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Hardening konfigurasi server dan aplikasi.</p>";
echo "<hr>";

// ✅ AMAN: Kredensial dari environment variable
echo "<h3>1. Kredensial dari Environment Variable ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Kredensial dari environment variable<br>";
echo "\$db_host = <span style='color:#51cf66;'>getenv('DB_HOST')</span>;<br>";
echo "\$db_user = <span style='color:#51cf66;'>getenv('DB_USER')</span>; // Bukan 'root'<br>";
echo "\$db_pass = <span style='color:#51cf66;'>getenv('DB_PASS')</span>; // Password kuat<br>";
echo "\$db_name = <span style='color:#51cf66;'>getenv('DB_NAME')</span>;<br><br>";
echo "// ✅ Atau gunakan file .env (dengan .gitignore)<br>";
echo "// DB_HOST=localhost<br>";
echo "// DB_USER=app_user_readonly<br>";
echo "// DB_PASS=K7#mP9\$xL2!nQ8wR";
echo "</div>";

echo "<br>";

// ✅ AMAN: Error handling yang proper
echo "<h3>2. Error Handling yang Aman ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Custom error handler<br>";
echo "set_error_handler(function(\$errno, \$errstr, \$errfile, \$errline) {<br>";
echo "&nbsp;&nbsp;// Log detail error ke file (untuk developer)<br>";
echo "&nbsp;&nbsp;<span style='color:#51cf66;'>error_log</span>(\"[\$errno] \$errstr in \$errfile:\$errline\");<br>";
echo "&nbsp;&nbsp;// Tampilkan pesan generik ke user<br>";
echo "&nbsp;&nbsp;echo '<span style=\"color:#51cf66;\">Terjadi kesalahan. Silakan coba lagi.</span>';<br>";
echo "&nbsp;&nbsp;return true;<br>";
echo "});<br><br>";
echo "// ✅ Production: display_errors = Off<br>";
echo "// ✅ Production: log_errors = On<br>";
echo "// ✅ Production: error_log = /var/log/php/error.log";
echo "</div>";

echo "<br>";

// ✅ AMAN: Security headers
echo "<h3>3. Security Headers ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Security headers yang di-set oleh halaman ini:<br><br>";

$headers_set = [
    'X-Content-Type-Options: nosniff' => 'Cegah MIME-type sniffing',
    'X-Frame-Options: DENY' => 'Cegah clickjacking (iframe)',
    'X-XSS-Protection: 1; mode=block' => 'Aktifkan XSS filter browser',
    'Referrer-Policy: strict-origin-when-cross-origin' => 'Kontrol info referrer',
    'Content-Security-Policy: ...' => 'Cegah XSS, injection via CSP',
    'Strict-Transport-Security: ...' => 'Paksa HTTPS (HSTS)',
    'Permissions-Policy: ...' => 'Nonaktifkan fitur browser (camera, mic)',
];

foreach ($headers_set as $header => $desc) {
    echo "✅ <span style='color:#51cf66;'>{$header}</span><br>";
    echo "&nbsp;&nbsp;&nbsp;<span style='color:#aaa;'>→ {$desc}</span><br>";
}
echo "</div>";

echo "<br>";

// ✅ AMAN: PHP.ini hardening
echo "<h3>4. PHP.ini Hardening ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ Konfigurasi php.ini yang direkomendasikan:<br><br>";
echo "<span style='color:#51cf66;'>expose_php = Off</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Sembunyikan versi PHP<br>";
echo "<span style='color:#51cf66;'>display_errors = Off</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Jangan tampilkan error<br>";
echo "<span style='color:#51cf66;'>log_errors = On</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Log error ke file<br>";
echo "<span style='color:#51cf66;'>session.cookie_httponly = 1</span>&nbsp;&nbsp;# HttpOnly cookie<br>";
echo "<span style='color:#51cf66;'>session.cookie_secure = 1</span>&nbsp;&nbsp;&nbsp;# Cookie hanya via HTTPS<br>";
echo "<span style='color:#51cf66;'>session.use_strict_mode = 1</span>&nbsp;# Strict session mode<br>";
echo "<span style='color:#51cf66;'>allow_url_fopen = Off</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Nonaktifkan remote file<br>";
echo "<span style='color:#51cf66;'>allow_url_include = Off</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Nonaktifkan remote include<br>";
echo "<span style='color:#51cf66;'>disable_functions = exec,passthru,shell_exec,system,proc_open,popen</span>";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Disable Debug Mode:</strong> Matikan display_errors di production.</li>";
echo "<li><strong>Security Headers:</strong> Set semua security headers yang diperlukan.</li>";
echo "<li><strong>Environment Variables:</strong> Kredensial tidak di-hardcode.</li>";
echo "<li><strong>PHP Hardening:</strong> Konfigurasi php.ini yang aman.</li>";
echo "<li><strong>Remove Defaults:</strong> Hapus file default (phpinfo, readme, installer).</li>";
echo "<li><strong>Error Logging:</strong> Log error ke file, bukan ke layar.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
