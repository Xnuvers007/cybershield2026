<?php
error_reporting(0); 
session_start();
$_SESSION['login_id'] = 2; 

$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");

$keyword = $_GET['cari'] ?? '';          // A03: SQLi & XSS
$target_id = $_GET['target_id'] ?? '';   // A01: IDOR (BAC)
$pass_input = $_POST['password_test'] ?? ''; // A02: Crypto
$trigger_err = $_POST['trigger_error'] ?? ''; // A05: Misconfig
$fetch_url = $_POST['url_target'] ?? ''; // A10: SSRF
$baca_file = $_GET['dokumen'] ?? '';     // LFI
$ip_address = $_REQUEST['ip_server'] ?? ''; // RCE (Command Injection)
$ip_secure = $_REQUEST['ip_server_secure'] ?? ''; // RCE Secure

$login_user = $_POST['login_user'] ?? '';// A07: Auth Failures
$upload_name = $_POST['upload_name'] ?? ''; // A04: Insecure Design (File Upload)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OWASP Top 10</title>
    <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 20px;
    }
    .box {
        border: 1px solid #444;
        padding: 15px;
        margin-bottom: 20px;
        background: #252526;
        border-radius: 8px;
    }
    h3 {
        color: #569cd6;
        margin-top: 0;
        border-bottom: 1px solid #444;
        padding-bottom: 10px;
    }
    input[type="text"],
    input[type="password"],
    select {
        padding: 6px;
        background: #333;
        color: white;
        border: 1px solid #555;
        border-radius: 4px;
    }
    button {
        padding: 6px 15px;
        background: #007acc;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
    background: #0098ff;
    }
    .salah {
        color: #f48771;
    }
    .benar {
        color: #4ec9b0;
    }
    pre,
    .output-box {
        background: #000;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #333;
        overflow-x: auto;
        margin-top: 5px;
    }
</style>
</head>
<body>
    <div class="box">
        <h3> Kerentanan RCE </h3>
        <h4>Vulnerable (Tanpa Sanitasi)</h4>
        <form method="POST">
            ping IP: <input type="text" name="ip_server" value="<?= htmlspecialchars($ip_address) ?>"
            placeholder="127.0.0.1" required>
            <button type="submit">Ping</button>
            <small>
                bisa pakai <code> 127.0.0.1 && echo "Terhack"</code>
            </small>
        </form>
        <?php if(!empty($ip_address)) {
            echo '<div class="output-box">
            <strong>Hasil Vulnerable:</strong><br><pre>';
            echo htmlspecialchars(shell_exec("ping -n 2 " . $ip_address)); 
            echo '</pre></div>';
        } ?>

        <hr style="border-color: #444; margin: 20px 0;">

        <h4>Secure (Dengan escapeshellarg)</h4>
        <form method="POST">
            ping IP: <input type="text" name="ip_server_secure" value="<?= htmlspecialchars($ip_secure) ?>"
            placeholder="127.0.0.1" required>
            <button type="submit">Ping Secure</button>
            <small>
                coba pakai <code> 127.0.0.1 && echo "Terhack"</code>
            </small>
        </form>
        <?php if(!empty($ip_secure)) {
            echo '<div class="output-box">
            <strong>Hasil Secure:</strong><br><pre>';
            $cmd = "ping -n 2 " . escapeshellarg($ip_secure);
            echo "Command yang dieksekusi: " . htmlspecialchars($cmd) . "\n\n";
            echo htmlspecialchars(shell_exec($cmd)); 
            echo '</pre></div>';
        } ?>
    </div>
</body>
</html>