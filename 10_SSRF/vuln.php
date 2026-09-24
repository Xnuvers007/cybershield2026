<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A10:2021 — Server-Side Request Forgery (SSRF)
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan SSRF dimana penyerang bisa
 *             membuat server melakukan request ke resource internal.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🔴 RENTAN — Server-Side Request Forgery (SSRF)</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Fitur 'URL Preview' yang mengambil konten dari URL yang diberikan user.</p>";
echo "<p><strong>Coba masukkan:</strong></p>";
echo "<ul>";
echo "<li><code>http://127.0.0.1/server-status</code> — Akses info server internal</li>";
echo "<li><code>http://169.254.169.254/latest/meta-data/</code> — AWS metadata (cloud)</li>";
echo "<li><code>file:///etc/passwd</code> — Baca file lokal server</li>";
echo "<li><code>http://192.168.1.1/admin</code> — Akses router internal</li>";
echo "</ul>";
echo "<hr>";

// Form input URL
echo "<form method='POST' style='margin:20px 0;'>";
echo "<label><strong>Masukkan URL untuk Preview:</strong></label><br>";
echo "<input type='text' name='url' placeholder='http://example.com' style='padding:10px;width:500px;font-size:16px;border:2px solid #ff6b6b;border-radius:5px;' value='" . htmlspecialchars($_POST['url'] ?? '') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;font-size:16px;'>Preview</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $url = $_POST['url'];
    
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;margin:10px 0;'>";
    echo "<strong>URL yang diminta server:</strong><br>";
    echo "<span style='color:#ff6b6b;'>{$url}</span>";
    echo "</div>";
    
    // ⚠️ RENTAN: Server mengambil URL apa pun yang diberikan user
    // Tidak ada validasi, filtering, atau whitelist
    $context = stream_context_create([
        'http' => ['timeout' => 5],
        'ssl' => ['verify_peer' => false] // ⚠️ RENTAN: SSL verification dimatikan
    ]);
    
    $content = @file_get_contents($url, false, $context);
    
    if ($content !== false) {
        echo "<div style='background:#2a2a3e;color:#eee;padding:15px;border-radius:8px;margin:10px 0;'>";
        echo "<h3>📄 Response dari Server:</h3>";
        echo "<pre style='white-space:pre-wrap;word-wrap:break-word;max-height:300px;overflow:auto;'>";
        echo htmlspecialchars(substr($content, 0, 2000)); // Tampilkan 2000 karakter pertama
        echo "</pre>";
        echo "</div>";
    } else {
        echo "<p style='color:orange;'>Tidak bisa mengambil konten dari URL tersebut.</p>";
    }
}

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan SSRF:</h3>";
echo "<ol>";
echo "<li><strong>Internal Network Scan:</strong> Penyerang bisa memindai jaringan internal melalui server.</li>";
echo "<li><strong>Cloud Metadata:</strong> Di AWS/GCP, bisa membaca IAM credentials, API keys.</li>";
echo "<li><strong>File Read:</strong> Bisa membaca file lokal menggunakan <code>file://</code> protocol.</li>";
echo "<li><strong>Port Scanning:</strong> Server dijadikan proxy untuk scanning port internal.</li>";
echo "<li><strong>Bypass Firewall:</strong> Request dari server dianggap 'trusted' oleh firewall internal.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
