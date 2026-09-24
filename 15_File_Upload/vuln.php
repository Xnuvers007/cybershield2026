<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : File Upload (MIME Manipulation / Binary Planting)
 * Risiko    : CRITICAL
 * Deskripsi : Mengizinkan upload file berbahaya dengan memanipulasi MIME type
 *             (Content-Type) yang dikirim oleh browser/proxy (misal: Burp).
 * ============================================================================
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RENTAN - File Upload</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #1e1e1e; color: #d4d4d4; padding: 20px; }
        a { color: #00f0ff; }
    </style>
</head>
<body>

<h1>🔴 RENTAN — Unrestricted File Upload (MIME Bypass)</h1><hr>
<p><strong>Skenario:</strong> Fitur upload avatar yang 'katanya' hanya menerima gambar JPEG.</p>
<?php

$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    // ⚠️ RENTAN: Hanya mengecek MIME type dari $_FILES['type']
    // Nilai ini diambil LANGSUNG dari header 'Content-Type' request HTTP.
    // Penyerang bisa mencegat request di Burp Suite dan mengubah 
    // Content-Type: text/html menjadi Content-Type: image/jpeg
    
    $mime_type = $file['type'];
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px; margin-bottom:15px;'>";
    echo "MIME Type yang terdeteksi (dari HTTP Header): <strong>" . htmlspecialchars($mime_type) . "</strong><br>";
    
    if ($mime_type === 'image/jpeg' || $mime_type === 'image/png') {
        // ⚠️ RENTAN: Tidak mengecek ekstensi asli file!
        // ⚠️ RENTAN: Tidak me-rename file!
        // Jika file bernama 'deface.html', ia akan disimpan sebagai 'deface.html'
        
        $target_path = $upload_dir . basename($file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            echo "<span style='color:#10b981;'>✅ Upload sukses! File diizinkan karena dianggap sebagai gambar.</span><br>";
            echo "<br>Lihat file Anda: <a href='" . htmlspecialchars($target_path) . "' target='_blank' style='color:#06b6d4;'>" . htmlspecialchars($target_path) . "</a>";
        } else {
            echo "<span style='color:orange;'>Gagal menyimpan file.</span>";
        }
    } else {
        echo "<span style='color:#ef4444;'>🚫 Upload Ditolak! Hanya file gambar (image/jpeg atau image/png) yang diizinkan!</span>";
    }
    echo "</div>";
}
?>

<form method='POST' enctype='multipart/form-data' style='margin:15px 0; background:rgba(255,255,255,0.05); padding:20px; border-radius:8px;'>
    <h3>Upload Avatar Baru</h3><br>
    <input type='file' name='avatar' required style='margin-bottom:15px;'><br>
    <button type='submit' style='padding:10px 20px; background:#ef4444; color:white; border:none; border-radius:5px;'>Upload</button>
</form>

<div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); padding: 15px; border-radius: 8px;">
    <h4>🛠️ Cara Eksploitasi (Defacement Demo):</h4>
    <ol>
        <li>Buat file HTML (misal <code>hacked.html</code>) dengan isi: <code>&lt;h1&gt;Hacked by XYZ&lt;/h1&gt;</code></li>
        <li>Coba upload file tersebut secara normal (Pasti akan ditolak karena MIME type-nya <code>text/html</code>).</li>
        <li>Gunakan <strong>Burp Suite</strong> untuk melakukan intercept saat proses upload.</li>
        <li>Cari baris <code>Content-Type: text/html</code> di request HTTP, dan ubah menjadi <code>Content-Type: image/jpeg</code>.</li>
        <li>Forward request. Sistem akan tertipu dan menyimpan file HTML Anda!</li>
        <li>Klik link file yang diupload, dan website akan menampilkan halaman deface.</li>
    </ol>
</div>

<br><a href='secure.php'>➡️ Lihat versi AMAN</a>

</body>
</html>
