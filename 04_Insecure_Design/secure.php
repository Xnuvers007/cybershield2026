<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Insecure Design yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A04:2021 — Insecure Design
 * Solusi    : Rate limiting, token-based reset, account lockout
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

session_start();

echo "<h1>🟢 AMAN — Insecure Design (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Rate limiting, token-based reset, dan account lockout.</p>";
echo "<hr>";

// ✅ AMAN: Konfigurasi keamanan
define('MAX_ATTEMPTS', 3);           // Maksimal 3 percobaan
define('LOCKOUT_DURATION', 900);     // Lockout 15 menit (900 detik)
define('TOKEN_EXPIRY', 3600);        // Token reset berlaku 1 jam

// Inisialisasi session untuk tracking
if (!isset($_SESSION['reset_attempts'])) {
    $_SESSION['reset_attempts'] = 0;
    $_SESSION['lockout_until'] = 0;
}

// ✅ AMAN: Cek apakah sedang dalam lockout
$is_locked = time() < $_SESSION['lockout_until'];
$remaining_lockout = $is_locked ? $_SESSION['lockout_until'] - time() : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_locked) {
    $username = $_POST['username'] ?? '';
    
    // ✅ AMAN: Rate limiting — cek jumlah percobaan
    $_SESSION['reset_attempts']++;
    
    if ($_SESSION['reset_attempts'] > MAX_ATTEMPTS) {
        // ✅ AMAN: Lockout akun setelah terlalu banyak percobaan
        $_SESSION['lockout_until'] = time() + LOCKOUT_DURATION;
        $is_locked = true;
        $remaining_lockout = LOCKOUT_DURATION;
        
        // ✅ AMAN: Log aktivitas mencurigakan
        error_log("[SECURITY] Reset password lockout triggered for session " . session_id());
    } else {
        // ✅ AMAN: Generate token reset (bukan tampilkan password!)
        $reset_token = bin2hex(random_bytes(32));
        $reset_expiry = time() + TOKEN_EXPIRY;
        
        // ✅ AMAN: Pesan generik — tidak mengungkap apakah username ada atau tidak
        echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;margin:10px 0;'>";
        echo "<h3>📧 Email Reset Telah Dikirim</h3>";
        echo "<p>Jika username terdaftar, kami telah mengirim link reset password ke email yang terkait.</p>";
        echo "<p>Link reset berlaku selama <strong>1 jam</strong>.</p>";
        echo "<p style='font-family:monospace;background:#1a1a2e;color:#eee;padding:10px;border-radius:5px;'>";
        echo "Token: {$reset_token}<br>Expires: " . date('Y-m-d H:i:s', $reset_expiry);
        echo "</p>";
        echo "<p><em>Catatan: Di production, token ini dikirim via email, BUKAN ditampilkan!</em></p>";
        echo "</div>";
    }
}

// Status
echo "<div style='background:#333;color:#fff;padding:10px;border-radius:5px;margin:10px 0;'>";
echo "Percobaan: <strong>" . min($_SESSION['reset_attempts'], MAX_ATTEMPTS) . "/{MAX_ATTEMPTS}</strong>";
if ($is_locked) {
    echo " | <strong style='color:#ff6b6b;'>🔒 TERKUNCI — Tunggu " . ceil($remaining_lockout / 60) . " menit</strong>";
}
echo "</div>";

echo "<form method='POST' style='margin:20px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>🔑 Reset Password (Secure)</h3>";

if ($is_locked) {
    echo "<p style='color:#ff6b6b;'>⏱️ Akun terkunci. Silakan tunggu " . ceil($remaining_lockout / 60) . " menit sebelum mencoba lagi.</p>";
    echo "<button type='submit' disabled style='padding:10px 20px;background:#666;color:#999;border:none;border-radius:5px;cursor:not-allowed;'>Terkunci</button>";
} else {
    echo "<p><label>Username atau Email:</label><br>";
    echo "<input type='text' name='username' placeholder='Masukkan username atau email' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
    echo "<p style='font-size:12px;color:#aaa;'>✅ Link reset akan dikirim ke email terdaftar (tidak menggunakan security question)</p>";
    echo "<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;'>Kirim Link Reset</button>";
}
echo "</form>";

echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Rate Limiting:</strong> Maksimal 3 percobaan sebelum lockout 15 menit.</li>";
echo "<li><strong>Token-based Reset:</strong> Kirim link reset via email, bukan tampilkan password.</li>";
echo "<li><strong>Cryptographic Token:</strong> Token acak 64 karakter hex (256-bit) yang sulit ditebak.</li>";
echo "<li><strong>Token Expiry:</strong> Token berlaku 1 jam, setelah itu tidak bisa digunakan.</li>";
echo "<li><strong>Generic Response:</strong> Respons sama baik username ada maupun tidak (anti user enumeration).</li>";
echo "<li><strong>Account Lockout:</strong> Akun dikunci setelah terlalu banyak percobaan gagal.</li>";
echo "<li><strong>Security Logging:</strong> Aktivitas mencurigakan dicatat ke log.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
echo "&nbsp;|&nbsp;";
echo "<a href='secure.php'>🔄 Reset Session</a> (buka di incognito/private window)";
?>
