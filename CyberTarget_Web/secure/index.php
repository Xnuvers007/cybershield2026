<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ✅ AMAN: Cek CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed");
    }
    
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];
    
    // ✅ AMAN: Gunakan prepared statement untuk insert
    $stmt = $conn->prepare("INSERT INTO target_posts (author_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $author_id, $content);
    $stmt->execute();
    $stmt->close();
}

$search = $_GET['q'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CyberBoard (Secure)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="status-badge" style="background: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);">SECURE MODE 🟢</div>
    <div class="navbar">
        <a href="index.php" class="logo">CyberBoard</a>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="profile.php">Profile</a> <!-- ✅ AMAN: Hapus ?id= dari URL default -->
            <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>)</a>
        </div>
    </div>

    <div class="container">
        <div class="grid-2">
            <div>
                <div class="glass-panel" style="padding: 20px; margin-bottom: 20px;">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Buat Postingan</h3>
                    <form method="POST">
                        <!-- ✅ AMAN: Anti-CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <textarea name="content" rows="4" placeholder="Apa yang Anda pikirkan? (XSS akan difilter)"></textarea>
                        <button type="submit">Posting</button>
                    </form>
                </div>

                <div class="glass-panel" style="padding: 20px;">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Cari Post</h3>
                    <form method="GET">
                        <!-- ✅ AMAN: htmlspecialchars untuk value atribut -->
                        <input type="text" name="q" placeholder="Cari..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit">Cari</button>
                    </form>
                    <?php if ($search): ?>
                        <div class="alert alert-success" style="margin-top: 15px;">
                            <!-- ✅ AMAN: Output Encoding -->
                            Hasil pencarian untuk: <?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="glass-panel" style="padding: 20px; height: fit-content;">
                <h3 style="margin-bottom: 15px; color: var(--primary);">Timeline Global</h3>
                <?php
                // ✅ AMAN: Prepared statements untuk pencarian
                $query = "SELECT p.*, u.username FROM target_posts p JOIN target_users u ON p.author_id = u.id";
                if ($search) {
                    $query .= " WHERE p.content LIKE ?";
                    $query .= " ORDER BY p.created_at DESC";
                    $stmt = $conn->prepare($query);
                    $like_search = "%$search%";
                    $stmt->bind_param("s", $like_search);
                } else {
                    $query .= " ORDER BY p.created_at DESC";
                    $stmt = $conn->prepare($query);
                }
                
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result && $result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<div class='post-header'>";
                        echo "<strong>" . htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') . "</strong> &bull; " . $post['created_at'];
                        echo "</div>";
                        // ✅ AMAN: Output di-encode dengan htmlspecialchars mencegah XSS
                        echo "<div class='post-body'>" . htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') . "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='color: var(--text-muted);'>Tidak ada postingan.</p>";
                }
                $stmt->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
