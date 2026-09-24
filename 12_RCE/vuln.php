<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : RCE (Remote Code Execution) / OS Command Injection
 * Risiko    : CRITICAL
 * Deskripsi : Penyerang bisa menyisipkan perintah sistem operasi yang akan
 *             dieksekusi oleh server web.
 * ============================================================================
 */
echo "<h1>🔴 RENTAN — Remote Code Execution (RCE)</h1><hr>";
echo "<p><strong>Skenario:</strong> Fitur 'Network Ping' untuk mengecek status IP server.</p>";
echo "<p>Coba payload ini (Windows): <code>127.0.0.1 & dir</code> atau <code>127.0.0.1 | whoami</code></p>";

echo "<form method='POST' style='margin:15px 0;'>";
echo "<input type='text' name='ip' placeholder='127.0.0.1' style='padding:8px;' value='" . htmlspecialchars($_POST['ip'] ?? '') . "'>";
echo "<button type='submit' style='padding:8px 15px;'>Ping</button>";
echo "</form>";

if (isset($_POST['ip'])) {
    $ip = $_POST['ip'];
    
    // ⚠️ RENTAN: Input user langsung disambung ke command OS tanpa sanitasi!
    // Penyerang bisa menyisipkan operator shell seperti &, &&, |, ||
    
    // Menggunakan ping -n 1 agar cepat selesai di Windows (atau -c 1 di Linux)
    $cmd = "ping -n 1 " . $ip;
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
    echo "<h3>Command yang dieksekusi: <code>$cmd</code></h3><hr>";
    
    echo "<pre style='color: #0f0;'>";
    // ⚠️ Eksekusi OS Command
    echo htmlspecialchars(shell_exec($cmd));
    echo "</pre>";
    echo "</div>";
}
echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
