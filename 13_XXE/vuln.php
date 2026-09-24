<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : XXE (XML External Entity)
 * Risiko    : HIGH
 * Deskripsi : Pemrosesan XML dengan external entity yang diaktifkan,
 *             memungkinkan penyerang membaca file lokal.
 * ============================================================================
 */
echo "<h1>🔴 RENTAN — XML External Entity (XXE)</h1><hr>";
echo "<p><strong>Skenario:</strong> Fitur cek stok menggunakan XML.</p>";
echo "<p>Coba Payload XXE ini untuk membaca file rahasia lokal:</p>";
echo "<pre style='background:#111;color:#0f0;padding:10px;border-radius:5px;'>
&lt;?xml version=\"1.0\" encoding=\"UTF-8\"?&gt;
&lt;!DOCTYPE foo [ &lt;!ENTITY xxe SYSTEM \"file:///home/u5f0691p/public_html/lab/secret.txt\"&gt; ]&gt;
&lt;stockCheck&gt;
    &lt;productId&gt;&amp;xxe;&lt;/productId&gt;
&lt;/stockCheck&gt;
</pre>";

echo "<form method='POST' style='margin:15px 0;'>";
echo "<textarea name='xml' rows='8' style='width:100%; max-width:600px; padding:10px; font-family:monospace;'>" . htmlspecialchars($_POST['xml'] ?? "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<stockCheck>\n    <productId>123</productId>\n</stockCheck>") . "</textarea><br><br>";
echo "<button type='submit' style='padding:8px 15px;'>Cek Stok XML</button>";
echo "</form>";

if (isset($_POST['xml'])) {
    $xmlData = $_POST['xml'];
    
    // ⚠️ RENTAN: Mengaktifkan pemuatan entitas eksternal (default di PHP lama, atau dipaksa aktif)
    libxml_disable_entity_loader(false);
    
    // ⚠️ RENTAN: Mem-parsing XML tanpa pengaturan keamanan tambahan
    $dom = new DOMDocument();
    // LIBXML_NOENT mensubstitusi entitas
    $dom->loadXML($xmlData, LIBXML_NOENT | LIBXML_DTDLOAD); 
    
    $info = simplexml_import_dom($dom);
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:15px; border-radius:5px;'>";
    if ($info && isset($info->productId)) {
        // Entitas &xxe; telah dirender dan ditampilkan!
        echo "<h3>Hasil Cek Stok untuk Product ID:</h3>";
        echo "<pre style='color:#ff6b6b;'>" . htmlspecialchars((string)$info->productId) . "</pre>";
        echo "<p>Stok: 50 unit</p>";
    } else {
        echo "<p style='color:orange;'>Format XML salah.</p>";
    }
    echo "</div>";
}
echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
