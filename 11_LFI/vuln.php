<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : LFI (Local File Inclusion)
 * Risiko    : HIGH / CRITICAL
 * Deskripsi : Penyerang bisa membaca file sistem atau mengeksekusi kode
 *             lokal di server.
 * ============================================================================
 */
echo "<h1>🔴 RENTAN — Local File Inclusion (LFI)</h1><hr>";
echo "<p><strong>Skenario:</strong> Website memuat halaman (template) berdasarkan parameter URL <code>?page=...</code></p>";

// File dummy rahasia
file_put_contents('secret.txt', 'Ini adalah file rahasia yang tidak boleh dibaca publik! Password admin: admin123');

echo "<p>Coba akses: <code>?page=secret.txt</code> atau <code>?page=../../../../Windows/win.ini</code> (tergantung sistem operasi)</p>";

echo "<form method='GET' style='margin:15px 0;'>";
echo "<input type='text' name='page' placeholder='about.txt' style='padding:8px;' value='" . htmlspecialchars($_GET['page'] ?? '') . "'>";
echo "<button type='submit' style='padding:8px 15px;'>Load Page</button>";
echo "</form>";

if (isset($_GET['page'])) {
    $file = $_GET['page'];
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
    echo "<h3>Memuat file: $file</h3>";
    echo "<hr>";
    
    // ⚠️ RENTAN: Parameter dari user langsung di-include atau dibaca!
    // Untuk keamanan laptop Anda, kami batasi agar tidak sampai crash, 
    // namun secara konsep LFI ini sangat berbahaya.
    
    if (file_exists($file)) {
        // Pada LFI asli, biasanya pakai include($file) sehingga kalau file berisi PHP, akan tereksekusi.
        // Di sini kita pakai file_get_contents untuk demonstrasi baca file.
        $content = @file_get_contents($file);
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    } else {
        echo "<p style='color:red;'>File tidak ditemukan.</p>";
    }
    echo "</div>";
}
echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
