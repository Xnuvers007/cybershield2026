<?php
/**
 * CYBERSHIELD 2026 — Main Index Portal (HACKER THEME)
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYBERSHIELD 2026 | Lab Praktik Keamanan Web</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #050505;
            --bg-card: rgba(0, 20, 0, 0.85);
            --text-main: #00FF41;
            --text-muted: #008F11;
            --accent-cyan: #00FF41;
            --accent-purple: #39ff14;
            --accent-green: #00FF41;
            --accent-red: #FF003C;
            --border-glow: 0 0 10px rgba(0, 255, 65, 0.5);
            --border-red-glow: 0 0 10px rgba(255, 0, 60, 0.5);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Fira Code', monospace;
            background-color: var(--bg-primary);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Matrix Canvas Background */
        canvas#matrix {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            opacity: 0.35;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }

        header {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInDown 0.8s ease-out;
            border: 1px solid var(--accent-green);
            background: var(--bg-card);
            padding: 30px;
            box-shadow: var(--border-glow);
        }

        /* Glitch Animation */
        .glitch-wrapper {
            position: relative;
            display: inline-block;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--text-main);
            text-transform: uppercase;
            text-shadow: 0 0 10px var(--text-main);
            position: relative;
        }

        h1::before, h1::after {
            content: 'CYBERSHIELD 2026';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
        }

        h1::before {
            left: 2px;
            text-shadow: -1px 0 red;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim 5s infinite linear alternate-reverse;
        }

        h1::after {
            left: -2px;
            text-shadow: -1px 0 blue;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim2 5s infinite linear alternate-reverse;
        }

        @keyframes glitch-anim {
            0% { clip: rect(32px, 9999px, 86px, 0); }
            20% { clip: rect(21px, 9999px, 12px, 0); }
            40% { clip: rect(98px, 9999px, 51px, 0); }
            60% { clip: rect(34px, 9999px, 67px, 0); }
            80% { clip: rect(78px, 9999px, 34px, 0); }
            100% { clip: rect(12px, 9999px, 89px, 0); }
        }
        @keyframes glitch-anim2 {
            0% { clip: rect(12px, 9999px, 89px, 0); }
            20% { clip: rect(78px, 9999px, 34px, 0); }
            40% { clip: rect(34px, 9999px, 67px, 0); }
            60% { clip: rect(98px, 9999px, 51px, 0); }
            80% { clip: rect(21px, 9999px, 12px, 0); }
            100% { clip: rect(32px, 9999px, 86px, 0); }
        }

        .subtitle {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }
        
        header a {
            color: var(--text-main);
            text-decoration: none;
            border-bottom: 1px dashed var(--text-muted);
            transition: 0.2s;
        }
        header a:hover {
            color: #fff;
            background: var(--text-muted);
            border-bottom: none;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--text-muted);
            padding: 25px;
            transition: all 0.2s ease;
            position: relative;
            box-shadow: 5px 5px 0px rgba(0, 143, 17, 0.3);
        }

        .card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 7px 7px 0px rgba(0, 255, 65, 0.6);
            border-color: var(--text-main);
        }
        
        .card-content {
            position: relative;
            z-index: 1;
        }

        .card h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
        }

        .links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 15px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-align: center;
            flex: 1;
            display: inline-block;
            border-radius: 0;
            text-transform: uppercase;
        }

        .btn-vuln {
            background: transparent;
            color: var(--accent-red);
            border: 1px solid var(--accent-red);
        }
        .btn-vuln:hover { 
            background: var(--accent-red); 
            color: #000;
            box-shadow: var(--border-red-glow); 
        }

        .btn-secure {
            background: transparent;
            color: var(--accent-green);
            border: 1px solid var(--accent-green);
        }
        .btn-secure:hover { 
            background: var(--accent-green); 
            color: #000;
            box-shadow: var(--border-glow); 
        }

        .target-card {
            grid-column: 1 / -1;
            background: rgba(0, 20, 0, 0.9);
            border: 2px solid var(--text-main);
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 255, 65, 0.3);
        }
        
        .target-card:hover { border-color: #fff; box-shadow: 0 0 30px rgba(0, 255, 65, 0.8); }
        .target-card h2 { justify-content: center; font-size: 1.8rem; margin-bottom: 15px; text-shadow: 0 0 5px var(--text-main); }
        
        .tools-card {
            margin-top: 40px; 
            padding: 30px; 
            background: var(--bg-card); 
            border: 1px solid var(--text-main); 
            text-align: center; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 15px;
            box-shadow: 5px 5px 0px rgba(0, 255, 65, 0.4);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            .subtitle { font-size: 0.9rem; }
            .grid { grid-template-columns: 1fr; }
            .header-links { 
                display: flex; 
                flex-direction: column; 
                gap: 15px; 
                align-items: center;
                margin-top: 25px;
            }
            .header-links .divider { display: none; }
            .links { flex-direction: column; }
            .target-card h2 { font-size: 1.3rem; }
        }

        /* Typewriter effect for terminal text */
        .typewriter {
            overflow: hidden;
            border-right: .15em solid var(--text-main);
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 2.5s steps(40, end), blink-caret .75s step-end infinite;
        }
        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: var(--text-main); } }
    </style>
</head>
<body>

<canvas id="matrix"></canvas>

<div class="container">
    <header>
        <div class="glitch-wrapper">
            <h1>CYBERSHIELD 2026</h1>
        </div>
        <p class="subtitle" style="margin-bottom: 10px;">> ROOT_ACCESS_GRANTED : [OWASP Top 10 Lab]</p>
        <p class="subtitle">Developed by <a href="https://unpam.ac.id" target="_blank">Universitas Pamulang</a> &amp; <a href="https://github.com/Xnuvers007" target="_blank">Xnuvers007/Indra</a></p>
        
        <div class="header-links" style="margin-top: 25px; font-size: 0.9rem; display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
            <span>[ <a href="presentasi.html" target="_blank" style="color:var(--text-main);">EXEC ./PRESENTASI</a> ]</span>
            <span class="divider">&nbsp; | &nbsp;</span>
            <span>[ <a href="Animasi/index.html" target="_blank" style="color:var(--accent-purple);">VIEW ./ANIMASI</a> ]</span>
            <span class="divider">&nbsp; | &nbsp;</span>
            <span>[ <a href="README.md" target="_blank" style="color:var(--text-muted);">READ ./README.md</a> ]</span>
            <span class="divider">&nbsp; | &nbsp;</span>
            <span>[ <a href="DISCLAIMER.md" target="_blank" style="color:var(--accent-red);">WARN ./DISCLAIMER</a> ]</span>
            <span class="divider">&nbsp; | &nbsp;</span>
            <span>[ <a href="install.php" style="color:var(--accent-yellow, #ffd600);">SETUP ./INSTALL</a> ]</span>
        </div>
    </header>

    <div class="grid">
        <!-- Target Web Application -->
        <div class="card target-card">
            <div class="card-content">
                <h2>[ 🎯 ] SYSTEM_TARGET: CyberBoard</h2>
                <p style="color: var(--text-muted); max-width: 800px; margin: 0 auto;">Simulasi platform lengkap yang berisi gabungan berbagai kerentanan siber untuk demonstrasi serangan berantai (Stolen Cookies via XSS, SQLi Login Bypass, Bruteforce, LFI, dll).</p>
                <div class="links" style="justify-content: center; gap: 20px; max-width: 600px; margin: 25px auto 0;">
                    <a href="CyberTarget_Web/vuln/" class="btn btn-vuln" style="padding: 12px 24px; font-size: 1.1rem;">> INITIATE_ATTACK (VULN)</a>
                    <a href="CyberTarget_Web/secure/" class="btn btn-secure" style="padding: 12px 24px; font-size: 1.1rem;">> DEPLOY_DEFENSE (SECURE)</a>
                </div>
            </div>
        </div>

        <?php
        $labs = [
            ['id' => '01', 'dir' => '01_Broken_Access_Control', 'name' => 'Broken Access Control', 'desc' => 'IDOR & Role Bypass'],
            ['id' => '02', 'dir' => '02_Cryptographic_Failures', 'name' => 'Cryptographic Failures', 'desc' => 'MD5 vs Bcrypt'],
            ['id' => '03', 'dir' => '03_Injection', 'name' => 'Injection', 'desc' => 'SQLi Bypass & Data Leak'],
            ['id' => '04', 'dir' => '04_Insecure_Design', 'name' => 'Insecure Design', 'desc' => 'No Rate Limiting'],
            ['id' => '05', 'dir' => '05_Security_Misconfiguration', 'name' => 'Security Misconfiguration', 'desc' => 'Error Leak & Headers'],
            ['id' => '06', 'dir' => '06_Vulnerable_Components', 'name' => 'Vulnerable Components', 'desc' => 'Simulasi CVE'],
            ['id' => '07', 'dir' => '07_Auth_Failures', 'name' => 'Auth Failures', 'desc' => 'Session Fixation'],
            ['id' => '08', 'dir' => '08_Data_Integrity_Failures', 'name' => 'Software & Data Integrity', 'desc' => 'Insecure Deserialization'],
            ['id' => '09', 'dir' => '09_Logging_Monitoring_Failures', 'name' => 'Logging & Monitoring', 'desc' => 'Audit Trail Bypass'],
            ['id' => '10', 'dir' => '10_SSRF', 'name' => 'SSRF', 'desc' => 'Server-Side Request Forgery'],
            ['id' => '11', 'dir' => '11_LFI', 'name' => 'LFI', 'desc' => 'Local File Inclusion'],
            ['id' => '12', 'dir' => '12_RCE', 'name' => 'RCE', 'desc' => 'Remote Code Execution'],
            ['id' => '13a', 'dir' => '13_XXE', 'name' => 'XXE Basic', 'desc' => 'XML External Entity (Stok)'],
            ['id' => '13b', 'dir' => '13_XXE', 'name' => 'XXE & Logic Flaw', 'desc' => 'Online Shop (Kuantitas & File)'],
            ['id' => '14', 'dir' => '14_Zombie_Cookies', 'name' => 'Zombie Cookies', 'desc' => 'Persistent Tracking'],
            ['id' => '15', 'dir' => '15_File_Upload', 'name' => 'File Upload (MIME)', 'desc' => 'Manipulasi MIME & Defacement'],
            ['id' => '16', 'dir' => '16_SQLi_News', 'name' => 'SQLi (Portal Berita)', 'desc' => 'Error, UNION & DIOS'],
            ['id' => '17', 'dir' => '17_Open_Redirect', 'name' => 'Open Redirect', 'desc' => 'Unvalidated Redirect'],
            ['id' => '18', 'dir' => '18_Reverse_Tabnabbing', 'name' => 'Reverse Tabnabbing', 'desc' => 'Phishing via window.opener'],
            ['id' => '★', 'dir' => 'bonus_XSS', 'name' => 'Bonus: XSS', 'desc' => 'Cross-Site Scripting'],
        ];

        foreach ($labs as $lab) {
            $is_new = in_array($lab['id'], ['11', '12', '13a', '13b', '14', '15', '16', '17', '18']);
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<h2><span style="color:var(--text-muted);">' . $lab['id'] . '</span> / ' . $lab['name'];
            if ($is_new) echo ' <span style="background:var(--text-main); color:#000; font-size:10px; padding:2px 6px; margin-left:auto;">NEW</span>';
            echo '</h2>';
            echo '<p style="font-size:0.9rem; color:var(--text-muted); margin-bottom:15px; height: 45px;">> ' . $lab['desc'] . '</p>';
            
            // Check if folder exists
            if (is_dir(__DIR__ . '/' . $lab['dir'])) {
                $vuln_file = ($lab['id'] === '13b') ? 'vuln_shop.php' : 'vuln.php';
                $secure_file = ($lab['id'] === '13b') ? 'secure_shop.php' : 'secure.php';
                
                echo '<div class="links">';
                echo '<a href="' . $lab['dir'] . '/' . $vuln_file . '" class="btn btn-vuln"># EXPLOIT</a>';
                echo '<a href="' . $lab['dir'] . '/' . $secure_file . '" class="btn btn-secure"># PATCH</a>';
                echo '</div>';
            } else {
                echo '<div style="color:var(--accent-red); font-size:0.8rem; margin-top:15px; padding:8px; border:1px dashed var(--accent-red);">ERR_DIR_NOT_FOUND</div>';
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Info tambahan tools -->
    <div class="tools-card">
        <div>
            <h3 style="color: var(--text-main); margin-bottom: 5px;">[ 🛠️ ] TOOLS & PAYLOAD_DB</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 600px; margin: 0 auto;">
                > Loading exploit payloads, wordlists, and automation scripts...
            </p>
        </div>
        <a href="Wordlists_and_Scripts/index.php" class="btn btn-secure" style="padding: 12px 30px; font-size: 1.05rem;">$ cd ./Wordlists_and_Scripts/</a>
    </div>
    <!-- Footer -->
    <footer style="margin-top: 50px; padding: 20px; text-align: center; border-top: 1px solid var(--text-muted); color: var(--text-muted); font-size: 0.85rem;">
        <p>Created website by <a href="https://instagram.com/Indradwi.25" target="_blank" style="color: var(--text-main); text-decoration: none; border-bottom: 1px dashed var(--text-muted);">Indra</a> &nbsp;|&nbsp; <a href="https://instagram.com/Indradwi.25" target="_blank" style="color: var(--text-muted); text-decoration: none;">📷 @Indradwi.25</a></p>
        <p style="margin-top: 8px; font-size: 0.75rem; color: rgba(0, 255, 65, 0.3);">&copy; <?= date('Y') ?> CYBERSHIELD — HIMTIF Universitas Pamulang</p>
    </footer>
</div>

<script>
    // Matrix Rain Effect
    const canvas = document.getElementById('matrix');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const katakana = 'アァカサタナハマヤャラワガザダバパイィキシチニヒミリヰギジヂビピウゥクスツヌフムユュルグズブヅプエェケセテネヘメレゲゼデベペオォコソトノホモヨョロゴゾドボポヴッン';
    const latin = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const nums = '0123456789';
    const alphabet = katakana + latin + nums;

    const fontSize = 16;
    const columns = canvas.width / fontSize;

    const rainDrops = [];
    for (let x = 0; x < columns; x++) {
        rainDrops[x] = 1;
    }

    const draw = () => {
        ctx.fillStyle = 'rgba(5, 5, 5, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#0F0';
        ctx.font = fontSize + 'px monospace';

        for (let i = 0; i < rainDrops.length; i++) {
            const text = alphabet.charAt(Math.floor(Math.random() * alphabet.length));
            ctx.fillText(text, i * fontSize, rainDrops[i] * fontSize);

            if (rainDrops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                rainDrops[i] = 0;
            }
            rainDrops[i]++;
        }
    };
    setInterval(draw, 30);
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
</script>
</body>
</html>
