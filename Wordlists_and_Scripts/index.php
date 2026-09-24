<?php
/**
 * CYBERSHIELD 2026 — Wordlists & Scripts Interface (Hacker Theme)
 */
$files = scandir(__DIR__);
$allowed_files = [];

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..' && $file !== 'index.php' && !is_dir(__DIR__ . '/' . $file)) {
        $allowed_files[] = $file;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools & Wordlists - CYBERSHIELD 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #050505;
            --bg-card: rgba(0, 20, 0, 0.85);
            --text-main: #00FF41;
            --text-muted: #008F11;
            --accent-green: #00FF41;
            --border-glow: 0 0 10px rgba(0, 255, 65, 0.5);
        }
        
        body {
            font-family: 'Fira Code', monospace;
            background-color: var(--bg-primary);
            color: var(--text-main);
            line-height: 1.6;
            padding: 40px 20px;
            overflow-x: hidden;
        }

        /* CRT Overlay Scanlines */
        body::after {
            content: " ";
            display: block;
            position: fixed;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            z-index: 2;
            background-size: 100% 2px, 3px 100%;
            pointer-events: none;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: var(--text-main);
            margin-bottom: 10px;
            text-shadow: 0 0 10px var(--text-main);
            text-transform: uppercase;
        }
        
        .subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        .file-list {
            background: var(--bg-card);
            border: 1px solid var(--accent-green);
            padding: 20px;
            box-shadow: 5px 5px 0px rgba(0, 255, 65, 0.2);
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px dashed var(--text-muted);
            transition: all 0.2s;
        }

        .file-item:last-child {
            border-bottom: none;
        }

        .file-item:hover {
            background: rgba(0, 255, 65, 0.1);
        }

        .file-name {
            font-family: 'Fira Code', monospace;
            font-size: 1.1rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .file-icon {
            font-size: 1.2rem;
            color: var(--text-main);
        }

        .btn-download {
            padding: 8px 20px;
            background: transparent;
            color: var(--accent-green);
            border: 1px solid var(--accent-green);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .btn-download:hover {
            background: var(--accent-green);
            color: #000;
            box-shadow: var(--border-glow);
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
            border: 1px dashed var(--text-muted);
            padding: 10px 20px;
        }
        .back-link:hover { 
            color: #fff; 
            border-color: #fff;
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Wordlists & Scripts</h1>
    <p class="subtitle">> ACCESSING /root/payloads_db/</p>

    <div class="file-list">
        <?php if (empty($allowed_files)): ?>
            <p style="text-align: center; color: var(--text-muted);">ERR_NO_FILES_FOUND</p>
        <?php else: ?>
            <?php foreach ($allowed_files as $file): ?>
                <?php
                    // Tentukan icon berdasarkan ekstensi
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $icon = '[FILE]';
                    if ($ext === 'py') $icon = '[PY]';
                    if ($ext === 'txt') $icon = '[TXT]';
                    if ($ext === 'jpg' || $ext === 'png') $icon = '[IMG]';
                ?>
                <div class="file-item">
                    <div class="file-name">
                        <span class="file-icon"><?= $icon ?></span>
                        <?= htmlspecialchars($file) ?>
                    </div>
                    <a href="<?= htmlspecialchars($file) ?>" class="btn-download" download>GET</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align: center;">
        <a href="../index.php" class="back-link">< RETURN_TO_ROOT</a>
    </div>
</div>

</body>
</html>
