<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Injection yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A03:2021 — Injection
 * Solusi    : Prepared Statement (Parameterized Query)
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

echo "<h1>🟢 AMAN — SQL Injection (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Gunakan Prepared Statement / Parameterized Query.</p>";
echo "<hr>";

// Form pencarian
echo "<form method='GET' style='margin:20px 0;'>";
echo "<label><strong>Cari Produk:</strong></label><br>";
echo "<input type='text' name='search' placeholder='Ketik nama produk...' style='padding:10px;width:400px;font-size:16px;border:2px solid #51cf66;border-radius:5px;' value='" . htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#51cf66;color:black;border:none;border-radius:5px;cursor:pointer;font-size:16px;'>Cari</button>";
echo "</form>";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    
    // ✅ AMAN: Validasi input — batasi panjang
    if (strlen($search) > 100) {
        die("<p style='color:red;'>❌ Input terlalu panjang (maksimal 100 karakter).</p>");
    }
    
    // ✅ AMAN: Gunakan Prepared Statement
    $stmt = $conn->prepare("SELECT id, name, description, price, category FROM products WHERE name LIKE ? OR category LIKE ?");
    
    $search_param = "%{$search}%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;margin:10px 0;'>";
    echo "<strong>Query yang dieksekusi (Prepared Statement):</strong><br>";
    echo "<span style='color:#51cf66;'>SELECT * FROM products WHERE name LIKE ? OR category LIKE ?</span><br>";
    echo "Parameter: <span style='color:#4da6ff;'>[\"%" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "%\"]</span>";
    echo "</div>";
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse:collapse;margin:10px 0;'>";
        echo "<tr style='background:#333;color:white;'><th>ID</th><th>Nama</th><th>Deskripsi</th><th>Harga</th><th>Kategori</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            // ✅ AMAN: Output di-encode dengan htmlspecialchars
            echo "<td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
            echo "<td>" . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // ✅ AMAN: Pesan error generik, tidak menampilkan detail database
        echo "<p>Produk tidak ditemukan.</p>";
    }
    
    $stmt->close();
}

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Prepared Statement:</strong> Parameter terpisah dari query SQL — input tidak bisa mengubah struktur query.</li>";
echo "<li><strong>Input Validation:</strong> Validasi panjang dan tipe input sebelum diproses.</li>";
echo "<li><strong>Output Encoding:</strong> <code>htmlspecialchars()</code> mencegah XSS pada output.</li>";
echo "<li><strong>Error Handling:</strong> Pesan error generik, tidak menampilkan detail internal.</li>";
echo "<li><strong>Least Privilege:</strong> Gunakan database user dengan permission minimal (SELECT only).</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
