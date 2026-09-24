<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A03:2021 — Injection
 * Risiko    : CRITICAL
 * Deskripsi : Kode ini mendemonstrasikan SQL Injection dan Command Injection.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

echo "<h1>🔴 RENTAN — SQL Injection</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Form pencarian produk yang rentan terhadap SQL Injection.</p>";
echo "<p><strong>Coba masukkan:</strong></p>";
echo "<ul>";
echo "<li><code>' OR '1'='1</code> — Melihat semua data</li>";
echo "<li><code>' UNION SELECT 1,username,password,4,5 FROM users-- -</code> — Mencuri data user</li>";
echo "<li><code>'; DROP TABLE products;-- -</code> — Menghapus tabel (BAHAYA!)</li>";
echo "</ul>";
echo "<hr>";

// Form pencarian
echo "<form method='GET' style='margin:20px 0;'>";
echo "<label><strong>Cari Produk:</strong></label><br>";
echo "<input type='text' name='search' placeholder=\"Coba: ' OR '1'='1\" style='padding:10px;width:400px;font-size:16px;border:2px solid #ff6b6b;border-radius:5px;' value='" . ($_GET['search'] ?? '') . "'>";
echo "&nbsp;<button type='submit' style='padding:10px 20px;background:#ff6b6b;color:white;border:none;border-radius:5px;cursor:pointer;font-size:16px;'>Cari</button>";
echo "</form>";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    
    // ⚠️ RENTAN: Input user langsung dimasukkan ke query SQL tanpa sanitasi!
    $query = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
    
    echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;margin:10px 0;'>";
    echo "<strong>Query yang dieksekusi:</strong><br>";
    echo "<span style='color:#ff6b6b;'>{$query}</span>";
    echo "</div>";
    
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse:collapse;margin:10px 0;'>";
        echo "<tr style='background:#333;color:white;'>";
        
        // Tampilkan header kolom
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tidak ada hasil, atau terjadi error: " . $conn->error . "</p>";
    }
}

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>SQL Injection:</strong> Input user langsung di-concatenate ke query SQL.</li>";
echo "<li><strong>Data Leakage:</strong> Error message menampilkan detail database.</li>";
echo "<li><strong>UNION-based Attack:</strong> Penyerang bisa membaca tabel lain (users, password).</li>";
echo "<li><strong>Destructive Attack:</strong> Penyerang bisa DROP TABLE atau DELETE data.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
