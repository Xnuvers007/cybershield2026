<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : Zombie Cookies (Evercookie)
 * Risiko    : MEDIUM / PRIVACY
 * Deskripsi : Demonstrasi pelacakan persisten. Cookie biasa dihapus,
 *             namun di-respawn (dihidupkan kembali) via LocalStorage.
 * ============================================================================
 */
echo "<h1>🔴 RENTAN — Zombie Cookies (Tracking Persisten)</h1><hr>";

// Fungsi untuk men-generate UID jika belum ada
$uid = $_COOKIE['tracking_id'] ?? '';

echo "<p><strong>Skenario:</strong> Website secara agresif melacak pengunjung menggunakan metode berlapis (Cookie + LocalStorage).</p>";

if (isset($_POST['delete'])) {
    setcookie('tracking_id', '', time() - 3600, '/');
    $uid = '';
    echo "<p style='color:red;'>Cookie HTTP dihapus!</p>";
} elseif (isset($_POST['set'])) {
    $uid = 'USR-' . bin2hex(random_bytes(4));
    setcookie('tracking_id', $uid, time() + 86400, '/');
    echo "<p style='color:green;'>Cookie HTTP diset!</p>";
}

?>

<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>
    <h3>Status Pelacakan Saat Ini:</h3>
    <ul>
        <li>HTTP Cookie: <strong id="cookie-status"><?= htmlspecialchars($uid ?: 'Kosong') ?></strong></li>
        <li>LocalStorage: <strong id="ls-status">Kosong</strong></li>
    </ul>
    
    <hr style="border-color:#555; margin:15px 0;">
    <p>⚠️ <strong>Mekanisme Zombie:</strong> Jika Cookie HTTP dihapus tapi LocalStorage ada, JavaScript akan otomatis "menghidupkan" Cookie kembali!</p>
</div>

<form method='POST' style='margin:15px 0; display:inline-block;'>
    <button type='submit' name='set' style='padding:8px 15px;'>Set Tracking ID</button>
    <button type='submit' name='delete' style='padding:8px 15px; background:#ef4444; color:white; border:none;'>Hapus HTTP Cookie</button>
</form>
<button onclick="deleteLS()" style='padding:8px 15px; background:#f59e0b; color:white; border:none;'>Hapus LocalStorage</button>

<script>
    // Mekanisme Zombie / Evercookie sederhana
    const httpCookieVal = "<?= htmlspecialchars($uid) ?>";
    const lsVal = localStorage.getItem('tracking_id');
    
    document.getElementById('ls-status').innerText = lsVal || 'Kosong';
    
    // 1. Jika ada HTTP Cookie tapi tidak ada LS, simpan ke LS
    if (httpCookieVal && !lsVal) {
        localStorage.setItem('tracking_id', httpCookieVal);
        document.getElementById('ls-status').innerText = httpCookieVal;
    }
    
    // 2. ZOMBIE ACTION: Jika HTTP Cookie dihapus, tapi LS ada, BANGKITKAN Cookie!
    if (!httpCookieVal && lsVal) {
        alert('🧟 ZOMBIE COOKIE BANGKIT: Menulis ulang HTTP Cookie dari LocalStorage!');
        document.cookie = "tracking_id=" + lsVal + "; path=/; max-age=86400";
        // Reload halaman untuk menunjukkan cookie telah diset ulang
        setTimeout(() => window.location.reload(), 1000);
    }
    
    function deleteLS() {
        localStorage.removeItem('tracking_id');
        alert('LocalStorage tracking_id dihapus!');
        window.location.reload();
    }
</script>

<br><br><a href='secure.php'>➡️ Lihat versi AMAN</a>
