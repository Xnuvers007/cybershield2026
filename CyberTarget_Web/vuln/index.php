<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ⚠️ RENTAN: Menyimpan post tanpa sanitasi (Stored XSS)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];
    // ⚠️ RENTAN: SQL Injection & XSS
    $conn->query("INSERT INTO target_posts (author_id, content) VALUES ($author_id, '$content')");
}

$search = $_GET['q'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CyberBoard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="status-badge">VULNERABLE MODE 🔴</div>
    <div class="navbar">
        <a href="index.php" class="logo">CyberBoard</a>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="profile.php?id=<?= $_SESSION['user_id'] ?>">Profile</a>
            <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>)</a>
        </div>
    </div>

    <div class="container">
        <div class="grid-2">
            <div>
                <div class="glass-panel" style="padding: 20px; margin-bottom: 20px;">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Buat Postingan</h3>
                    <form method="POST">
                        <textarea name="content" rows="4" placeholder="Apa yang Anda pikirkan? (Coba masukkan payload XSS di sini)"></textarea>
                        <button type="submit">Posting</button>
                    </form>
                </div>

                <div class="glass-panel" style="padding: 20px;">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Cari Post</h3>
                    <form method="GET">
                        <input type="text" name="q" placeholder="Cari..." value="<?= $search ?>"> <!-- ⚠️ RENTAN Reflected XSS jika input mengandung " -->
                        <button type="submit">Cari</button>
                    </form>
                    <?php if ($search): ?>
                        <!-- ⚠️ RENTAN: Reflected XSS -->
                        <div class="alert alert-error" style="margin-top: 15px;">
                            Hasil pencarian untuk: <?= $search ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="glass-panel" style="padding: 20px; height: fit-content;">
                <h3 style="margin-bottom: 15px; color: var(--primary);">Timeline Global</h3>
                <?php
                $query = "SELECT p.*, u.username FROM target_posts p JOIN target_users u ON p.author_id = u.id";
                if ($search) {
                    // ⚠️ RENTAN: SQL Injection via Search
                    $query .= " WHERE p.content LIKE '%$search%'";
                }
                $query .= " ORDER BY p.created_at DESC";
                
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<div class='post-header'>";
                        // ⚠️ RENTAN: Stored XSS karena content tidak disanitasi
                        echo "<strong>" . htmlspecialchars($post['username']) . "</strong> &bull; " . $post['created_at'];
                        echo "</div>";
                        echo "<div class='post-body'>" . $post['content'] . "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='color: var(--text-muted);'>Tidak ada postingan.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
