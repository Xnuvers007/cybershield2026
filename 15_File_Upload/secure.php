<?php
/**
 * ✅ KODE AMAN — File Upload (Secure Implementation)
 * Solusi: Whitelist ekstensi, cek magic bytes (finfo), dan ubah nama file.
 */
echo "<h1>🟢 AMAN — Secure File Upload</h1><hr>";

$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px; margin-bottom:15px;'>";
    
    // ✅ AMAN 1: Ekstrak ekstensi dari nama file (pastikan formatnya benar)
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // ✅ AMAN 2: Whitelist ekstensi yang diizinkan (Hanya JPG dan PNG)
    $allowed_exts = ['jpg', 'jpeg', 'png'];
    
    if (!in_array($ext, $allowed_exts)) {
        echo "<span style='color:#ef4444;'>🚫 Ekstensi tidak valid! Harus .jpg atau .png.</span></div>";
    } else {
        // ✅ AMAN 3: Mengecek MIME type asli file berdasarkan kontennya (Magic Bytes), BUKAN dari HTTP Header
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $real_mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        echo "Ekstensi File: <strong>." . htmlspecialchars($ext) . "</strong><br>";
        echo "MIME Type Asli (Magic Bytes): <strong>" . htmlspecialchars($real_mime) . "</strong><br><br>";
        
        $allowed_mimes = ['image/jpeg', 'image/png'];
        
        if (!in_array($real_mime, $allowed_mimes)) {
            echo "<span style='color:#ef4444;'>🚫 File palsu (Polyglot/Yoya) terdeteksi! Konten file bukan gambar asli.</span></div>";
        } else {
            // ✅ AMAN 4: Ganti nama file dengan string acak (mencegah overwrite dan menyembunyikan file dari attacker)
            $new_name = bin2hex(random_bytes(16)) . '.' . $ext;
            $target_path = $upload_dir . $new_name;
            
            // ✅ AMAN 5: Pastikan file diupload dari mekanisme HTTP POST (mencegah eksploitasi path)
            if (is_uploaded_file($file['tmp_name']) && move_uploaded_file($file['tmp_name'], $target_path)) {
                echo "<span style='color:#10b981;'>✅ Upload sukses dan AMAN!</span><br>";
                echo "<br>File disimpan sebagai: <code>" . htmlspecialchars($new_name) . "</code><br>";
                echo "<br><a href='" . htmlspecialchars($target_path) . "' target='_blank' style='color:#06b6d4;'>Lihat Gambar</a>";
            } else {
                echo "<span style='color:orange;'>Gagal memproses file.</span>";
            }
            echo "</div>";
        }
    }
}
?>

<form method='POST' enctype='multipart/form-data' style='margin:15px 0; background:rgba(255,255,255,0.05); padding:20px; border-radius:8px;'>
    <h3>Upload Avatar Baru (Secure)</h3><br>
    <input type='file' name='avatar' required style='margin-bottom:15px;'><br>
    <button type='submit' style='padding:10px 20px; background:#10b981; color:white; border:none; border-radius:5px;'>Upload Aman</button>
</form>

<div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 15px; border-radius: 8px;">
    <h4>🛡️ Mekanisme Keamanan yang Digunakan:</h4>
    <ol>
        <li><strong>Whitelist Extension:</strong> Memaksa file memiliki ekstensi `.jpg` atau `.png`. File `.php` atau `.html` akan langsung ditolak.</li>
        <li><strong>Magic Bytes Inspection:</strong> Membaca konten asli file (header binernya) menggunakan <code>finfo</code> PHP, sehingga memalsukan `Content-Type` di Burp Suite tidak akan mempan.</li>
        <li><strong>File Renaming:</strong> File yang diupload diganti namanya menjadi hash acak, mencegah attacker mengetahui lokasi file berbahaya (seandainya lolos).</li>
    </ol>
</div>

<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>
