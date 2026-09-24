<?php
/**
 * ✅ KODE AMAN — XXE (XML External Entity)
 * Solusi: Disable entity loader (PHP < 8) dan abaikan LIBXML_NOENT.
 */
echo "<h1>🟢 AMAN — XML External Entity (XXE)</h1><hr>";

echo "<form method='POST' style='margin:15px 0;'>";
echo "<textarea name='xml' rows='8' style='width:100%; max-width:600px; padding:10px; font-family:monospace;'>" . htmlspecialchars($_POST['xml'] ?? "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<stockCheck>\n    <productId>123</productId>\n</stockCheck>") . "</textarea><br><br>";
echo "<button type='submit' style='padding:8px 15px;'>Cek Stok XML</button>";
echo "</form>";

if (isset($_POST['xml'])) {
    $xmlData = $_POST['xml'];
    
    // ✅ AMAN 1: Disable load eksternal entity (Diperlukan untuk PHP < 8.0)
    if (LIBXML_VERSION < 20900) {
        libxml_disable_entity_loader(true);
    }
    
    // ✅ AMAN 2: Jangan gunakan flag LIBXML_NOENT atau LIBXML_DTDLOAD saat meload XML
    // Jika perlu, lebih baik gunakan format JSON daripada XML!
    
    $dom = new DOMDocument();
    
    // Matikan error untuk keamanan (tidak membocorkan error XML ke user)
    libxml_use_internal_errors(true);
    
    // Load XML dengan aman
    $loaded = $dom->loadXML($xmlData);
    
    if ($loaded) {
        $info = simplexml_import_dom($dom);
        echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
        if ($info && isset($info->productId)) {
            echo "<h3>Hasil Cek Stok untuk Product ID:</h3>";
            echo "<pre style='color:#10b981;'>" . htmlspecialchars((string)$info->productId) . "</pre>";
            // External entities (seperti &xxe;) TIDAK akan dievaluasi dan hanya dianggap string kosong / error.
            echo "<p>Stok: 50 unit</p>";
        }
        echo "</div>";
    } else {
        echo "<div style='background:#ef4444; color:white; padding:15px; border-radius:5px;'>";
        echo "🚫 Gagal memproses XML. DTD/External Entity tidak diizinkan.";
        echo "</div>";
    }
}
echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
