<?php
session_start();
// AMAN: Menambahkan Header X-Frame-Options untuk mencegah iframe dari domain lain
header('X-Frame-Options: DENY'); // Bisa juga SAMEORIGIN
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transfer Dana (SECURE)</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; background-color: #dcfce7; }
        .box { background: white; padding: 30px; border-radius: 8px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 2px solid #22c55e; }
        .btn { background: #22c55e; color: white; padding: 15px 30px; border: none; font-size: 1.2rem; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color:#166534">Transfer Uang Rp 1.000.000</h2>
        <p>Transfer ke rekening: <strong>TEMAN-ANDA</strong></p>
        <form method="POST">
            <button type="submit" name="transfer" class="btn">KONFIRMASI TRANSFER</button>
        </form>
        <?php
        if (isset($_POST['transfer'])) {
            echo "<p style='color:green; font-weight:bold;'>Transfer Berhasil!</p>";
        }
        ?>
    </div>
</body>
</html>
