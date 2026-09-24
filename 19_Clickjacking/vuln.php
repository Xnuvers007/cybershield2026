<?php
session_start();
// Rentan: Tidak ada header X-Frame-Options
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transfer Dana (VULN)</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; background-color: #f1f5f9; }
        .box { background: white; padding: 30px; border-radius: 8px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn { background: #ef4444; color: white; padding: 15px 30px; border: none; font-size: 1.2rem; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Transfer Uang Rp 1.000.000</h2>
        <p>Transfer ke rekening: <strong>HACKER-007</strong></p>
        <form method="POST">
            <button type="submit" name="transfer" class="btn">KONFIRMASI TRANSFER</button>
        </form>
        <?php
        if (isset($_POST['transfer'])) {
            echo "<p style='color:green; font-weight:bold;'>Transfer Berhasil dikirim ke Hacker!</p>";
        }
        ?>
    </div>
    <div style="margin-top: 20px;">
        <a href="attacker.html" style="background:#eab308; color:black; padding:10px 20px; text-decoration:none; border-radius:5px; font-weight:bold; display:inline-block;">⚠️ SIMULASIKAN SERANGAN (Buka Attacker Page)</a>
    </div>
</body>
</html>
