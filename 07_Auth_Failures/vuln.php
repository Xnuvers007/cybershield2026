<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A07:2021 — Identification and Authentication Failures
 * Risiko    : CRITICAL
 * Deskripsi : Kode ini mendemonstrasikan kegagalan autentikasi:
 *             session management lemah, tidak ada brute-force protection.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

session_start();

echo "<h1>🔴 RENTAN — Authentication Failures</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Form login tanpa proteksi brute-force dan session management lemah.</p>";
echo "<p><strong>Coba:</strong> Login dengan <code>admin</code> / <code>admin123</code> berkali-kali — tidak ada batasan!</p>";
echo "<hr>";

// Simulasi database users
$users = [
    'admin'  => 'admin123',    // ⚠️ Password lemah
    'user1'  => 'password',    // ⚠️ Password sangat lemah
    'test'   => '12345678',    // ⚠️ Password mudah ditebak
];

$login_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // ⚠️ RENTAN: Tidak ada rate limiting
    // ⚠️ RENTAN: Tidak ada CAPTCHA
    // ⚠️ RENTAN: Tidak ada account lockout
    
    if (isset($users[$username]) && $users[$username] === $password) {
        // ⚠️ RENTAN: Session ID tidak di-regenerate setelah login
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        
        // ⚠️ RENTAN: Session tidak ada expiry
        // ⚠️ RENTAN: Cookie tanpa Secure dan HttpOnly flag
        
        $login_message = "<div style='background:#51cf66;color:#000;padding:10px;border-radius:5px;'>
            ✅ Login berhasil! Selamat datang, <strong>{$username}</strong>.
            <br>Session ID: <code>" . session_id() . "</code>
            <br>⚠️ Session ID TIDAK di-regenerate setelah login (Session Fixation!)
        </div>";
    } else {
        // ⚠️ RENTAN: Memberitahu secara spesifik apakah username atau password yang salah
        if (!isset($users[$username])) {
            $login_message = "<p style='color:red;'>❌ Username <strong>'{$username}'</strong> tidak ditemukan!</p>";
        } else {
            $login_message = "<p style='color:red;'>❌ Password salah untuk user <strong>'{$username}'</strong>!</p>";
        }
    }
}

// ⚠️ Counter percobaan (tanpa batas)
$_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['login_attempts']++;
}

echo $login_message;

echo "<div style='background:#333;color:#fff;padding:10px;border-radius:5px;margin:10px 0;'>";
echo "Percobaan login: <strong style='color:#ff6b6b;'>{$_SESSION['login_attempts']}</strong> (Tidak ada batas!)";
echo "</div>";

echo "<form method='POST' style='margin:20px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>🔐 Login</h3>";
echo "<p><label>Username:</label><br>";
echo "<input type='text' name='username' placeholder='admin' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
echo "<p><label>Password:</label><br>";
echo "<input type='password' name='password' placeholder='admin123' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
echo "<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;'>Login</button>";
echo "</form>";

echo "<div style='background:rgba(255,255,255,0.05); border:1px solid #555; padding:15px; border-radius:8px; margin-bottom:20px;'>";
echo "<h4>💡 Hint Kredensial (Plaintext):</h4>";
echo "<ul style='color:#ccc;'>";
echo "<li>Username: <code>admin</code> | Password: <code>admin123</code></li>";
echo "<li>Username: <code>user1</code> | Password: <code>password</code></li>";
echo "<li>Username: <code>test</code> | Password: <code>12345678</code></li>";
echo "</ul>";
echo "<p style='font-size:0.8rem; color:#aaa;'>Pada sistem rentan, password seringkali disimpan dan dicocokkan langsung dalam bentuk teks asli (plaintext).</p>";
echo "</div>";

echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>Tidak ada Rate Limiting:</strong> Bisa brute-force tanpa batas.</li>";
echo "<li><strong>Password Lemah:</strong> Tidak ada kebijakan password minimum.</li>";
echo "<li><strong>User Enumeration:</strong> Pesan error berbeda untuk username/password salah.</li>";
echo "<li><strong>Session Fixation:</strong> Session ID tidak di-regenerate setelah login.</li>";
echo "<li><strong>No Account Lockout:</strong> Akun tidak pernah dikunci.</li>";
echo "<li><strong>No MFA:</strong> Tidak ada Multi-Factor Authentication.</li>";
echo "<li><strong>Insecure Cookie:</strong> Cookie tanpa HttpOnly dan Secure flag.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
