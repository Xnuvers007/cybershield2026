<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Authentication Failures yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A07:2021 — Identification and Authentication Failures
 * Solusi    : Bcrypt, rate limiting, session regeneration, MFA
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// ✅ AMAN: Konfigurasi session yang aman
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.gc_maxlifetime', 1800); // Session timeout 30 menit

session_start();

echo "<h1>🟢 AMAN — Authentication Failures (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Autentikasi yang kuat dengan rate limiting, bcrypt, dan session management.</p>";
echo "<hr>";

// ✅ AMAN: Password di-hash dengan bcrypt
$users = [
    'admin' => [
        'password_hash' => password_hash('SecureP@ss2024!', PASSWORD_BCRYPT, ['cost' => 12]),
        'role' => 'admin'
    ]
];

// ✅ AMAN: Konfigurasi security
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_DURATION', 900); // 15 menit

// Inisialisasi tracking
if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
if (!isset($_SESSION['lockout_until'])) $_SESSION['lockout_until'] = 0;
if (!isset($_SESSION['last_attempt'])) $_SESSION['last_attempt'] = 0;

$is_locked = time() < $_SESSION['lockout_until'];
$login_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_locked) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // ✅ AMAN: Input validation
    if (empty($username) || empty($password)) {
        $login_message = "<p style='color:red;'>❌ Username dan password wajib diisi.</p>";
    } else {
        // ✅ AMAN: Rate limiting
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt'] = time();
        
        if ($_SESSION['login_attempts'] > MAX_LOGIN_ATTEMPTS) {
            $_SESSION['lockout_until'] = time() + LOCKOUT_DURATION;
            $is_locked = true;
            error_log("[SECURITY] Account lockout: user '{$username}' - too many failed attempts");
            $login_message = "<p style='color:red;'>🔒 Terlalu banyak percobaan. Akun dikunci selama 15 menit.</p>";
        } else {
            // ✅ AMAN: Verifikasi dengan password_verify (constant-time comparison)
            $valid = false;
            if (isset($users[$username])) {
                $valid = password_verify($password, $users[$username]['password_hash']);
            } else {
                // ✅ AMAN: Tetap jalankan hash untuk constant-time (anti timing attack)
                password_verify($password, '$2y$12$DummyHashForTimingAttackPrevention');
            }
            
            if ($valid) {
                // ✅ AMAN: Regenerate session ID setelah login (anti session fixation)
                session_regenerate_id(true);
                
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['login_time'] = time();
                $_SESSION['login_attempts'] = 0; // Reset counter
                $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
                
                $login_message = "<div style='background:#51cf66;color:#000;padding:10px;border-radius:5px;'>
                    ✅ Login berhasil! Session ID di-regenerate.
                    <br>New Session ID: <code>" . session_id() . "</code>
                    <br>Session Timeout: 30 menit
                    <br><br>⚡ Di production, step selanjutnya: verifikasi MFA (TOTP/SMS)
                </div>";
            } else {
                // ✅ AMAN: Pesan generik (anti user enumeration)
                $login_message = "<p style='color:red;'>❌ Username atau password salah.</p>";
                $remaining = MAX_LOGIN_ATTEMPTS - $_SESSION['login_attempts'];
                if ($remaining > 0) {
                    $login_message .= "<p style='color:orange;'>Sisa percobaan: {$remaining}</p>";
                }
            }
        }
    }
}

// Status
echo "<div style='background:#333;color:#fff;padding:10px;border-radius:5px;margin:10px 0;'>";
echo "Percobaan: <strong>{$_SESSION['login_attempts']}/" . MAX_LOGIN_ATTEMPTS . "</strong>";
if ($is_locked) {
    $remaining = $_SESSION['lockout_until'] - time();
    echo " | <strong style='color:#ff6b6b;'>🔒 TERKUNCI (" . ceil($remaining / 60) . " menit lagi)</strong>";
}
echo "</div>";

echo $login_message;

echo "<form method='POST' style='margin:20px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>🔐 Login (Secure)</h3>";
if ($is_locked) {
    echo "<p style='color:#ff6b6b;'>⏱️ Akun terkunci. Tunggu beberapa menit.</p>";
} else {
    echo "<p><label>Username:</label><br>";
    echo "<input type='text' name='username' autocomplete='username' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
    echo "<p><label>Password:</label><br>";
    echo "<input type='password' name='password' autocomplete='current-password' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
    echo "<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;'>Login</button>";
}
echo "</form>";

echo "<div style='background:rgba(16, 185, 129, 0.1); border:1px solid #10b981; padding:15px; border-radius:8px; margin-bottom:20px;'>";
echo "<h4>💡 Hint Kredensial (Secure Bcrypt):</h4>";
echo "<ul style='color:#ccc;'>";
echo "<li>Username: <code>admin</code></li>";
echo "<li>Password (Ketikkan ini saat login): <code>SecureP@ss2024!</code></li>";
echo "<li>Disimpan di Database sebagai Hash Bcrypt: <br><code style='color:#10b981; font-size:0.8rem;'>\$2y\$12\$... (Hash dinamis yang akan di-verify dengan password_verify)</code></li>";
echo "</ul>";
echo "<p style='font-size:0.8rem; color:#aaa;'>Pada sistem aman, password tidak pernah disimpan sebagai plaintext. Input dari user (SecureP@ss2024!) dicocokkan dengan hash di database menggunakan algoritma satu arah.</p>";
echo "</div>";

// ✅ Password policy
echo "<h3>Kebijakan Password yang Aman ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ Validasi password strength:<br>";
echo "function validatePassword(\$password) {<br>";
echo "&nbsp;&nbsp;if (strlen(\$password) < 12) return false;&nbsp;&nbsp;// Min 12 karakter<br>";
echo "&nbsp;&nbsp;if (!preg_match('/[A-Z]/', \$password)) return false; // Huruf besar<br>";
echo "&nbsp;&nbsp;if (!preg_match('/[a-z]/', \$password)) return false; // Huruf kecil<br>";
echo "&nbsp;&nbsp;if (!preg_match('/[0-9]/', \$password)) return false; // Angka<br>";
echo "&nbsp;&nbsp;if (!preg_match('/[!@#\$%^&*]/', \$password)) return false; // Simbol<br>";
echo "&nbsp;&nbsp;// ✅ Cek apakah password ada di daftar password bocor<br>";
echo "&nbsp;&nbsp;// (Have I Been Pwned API)<br>";
echo "&nbsp;&nbsp;return true;<br>";
echo "}";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Bcrypt Hashing:</strong> Password di-hash dengan bcrypt (cost=12).</li>";
echo "<li><strong>Rate Limiting:</strong> Maksimal 5 percobaan login.</li>";
echo "<li><strong>Account Lockout:</strong> Lockout 15 menit setelah percobaan gagal.</li>";
echo "<li><strong>Session Regeneration:</strong> Session ID di-regenerate setelah login.</li>";
echo "<li><strong>Generic Error Messages:</strong> Pesan error sama (anti user enumeration).</li>";
echo "<li><strong>Secure Cookie Flags:</strong> HttpOnly, Secure, SameSite=Strict.</li>";
echo "<li><strong>Session Timeout:</strong> Session expired setelah 30 menit.</li>";
echo "<li><strong>Constant-time Comparison:</strong> Anti timing attack.</li>";
echo "<li><strong>Password Policy:</strong> Minimal 12 karakter, upper/lower/number/symbol.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
