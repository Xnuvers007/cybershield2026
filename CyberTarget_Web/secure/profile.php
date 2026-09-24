<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ✅ AMAN: Otorisasi berbasis sesi, IDOR dicegah.
// User HANYA bisa mengakses profil mereka sendiri berdasarkan session.
$profile_id = $_SESSION['user_id'];

// ✅ AMAN: Prepared Statement
$stmt = $conn->prepare("SELECT * FROM target_users WHERE id = ?");
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$profile) {
    die("Profil tidak ditemukan.");
}

// Handle Update Profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed");
    }
    
    $new_bio = $_POST['bio'];
    
    // ✅ AMAN: Prepared statement untuk update bio
    $stmt = $conn->prepare("UPDATE target_users SET bio = ? WHERE id = ?");
    $stmt->bind_param("si", $new_bio, $profile_id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: profile.php");
    exit;
}

// ✅ AMAN: Hapus parameter theme atau validasi secara ketat
// Kita menggunakan whitelist warna dasar saja, LFI dicegah.
$theme = $_GET['theme'] ?? 'default';
$allowed_themes = ['default', 'dark', 'light'];
if (!in_array($theme, $allowed_themes)) {
    $theme = 'default';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil - CyberBoard (Secure)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="theme-<?= htmlspecialchars($theme) ?>">
    <div class="status-badge" style="background: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);">SECURE MODE 🟢</div>
    <div class="navbar">
        <a href="index.php" class="logo">CyberBoard</a>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container" style="max-width: 600px;">
        <div class="glass-panel" style="padding: 30px;">
            <h2 style="color: var(--primary); margin-bottom: 20px;">Profil Pengguna</h2>
            
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <!-- ✅ AMAN: htmlspecialchars -->
                <p><strong>Username:</strong> <?= htmlspecialchars($profile['username']) ?></p>
                <p><strong>Role:</strong> <span style="color: <?= $profile['role'] === 'admin' ? 'var(--danger)' : 'var(--primary)' ?>; font-weight: bold;"><?= strtoupper($profile['role']) ?></span></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
            </div>

            <h3 style="margin-bottom: 15px;">Update Bio</h3>
            <form method="POST">
                <!-- ✅ AMAN: CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <!-- ✅ AMAN: htmlspecialchars -->
                <textarea name="bio" rows="4" placeholder="Tulis sesuatu tentang dirimu..."><?= htmlspecialchars($profile['bio']) ?></textarea>
                <button type="submit">Simpan Perubahan</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: #10b981;">✅ IDOR, LFI, & XSS Protection Aktif</p>
        </div>
    </div>
</body>
</html>
