<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : XXE (XML External Entity) & Business Logic Flaw
 * Risiko    : CRITICAL
 * Deskripsi : 1. XXE membolehkan pencurian file lokal lewat XML entitas.
 *             2. Logic Flaw membolehkan kuantitas negatif (-1) pada
 *                keranjang belanja untuk memanipulasi total harga.
 * ============================================================================
 */
echo "<h1>🔴 RENTAN — XXE & Logic Flaw (Online Shop)</h1><hr>";
echo "<p><strong>Skenario:</strong> Fitur Checkout Keranjang Belanja berbasis XML.</p>";
echo "<p><strong>Tantangan Anda:</strong> Saldo Anda hanya Rp 1.000.000. Harga Laptop adalah Rp 15.000.000. Bagaimana cara Anda membeli Laptop tersebut tanpa menambah saldo, dan sekaligus mencuri isi file <code>/home/u5f0691p/public_html/lab/secret.txt</code>?</p>";

$saldo_awal = 1000000;

$default_xml = '<?xml version="1.0" encoding="UTF-8"?>
<checkout>
    <customer>User Biasa</customer>
    <cart>
        <item>
            <name>Laptop Gaming</name>
            <price>15000000</price>
            <qty>1</qty>
        </item>
        <item>
            <name>Mousepad</name>
            <price>50000</price>
            <qty>1</qty>
        </item>
    </cart>
</checkout>';

echo "<form method='POST' style='margin:15px 0;'>";
echo "<textarea name='xml' rows='15' style='width:100%; max-width:700px; padding:10px; font-family:monospace;'>" . htmlspecialchars($_POST['xml'] ?? $default_xml) . "</textarea><br><br>";
echo "<button type='submit' style='padding:10px 20px; background:#ef4444; color:white; border:none; border-radius:5px;'>Proses Checkout</button>";
echo "</form>";

if (isset($_POST['xml'])) {
    $xmlData = $_POST['xml'];
    
    // ⚠️ RENTAN 1: XXE (Mengizinkan entitas eksternal)
    libxml_disable_entity_loader(false);
    $dom = new DOMDocument();
    $dom->loadXML($xmlData, LIBXML_NOENT | LIBXML_DTDLOAD); 
    
    $info = simplexml_import_dom($dom);
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:20px; border-radius:5px;'>";
    
    if ($info && isset($info->cart)) {
        $customer = (string)$info->customer;
        echo "<h3>Nota Pembelian untuk: <span style='color:#0f0;'>$customer</span></h3>"; // Hasil XXE akan muncul di sini
        echo "<hr>";
        
        $total_belanja = 0;
        echo "<ul>";
        foreach ($info->cart->item as $item) {
            $name = (string)$item->name;
            $price = (int)$item->price;
            
            // ⚠️ RENTAN 2: Business Logic Flaw (Kuantitas bisa negatif!)
            // Tidak ada pengecekan if ($qty <= 0)
            $qty = (int)$item->qty; 
            
            $subtotal = $price * $qty;
            $total_belanja += $subtotal;
            
            echo "<li>$name (Rp " . number_format($price) . ") x <strong>$qty</strong> = Rp " . number_format($subtotal) . "</li>";
        }
        echo "</ul>";
        
        echo "<hr>";
        echo "<h4>Total Belanja: Rp " . number_format($total_belanja) . "</h4>";
        echo "<h4>Saldo Anda: Rp " . number_format($saldo_awal) . "</h4>";
        
        if ($total_belanja <= $saldo_awal) {
            $sisa = $saldo_awal - $total_belanja;
            echo "<h3 style='color:#10b981;'>✅ Transaksi Berhasil! Sisa Saldo: Rp " . number_format($sisa) . "</h3>";
        } else {
            echo "<h3 style='color:#ef4444;'>🚫 Saldo Tidak Mencukupi!</h3>";
        }
    } else {
        echo "<p style='color:orange;'>Format XML salah atau elemen keranjang tidak ditemukan.</p>";
    }
    echo "</div>";
}

echo "<br>";
echo "<div style='background:rgba(255,255,255,0.05); padding:15px; border-left:4px solid #f59e0b; margin-top:20px;'>";
echo "<strong>💡 HINT EKSPLOITASI:</strong><br>";
echo "1. <strong>Untuk Logic Flaw:</strong> Ubah <code>&lt;qty&gt;</code> pada Mousepad menjadi angka negatif besar (misal <code>-300</code>) agar total belanja menjadi sangat murah / minus.<br>";
echo "2. <strong>Untuk XXE:</strong> Tambahkan <code>&lt;!DOCTYPE foo [ &lt;!ENTITY xxe SYSTEM \"file:///home/u5f0691p/public_html/lab/secret.txt\"&gt; ]&gt;</code> di bawah tag <code>&lt;?xml... ?&gt;</code> lalu ubah isian nama menjadi <code>&lt;customer&gt;&amp;xxe;&lt;/customer&gt;</code>.";
echo "</div>";

echo "<br><a href='secure_shop.php'>➡️ Lihat versi AMAN</a> | <a href='index.php'>🏠 Kembali ke Portal</a>";
?>
