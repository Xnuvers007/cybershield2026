<?php
// vuln.php - Server-Side Template Injection (SSTI) di PHP
// Mensimulasikan template engine yang menggunakan eval() untuk memproses tag {{ }}
// yang mana sangat rentan.

$name = isset($_GET['name']) ? $_GET['name'] : 'Guest';

// Template yang diberikan oleh user (Misalnya diambil dari DB atau input)
$template = "<h2>Selamat datang, $name!</h2>";
$template .= "<p>Sistem Template Kustom: Gunakan <code>&#123;&#123; kalkulasi &#125;&#125;</code> untuk kalkulasi matematika.</p>";

// Mensimulasikan parser template sederhana yang rentan
if (preg_match_all('/\{\{(.+?)\}\}/', $template, $matches)) {
    foreach($matches[1] as $match) {
        // RENTAN: Mengeksekusi string di dalam {{ }} sebagai kode PHP langsung!
        // Coba payload: ?name={{ system('whoami') }} atau ?name={{ phpinfo() }}
        try {
            $evaluated = eval("return $match;");
            $template = str_replace('{{'.$match.'}}', $evaluated, $template);
        } catch (Throwable $e) {
            $template = str_replace('{{'.$match.'}}', "[Error: " . $e->getMessage() . "]", $template);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SSTI (VULN)</title>
    <style>body { font-family: sans-serif; padding: 30px; }</style>
</head>
<body>
    <h1>Sistem Profile dengan Template</h1>
    <hr>
    <div>
        <?php echo $template; ?>
    </div>
    
    <hr>
    <h3>Coba masukkan nama Anda di URL:</h3>
    <ul>
        <li><a href="?name=Budi">?name=Budi</a></li>
        <li><a href="?name={{ 7 * 7 }}">Kalkulasi Matematika: ?name={{ 7 * 7 }}</a></li>
        <li><a href="?name={{ system('dir') }}">Eksekusi Sistem: ?name={{ system('dir') }}</a> (Payload SSTI)</li>
        <li><a href="?name={{ phpinfo() }}">Melihat PHP Info: ?name={{ phpinfo() }}</a> (Payload SSTI)</li>
    </ul>
</body>
</html>
