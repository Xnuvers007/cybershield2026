<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A04:2021 — Insecure Design
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan desain yang tidak aman:
 *             tidak ada rate limiting, business logic flaw.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

session_start();

echo "<h1>🔴 RENTAN — Insecure Design</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Fitur 'Lupa Password' tanpa rate limiting dan dengan pertanyaan keamanan yang lemah.</p>";
echo "<hr>";

// Simulasi database user
$users = [
    'admin' => [
        'password' => 'admin123',
        'security_question' => 'Apa nama hewan peliharaan Anda?',
        'security_answer' => 'kucing',  // ⚠️ Mudah ditebak
        'email' => 'admin@cybershield.lab'
    ]
];

// ⚠️ RENTAN: Tidak ada rate limiting pada form reset password
// ⚠️ RENTAN: Pertanyaan keamanan yang mudah ditebak/di-bruteforce
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $answer = $_POST['answer'] ?? '';
    
    if (isset($users[$username])) {
        // ⚠️ RENTAN: Case-insensitive comparison tanpa normalisasi
        if (strtolower($answer) === strtolower($users[$username]['security_answer'])) {
            // ⚠️ RENTAN: Langsung tampilkan password (seharusnya kirim reset link)
            echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;margin:10px 0;'>";
            echo "<h3>🔓 Password Ditemukan!</h3>";
            echo "<p>Password untuk <strong>{$username}</strong>: <code>{$users[$username]['password']}</code></p>";
            echo "<p>⚠️ Password langsung ditampilkan — SANGAT TIDAK AMAN!</p>";
            echo "</div>";
        } else {
            // ⚠️ RENTAN: Tidak ada lockout setelah banyak percobaan salah
            echo "<p style='color:red;'>❌ Jawaban salah. Silakan coba lagi.</p>";
            echo "<p style='color:orange;'>⚠️ Tidak ada batas percobaan — bisa brute-force!</p>";
        }
    } else {
        // ⚠️ RENTAN: Memberitahu bahwa username tidak ada (user enumeration)
        echo "<p style='color:red;'>❌ Username '{$username}' tidak ditemukan dalam sistem.</p>";
    }
}

// Tampilkan counter percobaan
$_SESSION['attempts'] = ($_SESSION['attempts'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['attempts']++;
}

echo "<div style='background:#333;color:#fff;padding:10px;border-radius:5px;margin:10px 0;'>";
echo "Percobaan ke: <strong style='color:#ff6b6b;'>{$_SESSION['attempts']}</strong> (Tidak ada batas!)";
echo "</div>";

echo "<form method='POST' style='margin:20px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>🔑 Reset Password</h3>";
echo "<p><label>Username:</label><br>";
echo "<input type='text' name='username' value='admin' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
echo "<p><label>Pertanyaan Keamanan: <em>\"Apa nama hewan peliharaan Anda?\"</em></label><br>";
echo "<input type='text' name='answer' placeholder='Coba: kucing, anjing, kelinci...' style='padding:8px;width:300px;border-radius:5px;border:1px solid #555;'></p>";
echo "<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;'>Reset Password</button>";
echo "</form>";

echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan Desain:</h3>";
echo "<ol>";
echo "<li><strong>Tidak ada Rate Limiting:</strong> Penyerang bisa mencoba jawaban berkali-kali tanpa batas.</li>";
echo "<li><strong>Security Question Lemah:</strong> Jawaban mudah ditebak (nama hewan = terbatas).</li>";
echo "<li><strong>Password Ditampilkan Langsung:</strong> Seharusnya kirim reset link ke email.</li>";
echo "<li><strong>User Enumeration:</strong> Sistem memberitahu apakah username ada atau tidak.</li>";
echo "<li><strong>Tidak ada Account Lockout:</strong> Akun tidak dikunci setelah banyak percobaan gagal.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
