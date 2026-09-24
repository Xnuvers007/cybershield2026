<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — XSS yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : Bonus — Cross-Site Scripting (XSS)
 * Solusi    : htmlspecialchars(), Content-Security-Policy, input validation
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

// ✅ AMAN: Set Content-Security-Policy header
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

echo "<h1>🟢 AMAN — Cross-Site Scripting (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Output encoding, CSP header, input validation.</p>";
echo "<hr>";

// ========================================
// REFLECTED XSS — FIXED
// ========================================
echo "<h2>1. Reflected XSS — Fixed ✅</h2>";

echo "<form method='GET' style='margin:10px 0;'>";
echo "<input type='text' name='q' placeholder='Coba masukkan script...' style='padding:10px;width:400px;border:2px solid #51cf66;border-radius:5px;' value='" . htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;'>Cari</button>";
echo "</form>";

if (isset($_GET['q'])) {
    $search = $_GET['q'];
    
    // ✅ AMAN: Output di-encode dengan htmlspecialchars()
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;margin:10px 0;'>";
    echo "<p>Hasil pencarian untuk: <strong>" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "</strong></p>";
    echo "<p>✅ Input di-encode — script TIDAK akan dieksekusi!</p>";
    echo "<p style='font-size:12px;color:#aaa;'>Raw input: <code>" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "</div>";
}

echo "<br>";

// ========================================
// STORED XSS — FIXED
// ========================================
echo "<h2>2. Stored XSS — Fixed ✅</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $username = trim($_POST['username'] ?? 'Anonymous');
    $comment = trim($_POST['comment']);
    
    // ✅ AMAN: Validasi input
    if (strlen($username) > 50) {
        echo "<p style='color:red;'>❌ Username terlalu panjang (max 50 karakter).</p>";
    } elseif (strlen($comment) > 500) {
        echo "<p style='color:red;'>❌ Komentar terlalu panjang (max 500 karakter).</p>";
    } elseif (empty($comment)) {
        echo "<p style='color:red;'>❌ Komentar tidak boleh kosong.</p>";
    } else {
        // ✅ AMAN: Gunakan Prepared Statement
        if ($conn->ping()) {
            $stmt = $conn->prepare("INSERT INTO comments (username, comment) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $comment);
            $stmt->execute();
            $stmt->close();
            echo "<p style='color:green;'>✅ Komentar berhasil disimpan (dengan aman).</p>";
        }
    }
}

echo "<form method='POST' style='margin:10px 0;background:#1a1a2e;padding:20px;border-radius:8px;color:white;'>";
echo "<h3>💬 Tulis Komentar (Secure)</h3>";
echo "<p><input type='text' name='username' placeholder='Nama' maxlength='50' style='padding:8px;width:200px;border-radius:5px;border:1px solid #555;'></p>";
echo "<p><textarea name='comment' placeholder='Tulis komentar...' maxlength='500' style='padding:8px;width:400px;height:80px;border-radius:5px;border:1px solid #555;'></textarea></p>";
echo "<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;'>Kirim</button>";
echo "</form>";

// Tampilkan komentar
echo "<h3>📝 Komentar Tersimpan:</h3>";
if ($conn->ping()) {
    $stmt = $conn->prepare("SELECT username, comment, created_at FROM comments ORDER BY created_at DESC LIMIT 10");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // ✅ AMAN: Semua output di-encode dengan htmlspecialchars()
            echo "<div style='background:#2a2a3e;color:#eee;padding:10px;border-radius:5px;margin:5px 0;'>";
            echo "<strong>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</strong> ";
            echo "<small style='color:#aaa;'>" . htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') . "</small><br>";
            echo htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8');
            echo "</div>";
        }
    }
    $stmt->close();
} else {
    echo "<p style='color:orange;'>Database tidak tersedia. Contoh output aman:</p>";
    echo "<div style='background:#2a2a3e;color:#eee;padding:10px;border-radius:5px;margin:5px 0;'>";
    echo "<strong>User</strong> <small style='color:#aaa;'>2024-03-15</small><br>";
    echo htmlspecialchars("<script>alert('XSS!')</script>", ENT_QUOTES, 'UTF-8');
    echo "<br><em style='color:#51cf66;'>↑ Script ditampilkan sebagai teks, BUKAN dieksekusi ✅</em>";
    echo "</div>";
}

echo "<br>";

// Penjelasan teknik
echo "<h3>3. Content-Security-Policy (CSP) ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ Header CSP yang di-set oleh halaman ini:<br><br>";
echo "<span style='color:#51cf66;'>Content-Security-Policy:</span><br>";
echo "&nbsp;&nbsp;default-src 'self';&nbsp;&nbsp;&nbsp;&nbsp;// Hanya load resource dari domain sendiri<br>";
echo "&nbsp;&nbsp;script-src 'self';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Hanya jalankan script dari domain sendiri<br>";
echo "&nbsp;&nbsp;style-src 'self' 'unsafe-inline'; // Style dari domain sendiri<br>";
echo "&nbsp;&nbsp;img-src 'self' data:; // Gambar dari domain sendiri<br><br>";
echo "// Efek: Bahkan jika XSS berhasil di-inject,<br>";
echo "// browser MENOLAK menjalankan script dari sumber eksternal!";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan XSS:</h3>";
echo "<ol>";
echo "<li><strong>htmlspecialchars():</strong> Encode output — <code>&lt;</code> menjadi <code>&amp;lt;</code></li>";
echo "<li><strong>ENT_QUOTES + UTF-8:</strong> Encode juga tanda kutip dengan encoding yang benar.</li>";
echo "<li><strong>Content-Security-Policy:</strong> Browser menolak inline script dan script eksternal.</li>";
echo "<li><strong>Input Validation:</strong> Batasi panjang dan karakter yang diperbolehkan.</li>";
echo "<li><strong>Prepared Statement:</strong> Cegah SQL Injection saat menyimpan data.</li>";
echo "<li><strong>X-XSS-Protection:</strong> Aktifkan XSS filter bawaan browser.</li>";
echo "<li><strong>HttpOnly Cookie:</strong> Cookie tidak bisa diakses JavaScript (anti cookie theft).</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
