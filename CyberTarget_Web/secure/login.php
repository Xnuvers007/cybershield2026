<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
// ✅ AMAN: Simple Rate Limiting (Bruteforce protection)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_attempt']) < 300) {
        $error = "Terlalu banyak percobaan login. Tunggu 5 menit.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // ✅ AMAN: Prepared Statement mencegah SQL Injection
        $stmt = $conn->prepare("SELECT id, username, password FROM target_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // ✅ AMAN: Menggunakan password_verify
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true); // ✅ Mencegah Session Fixation
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['login_attempts'] = 0; // Reset attempts
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt'] = time();
                // ✅ AMAN: Generic Error Message mencegah User Enumeration
                $error = "Username atau Password salah!";
            }
        } else {
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt'] = time();
            $error = "Username atau Password salah!";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - CyberBoard (Secure)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="status-badge" style="background: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);">SECURE MODE 🟢</div>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <div class="glass-panel" style="padding: 30px;">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--primary);">CyberBoard</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 20px;">Silakan login ke sistem</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: #10b981;">✅ SQLi & Bruteforce Protection Aktif</p>
        </div>
    </div>
</body>
</html>
