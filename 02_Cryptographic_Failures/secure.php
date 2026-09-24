<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Cryptographic Failures yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A02:2021 — Cryptographic Failures
 * Solusi    : bcrypt, AES-256-GCM, proper key management
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🟢 AMAN — Cryptographic Failures (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Gunakan algoritma kriptografi yang kuat dan teruji.</p>";
echo "<hr>";

// ✅ AMAN: Gunakan password_hash() dengan bcrypt (auto-salt)
$password = "rahasia123";
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "<h3>1. Password Hashing dengan Bcrypt ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: password_hash() menggunakan bcrypt dengan auto-salt<br>";
echo "\$hashed = <span style='color:#51cf66;'>password_hash</span>(\$password, PASSWORD_BCRYPT, ['cost' => 12]);<br><br>";
echo "Hash Bcrypt: <strong style='color:#51cf66;'>{$hashed}</strong><br><br>";
echo "// ✅ Verifikasi password:<br>";
echo "\$valid = <span style='color:#51cf66;'>password_verify</span>(\$input, \$hashed); // true/false<br>";
$valid = password_verify($password, $hashed);
echo "Verifikasi: <strong style='color:#51cf66;'>" . ($valid ? "✅ COCOK" : "❌ TIDAK COCOK") . "</strong>";
echo "</div>";

echo "<br>";

// ✅ AMAN: Argon2id (lebih kuat dari bcrypt)
if (defined('PASSWORD_ARGON2ID')) {
    $hashed_argon = password_hash($password, PASSWORD_ARGON2ID);
    echo "<h3>2. Password Hashing dengan Argon2id ✅ (Lebih Kuat)</h3>";
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
    echo "// ✅ AMAN: Argon2id — pemenang Password Hashing Competition<br>";
    echo "\$hashed = <span style='color:#51cf66;'>password_hash</span>(\$password, PASSWORD_ARGON2ID);<br><br>";
    echo "Hash Argon2id: <strong style='color:#51cf66;'>{$hashed_argon}</strong>";
    echo "</div>";
    echo "<br>";
}

// ✅ AMAN: Enkripsi data sensitif dengan AES-256-GCM
echo "<h3>3. Enkripsi Data Sensitif dengan AES-256-GCM ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";

$encryption_key = random_bytes(32); // ✅ 256-bit key
$nomor_ktp = "3275012345678901";

// Enkripsi
$nonce = random_bytes(12); // ✅ Nonce unik untuk setiap enkripsi
$tag = '';
$encrypted = openssl_encrypt($nomor_ktp, 'aes-256-gcm', $encryption_key, OPENSSL_RAW_DATA, $nonce, $tag);
$stored = base64_encode($nonce . $tag . $encrypted);

echo "// ✅ AMAN: Enkripsi dengan AES-256-GCM<br>";
echo "\$key = <span style='color:#51cf66;'>random_bytes</span>(32);<br>";
echo "\$nonce = <span style='color:#51cf66;'>random_bytes</span>(12);<br>";
echo "\$encrypted = <span style='color:#51cf66;'>openssl_encrypt</span>(\$data, 'aes-256-gcm', \$key, ...);<br><br>";
echo "Data asli: <span style='color:#ff6b6b;'>{$nomor_ktp}</span><br>";
echo "Data terenkripsi: <strong style='color:#51cf66;'>{$stored}</strong><br><br>";

// Dekripsi
$decoded = base64_decode($stored);
$nonce_dec = substr($decoded, 0, 12);
$tag_dec = substr($decoded, 12, 16);
$ciphertext = substr($decoded, 28);
$decrypted = openssl_decrypt($ciphertext, 'aes-256-gcm', $encryption_key, OPENSSL_RAW_DATA, $nonce_dec, $tag_dec);

echo "Data didekripsi: <strong style='color:#51cf66;'>{$decrypted}</strong> ✅";
echo "</div>";

echo "<br>";

// ✅ AMAN: HTTPS enforcement
echo "<h3>4. Enforce HTTPS untuk Data in Transit ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Paksa redirect ke HTTPS<br>";
echo "if (!\$_SERVER['HTTPS'] || \$_SERVER['HTTPS'] === 'off') {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;header('Location: https://' . \$_SERVER['HTTP_HOST'] . \$_SERVER['REQUEST_URI']);<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;exit();<br>";
echo "}<br><br>";
echo "// ✅ AMAN: Set cookie dengan flag Secure<br>";
echo "<span style='color:#51cf66;'>setcookie</span>('session', \$token, [<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'secure' => true,&nbsp;&nbsp;// Hanya kirim lewat HTTPS<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'httponly' => true, // Tidak bisa diakses JavaScript<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'samesite' => 'Strict'<br>";
echo "]);";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Bcrypt/Argon2id:</strong> Algoritma hashing modern dengan auto-salt dan cost factor.</li>";
echo "<li><strong>AES-256-GCM:</strong> Enkripsi authenticated untuk data sensitif.</li>";
echo "<li><strong>Random Nonce:</strong> Nonce unik untuk setiap operasi enkripsi.</li>";
echo "<li><strong>HTTPS Enforcement:</strong> Enkripsi data saat transit.</li>";
echo "<li><strong>Secure Cookie Flags:</strong> HttpOnly, Secure, SameSite.</li>";
echo "<li><strong>Key Management:</strong> Gunakan environment variable, bukan hardcode.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
