<?php
/**
 * ✅ KODE AMAN — XXE & Business Logic Flaw (Online Shop)
 * Solusi: 1. Matikan eksekusi external entity pada XML parsing.
 *         2. Validasi input nilai qty harus integer positif (>= 1).
 */
echo "<h1>🟢 AMAN — XXE & Logic Flaw (Online Shop)</h1><hr>";
echo "<p><strong>Skenario:</strong> Fitur Checkout Keranjang Belanja berbasis XML yang sudah diamankan.</p>";

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
echo "<button type='submit' style='padding:10px 20px; background:#10b981; color:white; border:none; border-radius:5px;'>Proses Checkout Aman</button>";
echo "</form>";

if (isset($_POST['xml'])) {
    $xmlData = $_POST['xml'];
    
    // ✅ AMAN 1: Matikan Load External Entity (Mencegah XXE)
    if (LIBXML_VERSION < 20900) {
        libxml_disable_entity_loader(true);
    }
    
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    
    // ✅ Tidak memakai LIBXML_NOENT saat meload XML
    $loaded = $dom->loadXML($xmlData);
    
    echo "<div style='background:#1a1a2e; color:#eee; padding:20px; border-radius:5px;'>";
    
    if ($loaded) {
        $info = simplexml_import_dom($dom);
        if ($info && isset($info->cart)) {
            // ✅ HTML Entity Encode Mencegah XSS dari XML Data
            $customer = htmlspecialchars((string)$info->customer); 
            echo "<h3>Nota Pembelian untuk: <span style='color:#10b981;'>$customer</span></h3>"; 
            echo "<hr>";
            
            $total_belanja = 0;
            $keranjang_valid = true;
            
            echo "<ul>";
            foreach ($info->cart->item as $item) {
                $name = htmlspecialchars((string)$item->name);
                $price = (int)$item->price;
                $qty = (int)$item->qty; 
                
                // ✅ AMAN 2: Logic Validation (Mencegah Negatif QTY / Bypass Logic)
                if ($qty <= 0) {
                    echo "<li style='color:red;'><strong>ERROR:</strong> Kuantitas barang '$name' tidak valid ($qty). Harus lebih dari 0.</li>";
                    $keranjang_valid = false;
                    continue;
                }
                
                $subtotal = $price * $qty;
                $total_belanja += $subtotal;
                
                echo "<li>$name (Rp " . number_format($price) . ") x <strong>$qty</strong> = Rp " . number_format($subtotal) . "</li>";
            }
            echo "</ul>";
            
            echo "<hr>";
            
            if ($keranjang_valid) {
                echo "<h4>Total Belanja: Rp " . number_format($total_belanja) . "</h4>";
                echo "<h4>Saldo Anda: Rp " . number_format($saldo_awal) . "</h4>";
                
                if ($total_belanja <= $saldo_awal) {
                    $sisa = $saldo_awal - $total_belanja;
                    echo "<h3 style='color:#10b981;'>✅ Transaksi Berhasil! Sisa Saldo: Rp " . number_format($sisa) . "</h3>";
                } else {
                    echo "<h3 style='color:#ef4444;'>🚫 Saldo Tidak Mencukupi!</h3>";
                }
            } else {
                echo "<h3 style='color:#ef4444;'>🚫 Transaksi Dibatalkan karena ada item yang tidak valid.</h3>";
            }
        }
    } else {
        echo "<p style='color:#ef4444;'>Gagal memproses XML. DTD/External Entity tidak diizinkan atau format XML salah.</p>";
    }
    echo "</div>";
}

echo "<br><a href='vuln_shop.php'>⬅️ Lihat versi RENTAN</a> | <a href='index.php'>🏠 Kembali ke Portal</a>";
?>
