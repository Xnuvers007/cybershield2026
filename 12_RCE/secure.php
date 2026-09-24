<?php
/**
 * ✅ KODE AMAN — RCE (Remote Code Execution)
 * Solusi: Validasi ketat input (hanya izinkan format IP) dan gunakan escapeshellarg().
 */
echo "<h1>🟢 AMAN — Remote Code Execution (RCE)</h1><hr>";

echo "<form method='POST' style='margin:15px 0;'>";
echo "<input type='text' name='ip' placeholder='127.0.0.1' style='padding:8px;' value='" . htmlspecialchars($_POST['ip'] ?? '') . "'>";
echo "<button type='submit' style='padding:8px 15px;'>Ping</button>";
echo "</form>";

if (isset($_POST['ip'])) {
    $ip = $_POST['ip'];
    
    // ✅ AMAN 1: Validasi format IP (Regex)
    // Pastikan input HANYA berupa angka dan titik (format IP address)
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo "<div style='background:#ef4444; color:white; padding:15px; border-radius:5px;'>";
        echo "🚫 Format IP tidak valid! Deteksi injeksi perintah digagalkan.";
        echo "</div>";
    } else {
        // ✅ AMAN 2: Gunakan escapeshellarg() jika tetap harus ke OS
        // Mencegah penyerang keluar dari konteks argumen
        $safe_ip = escapeshellarg($ip);
        
        $cmd = "ping -n 1 " . $safe_ip;
        
        echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
        echo "<h3>Command yang dieksekusi: <code>$cmd</code> ✅</h3><hr>";
        
        echo "<pre style='color: #0f0;'>";
        echo htmlspecialchars(shell_exec($cmd));
        echo "</pre>";
        echo "</div>";
    }
}
echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
