<?php
/**
 * ✅ KODE AMAN — LFI (Local File Inclusion)
 * Solusi: Whitelist file yang diizinkan atau gunakan basename().
 */
echo "<h1>🟢 AMAN — Local File Inclusion (LFI)</h1><hr>";

// File dummy yang diizinkan
file_put_contents('about.txt', 'Ini adalah halaman tentang kami.');
file_put_contents('contact.txt', 'Hubungi kami di admin@cybershield.lab');

echo "<p>Hanya bisa memuat file yang diizinkan (about, contact).</p>";
echo "<form method='GET' style='margin:15px 0;'>";
echo "<input type='text' name='page' placeholder='about' style='padding:8px;' value='" . htmlspecialchars($_GET['page'] ?? '') . "'>";
echo "<button type='submit' style='padding:8px 15px;'>Load Page</button>";
echo "</form>";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // ✅ AMAN: Menggunakan Whitelist
    $allowed_pages = ['about', 'contact'];
    
    if (in_array($page, $allowed_pages)) {
        // ✅ AMAN: Menambahkan ekstensi secara hardcode dan mencegah direktori traversal
        $file = basename($page) . '.txt';
        
        echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
        echo "<h3>Memuat: " . htmlspecialchars($file) . " ✅</h3><hr>";
        
        $content = @file_get_contents($file);
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
        echo "</div>";
    } else {
        echo "<div style='background:#ef4444; color:white; padding:15px; border-radius:5px;'>";
        echo "🚫 Akses ditolak! Halaman tidak valid.";
        echo "</div>";
    }
}
echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
