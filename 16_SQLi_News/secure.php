<?php
/**
 * ============================================================================
 * 🟢 KODE AMAN (Fixed SQLi)
 * ============================================================================
 * Menggunakan Prepared Statements (Parameterized Queries)
 * ============================================================================
 */
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "<h1>📰 Portal Berita Cyber (Aman)</h1>";
echo "<p>Pilih berita: <a href='?id=1'>Berita 1</a> | <a href='?id=2'>Berita 2</a> | <a href='?id=3'>Berita 3</a></p>";
echo "<hr>";

$id = $_GET['id'] ?? '1';

// ✅ AMAN: Menggunakan tanda tanya (?) sebagai placeholder parameter
$query = "SELECT title, content, author FROM news WHERE id = ?";

// Siapkan statement (mencegah SQL Injection karena struktur dipisah dari data)
$stmt = $conn->prepare($query);

if ($stmt) {
    // Ikat (bind) parameter. 's' berarti string (bisa juga 'i' untuk integer).
    $stmt->bind_param("s", $id);
    
    // Eksekusi statement
    $stmt->execute();
    
    // Ambil hasil
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #4CAF50;padding:20px;margin-bottom:15px;border-radius:8px;box-shadow:2px 2px 8px rgba(76, 175, 80, 0.2);'>";
            echo "<h2 style='margin-top:0;'>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p style='color:#777;font-style:italic;'>Ditulis oleh: " . htmlspecialchars($row['author']) . "</p>";
            echo "<p style='line-height:1.6;'>" . htmlspecialchars($row['content']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='color:gray;'>Berita tidak ditemukan.</p>";
    }
    
    $stmt->close();
} else {
    echo "Gagal menyiapkan query.";
}

echo "<hr>";
echo "<p style='color:green;'>✔️ Coba masukkan kutip tunggal (<code>'</code>) atau payload UNION di versi ini. Struktur data sudah dipisahkan dari instruksi SQL sehingga injeksi akan dianggap sebagai teks biasa (string) dan bukan perintah.</p>";
echo "<br><a href='vuln.php'>⬅️ Kembali ke versi RENTAN</a> | <a href='../index.php'>🏠 Kembali ke Portal</a>";
?>
