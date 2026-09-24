<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ⚠️ RENTAN: IDOR (Insecure Direct Object Reference)
// User bisa melihat dan mengubah profil user lain hanya dengan mengganti parameter URL ?id=
$profile_id = $_GET['id'] ?? $_SESSION['user_id'];

// ⚠️ RENTAN: SQL Injection via parameter ID
$query = "SELECT * FROM target_users WHERE id = $profile_id";
$result = $conn->query($query);
$profile = $result ? $result->fetch_assoc() : null;

if (!$profile) {
    die("Profil tidak ditemukan.");
}

// Handle Update Profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio'])) {
    $new_bio = $_POST['bio'];
    // ⚠️ RENTAN: IDOR update (Bisa update bio milik admin!)
    // ⚠️ RENTAN: Stored XSS di bio
    $conn->query("UPDATE target_users SET bio = '$new_bio' WHERE id = $profile_id");
    header("Location: profile.php?id=$profile_id");
    exit;
}

// ⚠️ RENTAN: LFI (Local File Inclusion) via parameter theme
$theme = $_GET['theme'] ?? '';
$theme_content = '';
if ($theme) {
    // Penyerang bisa memasukkan ?theme=../../../../Windows/win.ini
    $theme_content = @file_get_contents($theme);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil - CyberBoard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        <?= htmlspecialchars($theme_content) /* Ini untuk mensimulasikan injeksi CSS atau file lain via LFI */ ?>
    </style>
</head>
<body>
    <div class="status-badge">VULNERABLE MODE 🔴</div>
    <div class="navbar">
        <a href="index.php" class="logo">CyberBoard</a>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="profile.php?id=<?= $_SESSION['user_id'] ?>">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container" style="max-width: 600px;">
        <div class="glass-panel" style="padding: 30px;">
            <h2 style="color: var(--primary); margin-bottom: 20px;">Profil Pengguna</h2>
            
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <p><strong>Username:</strong> <?= htmlspecialchars($profile['username']) ?></p>
                <p><strong>Role:</strong> <span style="color: <?= $profile['role'] === 'admin' ? 'var(--danger)' : 'var(--primary)' ?>; font-weight: bold;"><?= strtoupper($profile['role']) ?></span></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
            </div>

            <h3 style="margin-bottom: 15px;">Update Bio</h3>
            <form method="POST">
                <textarea name="bio" rows="4" placeholder="Tulis sesuatu tentang dirimu..."><?= $profile['bio'] /* ⚠️ RENTAN XSS */ ?></textarea>
                <button type="submit">Simpan Perubahan</button>
            </form>
            
            <?php if ($theme_content): ?>
                <div class="alert alert-error" style="margin-top: 20px; word-break: break-all;">
                    <strong>LFI Output preview:</strong><br>
                    <pre style="font-size: 0.8rem; max-height: 200px; overflow-y: auto;"><?= htmlspecialchars($theme_content) ?></pre>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
