<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : SQL Injection (Error, ORDER BY, UNION, DIOS)
 * Skenario  : Portal Berita
 * ============================================================================
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "<h1>📰 Portal Berita Cyber</h1>";
echo "<p>Pilih berita: <a href='?id=1'>Berita 1</a> | <a href='?id=2'>Berita 2</a> | <a href='?id=3'>Berita 3</a></p>";
echo "<hr>";

$id = $_GET['id'] ?? '1';

// ⚠️ RENTAN: Parameter tidak difilter dan ditaruh di dalam tanda kutip tunggal ('')
// Ini memungkinkan injeksi dengan cara menambahkan kutip (') untuk memanipulasi string SQL.
$query = "SELECT title, content, author FROM news WHERE id = '$id'";

// Menampilkan query di layar untuk mempermudah pemahaman saat lab
echo "<div style='background:#222;color:#0f0;padding:10px;font-family:monospace;margin-bottom:20px;border-radius:5px;'>";
echo "<strong>Query SQL Dieksekusi:</strong><br>" . htmlspecialchars($query);
echo "</div>";

// Eksekusi query
$result = $conn->query($query);

// Jika terjadi error pada SQL (misal karena kutip tidak ditutup), tampilkan errornya!
// Hal ini sangat disukai hacker karena memunculkan pesan "Error-based" SQLi.
if (!$result) {
    echo "<div style='background:#ffe6e6;color:#d32f2f;padding:15px;border-radius:5px;border-left:5px solid #d32f2f;'>";
    echo "<strong>🚨 MySQL Error:</strong> " . $conn->error;
    echo "</div>";
} else {
    // Jika query sukses, tampilkan hasilnya
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #ddd;padding:20px;margin-bottom:15px;border-radius:8px;box-shadow:2px 2px 8px rgba(0,0,0,0.1);'>";
            // Menampilkan data sesuai urutan kolom dari query (title, content, author)
            echo "<h2 style='margin-top:0;'>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p style='color:#777;font-style:italic;'>Ditulis oleh: " . htmlspecialchars($row['author']) . "</p>";
            echo "<p style='line-height:1.6;'>" . htmlspecialchars($row['content']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='color:gray;'>Berita tidak ditemukan.</p>";
    }
}

echo "<hr>";
echo "<div style='background:rgba(255,255,255,0.05); padding:15px; border-left:4px solid #f59e0b; margin-top:20px;'>";
echo "<strong>💡 HINT ALUR EKSPLOITASI:</strong><br>";
echo "1. <strong>Error:</strong> Tambahkan <code>'</code> di URL (contoh: <code>?id=1'</code>).<br>";
echo "2. <strong>Fix Syntax & Order By:</strong> Cari jumlah kolom (contoh: <code>?id=1' ORDER BY 3-- -</code> vs <code>?id=1' ORDER BY 4-- -</code>).<br>";
echo "3. <strong>UNION Select:</strong> Munculkan angka (contoh: <code>?id=-1' UNION SELECT 1,2,3-- -</code>).<br>";
echo "4. <strong>DIOS (Dump In One Shot):</strong> Gunakan <code>group_concat</code> pada tabel <code>information_schema.tables</code> untuk membocorkan semuanya! Coba temukan tabel rahasia dan isinya.<br>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a> | <a href='../index.php'>🏠 Kembali ke Portal</a>";
?>
