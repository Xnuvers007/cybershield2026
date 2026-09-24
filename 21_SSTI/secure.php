<?php
// secure.php - Versi aman
// Menghindari eval() dengan parsing logika statis yang sangat spesifik 
// ATAU cukup menampilkan input sebagai teks biasa tanpa memproses eksekusi dinamis.

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8') : 'Guest';

// AMAN: Tidak menggunakan eval(). 
// Jika ini adalah mesin template nyata (seperti Twig atau Smarty), 
// engine-engine modern sudah memisahkan antara teks, variabel, dan fungsi (tidak asal eval).
// Di sini kita hanya menampilkannya.

$template = "<h2>Selamat datang, $name!</h2>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>SSTI (SECURE)</title>
    <style>body { font-family: sans-serif; padding: 30px; background-color: #dcfce7; }</style>
</head>
<body>
    <h1 style="color: #166534">Sistem Profile dengan Template (Aman)</h1>
    <hr>
    <div>
        <?php echo $template; ?>
    </div>
    
    <hr>
    <h3>Coba payload yang sama:</h3>
    <ul>
        <li><a href="?name={{ 7 * 7 }}">Kalkulasi Matematika: ?name={{ 7 * 7 }}</a> (Gagal, hanya muncul sebagai teks)</li>
        <li><a href="?name={{ system('dir') }}">Eksekusi Sistem: ?name={{ system('dir') }}</a> (Gagal, di-escape)</li>
    </ul>
</body>
</html>
