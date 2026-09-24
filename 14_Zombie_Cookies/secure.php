<?php
/**
 * ✅ KODE AMAN — Penanganan Privacy & Tracking
 * Solusi: Menghormati privasi user, menyediakan fitur 'Clear All Data'.
 */
echo "<h1>🟢 AMAN — Manajemen Privasi & Cookies</h1><hr>";

$uid = $_COOKIE['tracking_id'] ?? '';

if (isset($_POST['delete_all'])) {
    // ✅ AMAN: Hapus cookie dengan benar
    setcookie('tracking_id', '', time() - 3600, '/');
    $uid = '';
    $cleared = true;
} elseif (isset($_POST['set'])) {
    $uid = 'USR-' . bin2hex(random_bytes(4));
    // ✅ AMAN: Menggunakan atribut cookie yang aman (HttpOnly, SameSite)
    setcookie('tracking_id', $uid, [
        'expires' => time() + 86400,
        'path' => '/',
        'samesite' => 'Lax',
        'httponly' => false // Dibuat false agar JS bisa baca status di lab ini
    ]);
}

?>

<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>
    <h3>Status Pelacakan:</h3>
    <ul>
        <li>HTTP Cookie: <strong id="cookie-status"><?= htmlspecialchars($uid ?: 'Kosong') ?></strong></li>
        <li>LocalStorage: <strong id="ls-status">Kosong</strong></li>
    </ul>
    
    <hr style="border-color:#555; margin:15px 0;">
    <p>✅ <strong>Menghormati Privasi:</strong> Ketika user menekan 'Hapus Data', kita membersihkan SEMUA jejak baik di server (Cookie) maupun di sisi client (LocalStorage), dan tidak pernah memaksakan cookie untuk bangkit kembali secara diam-diam.</p>
</div>

<form method='POST' style='margin:15px 0;' id="trackingForm">
    <button type='submit' name='set' style='padding:8px 15px;'>Set Tracking ID</button>
    <!-- Tombol ini memicu form submit DAN pembersihan client-side -->
    <button type='button' onclick="clearAllData()" style='padding:8px 15px; background:#10b981; color:white; border:none;'>Hapus SEMUA Data Pelacakan</button>
    <input type="hidden" name="delete_all" id="deleteAllInput" value="0">
</form>

<script>
    const httpCookieVal = "<?= htmlspecialchars($uid) ?>";
    const lsVal = localStorage.getItem('tracking_id');
    
    document.getElementById('ls-status').innerText = lsVal || 'Kosong';
    
    // Sinkronisasi legal (BUKAN Zombie)
    if (httpCookieVal && !lsVal && "<?= isset($cleared) ? '1' : '0' ?>" === "0") {
        localStorage.setItem('tracking_id', httpCookieVal);
        document.getElementById('ls-status').innerText = httpCookieVal;
    }

    // Fungsi pembersihan total
    function clearAllData() {
        // 1. Bersihkan sisi client
        localStorage.removeItem('tracking_id');
        sessionStorage.clear();
        
        // 2. Beri tahu server untuk membersihkan cookie
        document.getElementById('deleteAllInput').value = "1";
        document.getElementById('trackingForm').submit();
    }
    
    <?php if (isset($cleared)): ?>
    alert('✅ Semua data pelacakan (Cookie & LocalStorage) telah bersih.');
    <?php endif; ?>
</script>

<br><br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>
