<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — SSRF yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A10:2021 — Server-Side Request Forgery (SSRF)
 * Solusi    : URL whitelist, protocol filtering, IP validation
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🟢 AMAN — SSRF (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> URL whitelist, validasi protocol, blokir IP internal.</p>";
echo "<hr>";

// ✅ AMAN: Whitelist domain yang diperbolehkan
$allowed_domains = [
    'example.com',
    'api.github.com',
    'jsonplaceholder.typicode.com'
];

// ✅ AMAN: Hanya protocol yang aman
$allowed_protocols = ['http', 'https'];

// ✅ AMAN: Blokir IP ranges internal
function isInternalIP($ip) {
    // Blokir private IP ranges (RFC 1918)
    $internal_ranges = [
        '10.0.0.0/8',
        '172.16.0.0/12',
        '192.168.0.0/16',
        '127.0.0.0/8',       // Localhost
        '169.254.0.0/16',    // Link-local (AWS metadata)
        '0.0.0.0/8',         // Current network
        '::1/128',           // IPv6 localhost
    ];
    
    $ip_long = ip2long($ip);
    if ($ip_long === false) return true; // Block jika tidak valid
    
    foreach ($internal_ranges as $range) {
        list($subnet, $mask) = explode('/', $range);
        $subnet_long = ip2long($subnet);
        if ($subnet_long === false) continue;
        $mask_long = ~((1 << (32 - $mask)) - 1);
        if (($ip_long & $mask_long) === ($subnet_long & $mask_long)) {
            return true; // IP internal — BLOKIR
        }
    }
    return false;
}

// ✅ AMAN: Validasi URL
function validateURL($url, $allowed_domains, $allowed_protocols) {
    $parsed = parse_url($url);
    
    // Cek protocol
    if (!isset($parsed['scheme']) || !in_array(strtolower($parsed['scheme']), $allowed_protocols)) {
        return ['valid' => false, 'error' => 'Protocol tidak diizinkan. Hanya HTTP/HTTPS.'];
    }
    
    // Cek domain
    if (!isset($parsed['host'])) {
        return ['valid' => false, 'error' => 'URL tidak valid — tidak ada hostname.'];
    }
    
    $host = strtolower($parsed['host']);
    
    // Cek whitelist domain
    $domain_allowed = false;
    foreach ($allowed_domains as $domain) {
        if ($host === $domain || str_ends_with($host, '.' . $domain)) {
            $domain_allowed = true;
            break;
        }
    }
    if (!$domain_allowed) {
        return ['valid' => false, 'error' => "Domain '{$host}' tidak ada dalam whitelist."];
    }
    
    // Resolve DNS dan cek IP
    $ip = gethostbyname($host);
    if (isInternalIP($ip)) {
        return ['valid' => false, 'error' => "DNS resolves ke IP internal ({$ip}) — DIBLOKIR (anti DNS rebinding)."];
    }
    
    return ['valid' => true, 'error' => null];
}

echo "<form method='POST' style='margin:20px 0;'>";
echo "<label><strong>Masukkan URL untuk Preview:</strong></label><br>";
echo "<input type='text' name='url' placeholder='https://example.com' style='padding:10px;width:500px;font-size:16px;border:2px solid #51cf66;border-radius:5px;' value='" . htmlspecialchars($_POST['url'] ?? '') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;font-size:16px;'>Preview</button>";
echo "</form>";

echo "<div style='background:#333;color:#eee;padding:10px;border-radius:5px;margin:10px 0;font-size:14px;'>";
echo "Domain yang diizinkan: <code>" . implode('</code>, <code>', $allowed_domains) . "</code>";
echo "</div>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $url = trim($_POST['url']);
    
    // ✅ AMAN: Validasi URL
    $validation = validateURL($url, $allowed_domains, $allowed_protocols);
    
    if (!$validation['valid']) {
        echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;margin:10px 0;'>";
        echo "<h3>🚫 Request Ditolak</h3>";
        echo "<p>{$validation['error']}</p>";
        echo "</div>";
        
        // ✅ AMAN: Log percobaan SSRF
        error_log("[SECURITY] SSRF attempt blocked: {$url} from " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    } else {
        echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;margin:10px 0;'>";
        echo "<strong>URL valid ✅:</strong> <span style='color:#51cf66;'>{$url}</span>";
        echo "</div>";
        
        // ✅ AMAN: Gunakan cURL dengan konfigurasi aman
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_FOLLOWLOCATION => false, // ✅ Jangan ikuti redirect (bisa bypass whitelist)
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS, // ✅ Hanya HTTP/HTTPS
            CURLOPT_SSL_VERIFYPEER => true,  // ✅ Verifikasi SSL
        ]);
        
        $content = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($content !== false && $http_code === 200) {
            echo "<div style='background:#2a2a3e;color:#eee;padding:15px;border-radius:8px;margin:10px 0;'>";
            echo "<h3>📄 Response (HTTP {$http_code}):</h3>";
            echo "<pre style='white-space:pre-wrap;word-wrap:break-word;max-height:300px;overflow:auto;'>";
            echo htmlspecialchars(substr($content, 0, 2000));
            echo "</pre>";
            echo "</div>";
        }
    }
}

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Domain Whitelist:</strong> Hanya domain yang terdaftar yang boleh diakses.</li>";
echo "<li><strong>Protocol Restriction:</strong> Hanya HTTP/HTTPS (blokir file://, gopher://, dll).</li>";
echo "<li><strong>IP Validation:</strong> Blokir resolusi ke IP internal/private (anti DNS rebinding).</li>";
echo "<li><strong>No Redirect:</strong> Jangan ikuti redirect (bisa bypass whitelist).</li>";
echo "<li><strong>Timeout:</strong> Batasi waktu request (5 detik).</li>";
echo "<li><strong>SSL Verification:</strong> Verifikasi sertifikat SSL.</li>";
echo "<li><strong>Security Logging:</strong> Catat percobaan SSRF yang diblokir.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
