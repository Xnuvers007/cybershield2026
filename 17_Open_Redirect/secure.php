<?php
// Lab 17: Open Redirect (Secure)
// Skenario: 
// 1. GET Parameter diparsing secara ketat menggunakan parse_url()
// 2. Referer Header divalidasi atau menggunakan safe default
// 3. Host / X-Forwarded-Host tidak dipercaya, sistem selalu mengambil nilai SERVER_NAME statis dari env/config.

$url = $_GET['url'] ?? '';
$action = $_GET['action'] ?? '';
$whitelist_domain = 'luckysoraa.co-id.id'; // Domain whitelist Anda

// SCENARIO 2 PATCH: Referer Validasi
if ($action === 'logout') {
    $referer = $_SERVER['HTTP_REFERER'] ?? '/';
    
    // Jangan pernah langsung percaya HTTP_REFERER. Kita parse dulu.
    $parsed_referer = parse_url($referer);
    
    // Jika ada host, pastikan sama dengan domain kita.
    if (isset($parsed_referer['host']) && $parsed_referer['host'] !== $whitelist_domain) {
        // Jatuhkan ke default yang aman jika Referer dari luar
        $referer = 'index.php'; 
    }
    
    header("Location: $referer");
    exit;
}

// SCENARIO 3 PATCH: Jangan percaya Host/X-Forwarded-Host dinamis
if ($action === 'login') {
    // 🟢 AMAN: Gunakan konfigurasi statis, atau paksa HTTP_HOST bawaan web server 
    // (yang biasanya terikat ke ServerName di konfigurasi Apache/Nginx, bukan input user)
    // Jangan pernah gunakan X-Forwarded-Host kecuali sudah divalidasi oleh Load Balancer internal.
    
    $safe_host = $whitelist_domain; // Hardcoded configuration adalah praktik terbaik
    header("Location: https://$safe_host/dashboard");
    exit;
}

// SCENARIO 1 PATCH: GET Parameter Validasi Absolut
if (!empty($url)) {
    $parsed_url = parse_url($url);

    // Jika berupa URL Absolute (memiliki domain/host)
    if (isset($parsed_url['host'])) {
        if ($parsed_url['host'] === $whitelist_domain) {
            header("Location: $url");
            exit;
        }
    }
    // Jika berupa URL Relatif Lokal (contoh: /dashboard, bukan //evil.com)
    elseif (!isset($parsed_url['host']) && strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
        header("Location: $url");
        exit;
    }

    // Gagal verifikasi
    echo "<body style='background:#050505; color:#00FF41; font-family:monospace; padding:40px;'>";
    echo "<h3>[ BLOCKED ] </h3>";
    echo "<p>Keamanan aktif! Deteksi upaya Open Redirect ke domain yang tidak diizinkan.</p>";
    echo "</body>";
    exit;
}

// Halaman antarmuka utama
$html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lab 17 - Open Redirect (Secure)</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #050505; color: #00FF41; font-family: 'Fira Code', monospace; padding: 40px; }
        .terminal { border: 1px solid #00FF41; padding: 20px; box-shadow: 0 0 15px rgba(0,255,65,0.3); background: rgba(0,20,0,0.8); margin-bottom: 20px; }
        a { color: #39ff14; }
        h2 { color: #00FF41; text-transform: uppercase; margin-bottom: 10px; }
        h3 { color: #00FF41; margin-top: 15px; border-bottom: 1px dashed #00FF41; display: inline-block;}
        code { background: rgba(0,255,65,0.2); padding: 2px 6px; }
    </style>
</head>
<body>
    <div class="terminal">
        <h2>[✓] SECURE: OPEN REDIRECT PATCHED</h2>
        <p>> Seluruh skenario eksploitasi Open Redirect (GET, Referer, Host Injection) telah di-patch.</p>
        
        <h3>1. GET Parameter (?url=)</h3>
        <ul>
            <li><a href="?url=https://google.com%23luckysoraa.co-id.id">Uji Bypass 1 (Akan Diblokir)</a></li>
            <li><a href="?url=https://luckysoraa.co-id.id.evil.com">Uji Bypass 2 (Akan Diblokir)</a></li>
            <li><a href="?url=https://luckysoraa.co-id.id">Akses Valid (Diizinkan)</a></li>
        </ul>

        <h3>2. Referer Validation</h3>
        <p>Mencoba <a href="?action=logout">Logout</a> dengan injeksi Referer berbahaya sekarang akan mendeteksi Host pihak ketiga dan melakukan *fallback* aman ke halaman <code>index.php</code> lokal.</p>

        <h3>3. Host Header Hardcoding</h3>
        <p>Mencoba <a href="?action=login">Login</a> dengan header <code>X-Forwarded-Host: bing.com</code> akan diabaikan. Sistem sekarang menggunakan variabel statis <code>\$whitelist_domain</code> atau konfigurasi konstan dari file env.</p>
        
        <hr style="border: 1px dashed #00FF41; margin: 20px 0;">
        <h3>[!] MITIGASI BUG BOUNTY (Best Practices)</h3>
        <ul style="margin-left: 20px; color: #008F11; margin-top: 10px;">
            <li><strong>Selalu Ekstrak Host:</strong> Jangan pernah gunakan <code>strpos()</code>, selalu gunakan <code>parse_url()</code> untuk mengekstrak host asli.</li>
            <li><strong>Strict Equality (===):</strong> Pastikan host dicocokkan menggunakan <code>===</code> dengan *whitelist* Anda.</li>
            <li><strong>Jangan Percaya Header:</strong> Header <code>Host</code>, <code>X-Forwarded-Host</code>, dan <code>Referer</code> dikontrol sepenuhnya oleh *client*. Jangan pernah menggunakannya secara membabi-buta untuk membangun tautan pengalihan. Gunakan *absolute URL* dari variabel statis aplikasi Anda.</li>
        </ul>
    </div>
</body>
</html>
HTML;
echo $html;
?>
