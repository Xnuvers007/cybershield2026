<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ RENTAN: SQL Injection (Bypass Login)
    // Coba username: ' OR '1'='1' -- -
    // ⚠️ RENTAN: Tanpa Rate Limiting (Bruteforce)
    $query = "SELECT * FROM target_users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Cek jika bypass SQLi (password diabaikan karena logic SQL) atau password cocok
        // Jika query menghasilkan baris karena ' OR 1=1, ini akan login sebagai user pertama (admin)
        // jika kita tambahkan validasi password, bypass SQLi jadi lebih susah. 
        // Untuk simulasi klasik login bypass:
        $query_bypass = "SELECT * FROM target_users WHERE username = '$username' AND password = '$password'";
        $result_bypass = $conn->query($query_bypass);
        
        if ($result_bypass && $result_bypass->num_rows > 0) {
            $user_bypass = $result_bypass->fetch_assoc();
            $_SESSION['user_id'] = $user_bypass['id'];
            $_SESSION['username'] = $user_bypass['username'];
            header("Location: index.php");
            exit;
        } else {
            // Fallback to check hash if not bypassed via AND password=''
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        }
    } else {
        // ⚠️ RENTAN: User Enumeration (Pesan error spesifik)
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - CyberBoard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="status-badge">VULNERABLE MODE 🔴</div>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <div class="glass-panel" style="padding: 30px;">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--primary);">CyberBoard</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 20px;">Silakan login ke sistem</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: var(--text-muted);">Hint: Coba SQL Injection bypass atau login sebagai hacker_wannabe / password: password123</p>
        </div>
    </div>
</body>
</html>
