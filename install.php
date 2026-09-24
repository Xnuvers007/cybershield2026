<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYBERSHIELD 2026 — Panduan Instalasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #050505;
            --bg-card: rgba(0, 20, 0, 0.85);
            --bg-code: #0a0a0a;
            --text-main: #00FF41;
            --text-muted: #008F11;
            --text-dim: #005a0a;
            --accent-red: #FF003C;
            --accent-cyan: #00e5ff;
            --accent-yellow: #ffd600;
            --border-glow: 0 0 10px rgba(0, 255, 65, 0.5);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Fira Code', monospace;
            background: var(--bg-primary);
            color: var(--text-main);
            line-height: 1.7;
            min-height: 100vh;
        }

        /* Scanline overlay */
        body::after {
            content: "";
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(rgba(18,16,16,0) 50%, rgba(0,0,0,0.25) 50%);
            background-size: 100% 2px;
            pointer-events: none;
            z-index: 999;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        /* Header */
        .header {
            text-align: center;
            border: 1px solid var(--text-main);
            background: var(--bg-card);
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: var(--border-glow);
        }
        .header h1 {
            font-size: 2rem;
            text-transform: uppercase;
            text-shadow: 0 0 10px var(--text-main);
            margin-bottom: 8px;
        }
        .header p { color: var(--text-muted); font-size: 0.9rem; }
        .header a {
            color: var(--text-main);
            text-decoration: none;
            border-bottom: 1px dashed var(--text-muted);
        }
        .header a:hover { background: var(--text-muted); color: #000; }

        /* Back button */
        .back-btn {
            display: inline-block;
            padding: 8px 18px;
            border: 1px solid var(--text-main);
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 30px;
            transition: 0.2s;
        }
        .back-btn:hover {
            background: var(--text-main);
            color: #000;
            box-shadow: var(--border-glow);
        }

        /* Requirements table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 25px;
            font-size: 0.85rem;
        }
        th {
            background: rgba(0, 255, 65, 0.1);
            color: var(--text-main);
            text-align: left;
            padding: 10px 14px;
            border: 1px solid var(--text-dim);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        td {
            padding: 8px 14px;
            border: 1px solid var(--text-dim);
            color: var(--text-muted);
        }

        /* Section boxes */
        .section {
            border: 1px solid var(--text-dim);
            background: var(--bg-card);
            margin-bottom: 25px;
            box-shadow: 4px 4px 0px rgba(0, 143, 17, 0.25);
        }
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--text-dim);
            cursor: pointer;
            user-select: none;
            transition: 0.2s;
        }
        .section-header:hover { background: rgba(0, 255, 65, 0.05); }
        .section-header .icon { font-size: 1.5rem; }
        .section-header h2 {
            font-size: 1rem;
            text-transform: uppercase;
            flex: 1;
        }
        .section-header .difficulty {
            font-size: 0.7rem;
            padding: 3px 8px;
            border: 1px solid;
            text-transform: uppercase;
        }
        .difficulty-easy { color: var(--text-main); border-color: var(--text-main); }
        .difficulty-medium { color: var(--accent-yellow); border-color: var(--accent-yellow); }
        .section-header .toggle {
            font-size: 1.2rem;
            color: var(--text-muted);
            transition: transform 0.3s;
        }
        .section.open .toggle { transform: rotate(90deg); }

        .section-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }
        .section.open .section-body { max-height: 5000px; }
        .section-content { padding: 20px; }

        /* Steps */
        .step {
            margin-bottom: 20px;
            padding-left: 20px;
            border-left: 2px solid var(--text-dim);
        }
        .step h3 {
            font-size: 0.9rem;
            color: var(--accent-cyan);
            margin-bottom: 8px;
        }
        .step p, .step li {
            color: var(--text-muted);
            font-size: 0.82rem;
            line-height: 1.8;
        }
        .step ol, .step ul {
            padding-left: 20px;
            margin: 8px 0;
        }

        /* Code blocks */
        pre {
            background: var(--bg-code);
            border: 1px solid var(--text-dim);
            padding: 14px 18px;
            margin: 10px 0 15px;
            overflow-x: auto;
            font-size: 0.8rem;
            line-height: 1.6;
            position: relative;
        }
        pre .comment { color: #555; }
        pre .cmd { color: var(--text-main); }
        pre .url { color: var(--accent-cyan); }
        pre .warn { color: var(--accent-yellow); }

        /* Copy button */
        .copy-btn {
            position: absolute;
            top: 6px; right: 6px;
            background: rgba(0,255,65,0.1);
            border: 1px solid var(--text-dim);
            color: var(--text-muted);
            padding: 3px 8px;
            font-size: 0.65rem;
            font-family: 'Fira Code', monospace;
            cursor: pointer;
            transition: 0.2s;
        }
        .copy-btn:hover { background: var(--text-main); color: #000; }

        /* Info / Warning boxes */
        .info-box {
            padding: 12px 16px;
            margin: 12px 0;
            font-size: 0.8rem;
            border-left: 3px solid;
        }
        .info-box.tip { border-color: var(--text-main); background: rgba(0,255,65,0.05); color: var(--text-muted); }
        .info-box.warn { border-color: var(--accent-yellow); background: rgba(255,214,0,0.05); color: var(--accent-yellow); }
        .info-box.danger { border-color: var(--accent-red); background: rgba(255,0,60,0.05); color: #ff6b6b; }

        /* Quick nav */
        .quick-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin: 20px 0 35px;
        }
        .quick-nav a {
            display: block;
            padding: 14px;
            border: 1px solid var(--text-dim);
            background: var(--bg-card);
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.8rem;
            text-align: center;
            transition: 0.2s;
            box-shadow: 3px 3px 0 rgba(0,143,17,0.2);
        }
        .quick-nav a:hover {
            border-color: var(--text-main);
            box-shadow: 5px 5px 0 rgba(0,255,65,0.5);
            transform: translate(-2px, -2px);
        }
        .quick-nav a .label { display: block; color: var(--text-muted); font-size: 0.7rem; margin-top: 4px; }

        code {
            background: var(--bg-code);
            padding: 2px 6px;
            font-size: 0.8rem;
            color: var(--accent-cyan);
        }

        /* Config table highlight */
        .config-table td:first-child { color: var(--accent-cyan); }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--text-dim);
            color: var(--text-dim);
            font-size: 0.75rem;
        }
        .footer a { color: var(--text-muted); text-decoration: none; }

        /* Troubleshoot */
        .trouble-item { margin-bottom: 15px; }
        .trouble-item summary {
            cursor: pointer;
            color: var(--accent-yellow);
            font-size: 0.85rem;
            padding: 6px 0;
        }
        .trouble-item summary:hover { color: var(--text-main); }
        .trouble-item p {
            color: var(--text-muted);
            font-size: 0.8rem;
            padding: 8px 0 0 18px;
        }

        @media (max-width: 600px) {
            .header h1 { font-size: 1.4rem; }
            .quick-nav { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">

    <a href="index.php" class="back-btn">← KEMBALI KE LAB</a>

    <div class="header">
        <h1>🛡️ Panduan Instalasi</h1>
        <p>> CYBERSHIELD 2026 — Setup Guide</p>
        <p style="margin-top:8px;">Lab Praktik Keamanan Web — <a href="https://instagram.com/Indradwi.25" target="_blank">@Indradwi.25</a></p>
    </div>

    <!-- Persyaratan -->
    <h2 style="font-size:0.9rem; margin-bottom:10px; color:var(--accent-cyan);">📋 PERSYARATAN SISTEM</h2>
    <table>
        <tr><th>Komponen</th><th>Versi / Syarat Minimum</th></tr>
        <tr><td>Koneksi Internet</td><td>✅ Wajib (untuk download & Docker)</td></tr>
        <tr><td>PHP</td><td>7.4+ (Rekomendasi: 8.x)</td></tr>
        <tr><td>MySQL</td><td>5.7+ atau MariaDB 10.x</td></tr>
        <tr><td>Web Server</td><td>Apache / Nginx / PHP Built-in</td></tr>
        <tr><td>Git</td><td>Opsional (Bisa download ZIP)</td></tr>
        <tr><td>Browser</td><td>Chrome / Firefox / Edge terbaru</td></tr>
    </table>

    <!-- Quick Navigation -->
    <h2 style="font-size:0.9rem; margin-bottom:10px; color:var(--accent-cyan);">🚀 PILIH METODE INSTALASI</h2>
    <div class="quick-nav">
        <a href="#xampp" onclick="openSection('xampp')">🟢 XAMPP <span class="label">⭐ Sangat Mudah</span></a>
        <a href="#laragon" onclick="openSection('laragon')">🔵 Laragon <span class="label">⭐ Sangat Mudah</span></a>
        <a href="#docker" onclick="openSection('docker')">🐳 Docker <span class="label">⭐⭐⭐ Menengah</span></a>
        <a href="#php-server" onclick="openSection('php-server')">⚡ PHP Server <span class="label">⭐⭐ Mudah</span></a>
        <a href="#linux-vps" onclick="openSection('linux-vps')" style="border-color:var(--accent-red);">🔥 Manual Linux VPS <span class="label" style="color:#ff6b6b;">⭐⭐⭐⭐⭐ Sulit</span></a>
    </div>

    <!-- ============================================ -->
    <!-- A. XAMPP                                     -->
    <!-- ============================================ -->
    <div class="section open" id="xampp">
        <div class="section-header" onclick="toggleSection(this)">
            <span class="icon">🟢</span>
            <h2>A. XAMPP <small style="color:var(--text-dim);">— Windows, Paling Mudah</small></h2>
            <span class="difficulty difficulty-easy">Mudah</span>
            <span class="toggle">▶</span>
        </div>
        <div class="section-body">
            <div class="section-content">

                <div class="step">
                    <h3>Langkah 1: Download & Install XAMPP</h3>
                    <ol>
                        <li>Buka <a href="https://www.apachefriends.org/download.html" target="_blank" style="color:var(--accent-cyan);">apachefriends.org/download</a></li>
                        <li>Download versi <strong>Windows (64-bit)</strong> — pilih PHP 8.x</li>
                        <li>Jalankan installer, klik <strong>Next</strong> terus sampai selesai</li>
                        <li>Lokasi instalasi default: <code>C:\xampp</code></li>
                    </ol>
                </div>

                <div class="step">
                    <h3>Langkah 2: Jalankan Apache & MySQL</h3>
                    <ol>
                        <li>Buka <strong>XAMPP Control Panel</strong> dari Start Menu</li>
                        <li>Klik <strong>Start</strong> pada <strong>Apache</strong></li>
                        <li>Klik <strong>Start</strong> pada <strong>MySQL</strong></li>
                        <li>Pastikan keduanya berwarna <strong style="color:var(--text-main);">hijau</strong></li>
                    </ol>
                </div>

                <div class="step">
                    <h3>Langkah 3: Copy File Lab</h3>
                    <p>Salin seluruh folder project ke dalam folder htdocs XAMPP:</p>
                    <pre><span class="comment"># Salin folder project ke htdocs</span>
<span class="cmd">C:\xampp\htdocs\cybershield2026\</span>

<span class="comment"># Atau via Git (Pastikan Git terinstall: git-scm.com):</span>
<span class="cmd">cd C:\xampp\htdocs</span>
<span class="cmd">git clone &lt;url-repo&gt; cybershield2026</span>

<span class="comment"># Atau jika tidak ada Git, klik tombol "Code" -> "Download ZIP" di GitHub.</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 4: Import Database</h3>
                    <p><strong style="color:var(--accent-cyan);">Cara A — phpMyAdmin (GUI):</strong></p>
                    <ol>
                        <li>Buka browser → <code>http://localhost/phpmyadmin</code></li>
                        <li>Klik tab <strong>Import</strong></li>
                        <li>Pilih file <code>setup_database.sql</code></li>
                        <li>Klik <strong>Go</strong></li>
                        <li>Ulangi untuk <code>setup_target.sql</code></li>
                    </ol>
                    <p style="margin-top:12px;"><strong style="color:var(--accent-cyan);">Cara B — Terminal (CMD):</strong></p>
                    <pre><span class="comment"># Masuk ke folder project</span>
<span class="cmd">cd C:\xampp\htdocs\cybershield2026</span>

<span class="cmd">C:\xampp\mysql\bin\mysql.exe -u root &lt; setup_database.sql</span>
<span class="cmd">C:\xampp\mysql\bin\mysql.exe -u root &lt; setup_target.sql</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 5: Buka di Browser</h3>
                    <pre><span class="url">http://localhost/cybershield2026/</span></pre>
                    <div class="info-box tip">✅ Selesai! Seluruh lab bisa diakses.</div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- B. LARAGON                                   -->
    <!-- ============================================ -->
    <div class="section" id="laragon">
        <div class="section-header" onclick="toggleSection(this)">
            <span class="icon">🔵</span>
            <h2>B. Laragon <small style="color:var(--text-dim);">— Windows, Ringan & Cepat</small></h2>
            <span class="difficulty difficulty-easy">Mudah</span>
            <span class="toggle">▶</span>
        </div>
        <div class="section-body">
            <div class="section-content">

                <div class="step">
                    <h3>Langkah 1: Download & Install</h3>
                    <ol>
                        <li>Buka <a href="https://laragon.org/download/" target="_blank" style="color:var(--accent-cyan);">laragon.org/download</a></li>
                        <li>Download <strong>Laragon Full</strong> (sudah termasuk PHP, MySQL, Apache, phpMyAdmin)</li>
                        <li>Install seperti biasa</li>
                    </ol>
                </div>

                <div class="step">
                    <h3>Langkah 2: Jalankan Laragon</h3>
                    <ol>
                        <li>Buka <strong>Laragon</strong></li>
                        <li>Klik tombol <strong>Start All</strong></li>
                    </ol>
                </div>

                <div class="step">
                    <h3>Langkah 3: Copy File Lab</h3>
                    <pre><span class="comment"># Salin folder project ke www Laragon</span>
<span class="cmd">C:\laragon\www\cybershield2026\</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 4: Import Database</h3>
                    <p>Klik kanan di Laragon → <strong>Terminal</strong>, lalu jalankan:</p>
                    <pre><span class="cmd">cd C:\laragon\www\cybershield2026</span>
<span class="cmd">mysql -u root &lt; setup_database.sql</span>
<span class="cmd">mysql -u root &lt; setup_target.sql</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 5: Buka di Browser</h3>
                    <pre><span class="url">http://localhost/cybershield2026/</span></pre>
                    <div class="info-box tip">💡 <strong>Tips:</strong> Laragon mendukung Pretty URL. Bisa akses via <code>http://cybershield2026.test/</code> secara otomatis.</div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- C. DOCKER                                    -->
    <!-- ============================================ -->
    <div class="section" id="docker">
        <div class="section-header" onclick="toggleSection(this)">
            <span class="icon">🐳</span>
            <h2>C. Docker <small style="color:var(--text-dim);">— Semua OS, Profesional</small></h2>
            <span class="difficulty difficulty-medium">Menengah</span>
            <span class="toggle">▶</span>
        </div>
        <div class="section-body">
            <div class="section-content">

                <div class="step">
                    <h3>Langkah 1: Install Docker</h3>
                    <p><strong style="color:var(--accent-cyan);">Windows:</strong></p>
                    <ol>
                        <li>Buka <a href="https://www.docker.com/products/docker-desktop/" target="_blank" style="color:var(--accent-cyan);">docker.com/products/docker-desktop</a></li>
                        <li>Download <strong>Docker Desktop for Windows</strong></li>
                        <li>Install dan restart jika diminta</li>
                        <li>Pastikan <strong>WSL 2</strong> sudah terinstall</li>
                    </ol>
                    <p style="margin-top:12px;"><strong style="color:var(--accent-cyan);">Linux (Ubuntu/Debian):</strong></p>
                    <pre><span class="cmd">sudo apt update</span>
<span class="cmd">sudo apt install docker.io docker-compose-plugin -y</span>
<span class="cmd">sudo systemctl start docker</span>
<span class="cmd">sudo systemctl enable docker</span>
<span class="cmd">sudo usermod -aG docker $USER</span>
<span class="comment"># Logout dan login kembali</span></pre>
                    <p style="margin-top:12px;"><strong style="color:var(--accent-cyan);">macOS:</strong></p>
                    <pre><span class="cmd">brew install --cask docker</span>
<span class="comment"># Atau download dari docker.com</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 2: Jalankan dengan Satu Perintah!</h3>
                    <p>Buka terminal, masuk ke folder project, lalu jalankan:</p>
                    <pre><span class="comment"># Masuk ke folder project (sesuaikan lokasi Anda)</span>
<span class="cmd">cd /lokasi/folder/cybershield2026</span>

<span class="cmd">docker compose up -d --build</span></pre>
                    <div class="info-box tip">Docker otomatis membangun image PHP+Apache, menjalankan MySQL, dan mengimport database.</div>
                </div>

                <div class="step">
                    <h3>Langkah 3: Buka di Browser</h3>
                    <table>
                        <tr><th>Layanan</th><th>URL</th></tr>
                        <tr><td>🌐 Lab Web</td><td><span class="url">http://localhost:8080</span></td></tr>
                        <tr><td>🗄️ phpMyAdmin</td><td><span class="url">http://localhost:8081</span></td></tr>
                    </table>
                </div>

                <div class="step">
                    <h3>Perintah Docker Berguna</h3>
                    <pre><span class="comment"># Lihat status container</span>
<span class="cmd">docker compose ps</span>

<span class="comment"># Log real-time</span>
<span class="cmd">docker compose logs -f web</span>

<span class="comment"># Hentikan semua</span>
<span class="cmd">docker compose down</span>

<span class="comment"># Hentikan + hapus data DB</span>
<span class="cmd">docker compose down -v</span>

<span class="comment"># Restart setelah edit kode</span>
<span class="cmd">docker compose restart web</span></pre>
                </div>

                <div class="info-box warn">
                    ⚠️ <strong>Catatan Docker:</strong> Di dalam Docker, koneksi DB harus ke hostname <code>db</code> (bukan <code>127.0.0.1</code>).
                    <pre style="margin:8px 0 0; border:none; padding:8px;"><span class="comment">// Edit koneksi PHP untuk Docker:</span>
<span class="cmd">$host = getenv('DB_HOST') ?: '127.0.0.1';</span>
<span class="cmd">$conn = new mysqli($host, "root", "", "cybershield_lab");</span></pre>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- D. PHP BUILT-IN SERVER                       -->
    <!-- ============================================ -->
    <div class="section" id="php-server">
        <div class="section-header" onclick="toggleSection(this)">
            <span class="icon">⚡</span>
            <h2>D. PHP Built-in Server <small style="color:var(--text-dim);">— Tanpa Install Tambahan</small></h2>
            <span class="difficulty difficulty-easy">Mudah</span>
            <span class="toggle">▶</span>
        </div>
        <div class="section-body">
            <div class="section-content">

                <div class="step">
                    <h3>Langkah 1: Pastikan PHP & MySQL Tersedia</h3>
                    <pre><span class="cmd">php -v</span>      <span class="comment"># Harus muncul versi PHP</span>
<span class="cmd">mysql -V</span>    <span class="comment"># Harus muncul versi MySQL</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 2: Import Database</h3>
                    <p><strong style="color:var(--accent-cyan);">PowerShell (Windows):</strong></p>
                    <pre><span class="comment"># Masuk ke folder project (sesuaikan path)</span>
<span class="cmd">cd C:\xampp\htdocs\cybershield2026</span>

<span class="cmd">cmd /c "mysql -u root &lt; setup_database.sql"</span>
<span class="cmd">cmd /c "mysql -u root &lt; setup_target.sql"</span></pre>
                    <p style="margin-top:12px;"><strong style="color:var(--accent-cyan);">Bash (Linux/macOS):</strong></p>
                    <pre><span class="comment"># Masuk ke folder project (sesuaikan path)</span>
<span class="cmd">cd ~/cybershield2026</span>

<span class="cmd">mysql -u root &lt; setup_database.sql</span>
<span class="cmd">mysql -u root &lt; setup_target.sql</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 3: Jalankan Server</h3>
                    <p>Dari folder project yang sama, jalankan:</p>
                    <pre><span class="cmd">php -S 0.0.0.0:8000</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 4: Buka di Browser</h3>
                    <pre><span class="url">http://localhost:8000</span></pre>
                    <div class="info-box tip">✅ Selesai!</div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- E. MANUAL LINUX VPS                          -->
    <!-- ============================================ -->
    <div class="section" id="linux-vps">
        <div class="section-header" onclick="toggleSection(this)">
            <span class="icon">🔥</span>
            <h2>E. Manual Linux VPS <small style="color:var(--text-dim);">— Dari Nol di Server Sendiri</small></h2>
            <span class="difficulty" style="color:var(--accent-red); border-color:var(--accent-red);">Sulit</span>
            <span class="toggle">▶</span>
        </div>
        <div class="section-body">
            <div class="section-content">

                <div class="info-box warn">🧠 Metode ini untuk yang ingin belajar <strong>sysadmin dari nol</strong>. Cocok jika Anda punya VPS (DigitalOcean, Vultr, Linode, AWS EC2) atau VM lokal.</div>

                <div class="step">
                    <h3>Langkah 1: Update Sistem & Install LAMP Stack</h3>
                    <p>SSH ke server Anda, lalu install Apache, MySQL, dan PHP secara manual:</p>
                    <pre><span class="comment"># Update repositori</span>
<span class="cmd">sudo apt update && sudo apt upgrade -y</span>

<span class="comment"># Install Apache Web Server</span>
<span class="cmd">sudo apt install apache2 -y</span>
<span class="cmd">sudo systemctl enable apache2</span>
<span class="cmd">sudo systemctl start apache2</span>

<span class="comment"># Install MySQL Server</span>
<span class="cmd">sudo apt install mysql-server -y</span>
<span class="cmd">sudo systemctl enable mysql</span>
<span class="cmd">sudo systemctl start mysql</span>

<span class="comment"># Install PHP + ekstensi yang dibutuhkan</span>
<span class="cmd">sudo apt install php libapache2-mod-php php-mysql php-cli php-curl php-xml php-mbstring -y</span>

<span class="comment"># Verifikasi</span>
<span class="cmd">apache2 -v</span>
<span class="cmd">mysql --version</span>
<span class="cmd">php -v</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 2: Konfigurasi MySQL (Buat User & Database)</h3>
                    <pre><span class="comment"># Masuk ke MySQL sebagai root</span>
<span class="cmd">sudo mysql</span>

<span class="comment">-- Di dalam MySQL shell:</span>
<span class="cmd">CREATE DATABASE cybershield_lab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</span>
<span class="cmd">ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';</span>
<span class="cmd">FLUSH PRIVILEGES;</span>
<span class="cmd">EXIT;</span>

<span class="comment"># Import data</span>
<span class="cmd">mysql -u root < /var/www/html/cybershield2026/setup_database.sql</span>
<span class="cmd">mysql -u root < /var/www/html/cybershield2026/setup_target.sql</span></pre>
                    <div class="info-box tip">💡 Jika ingin menggunakan password untuk root, jangan lupa update koneksi di file PHP.</div>
                </div>

                <div class="step">
                    <h3>Langkah 3: Clone / Upload Project</h3>
                    <pre><span class="comment"># Clone project ke DocumentRoot Apache</span>
<span class="cmd">cd /var/www/html</span>
<span class="cmd">sudo git clone &lt;url-repo&gt; cybershield2026</span>

<span class="comment"># Set permission agar Apache bisa baca/tulis</span>
<span class="cmd">sudo chown -R www-data:www-data /var/www/html/cybershield2026</span>
<span class="cmd">sudo chmod -R 755 /var/www/html/cybershield2026</span>

<span class="comment"># Buat folder uploads untuk lab File Upload</span>
<span class="cmd">sudo mkdir -p /var/www/html/cybershield2026/15_File_Upload/uploads</span>
<span class="cmd">sudo chmod 777 /var/www/html/cybershield2026/15_File_Upload/uploads</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 4: Konfigurasi Apache VirtualHost</h3>
                    <pre><span class="comment"># Buat file VirtualHost baru</span>
<span class="cmd">sudo nano /etc/apache2/sites-available/cybershield.conf</span></pre>
                    <p>Isi dengan konfigurasi berikut:</p>
                    <pre><span class="cmd">&lt;VirtualHost *:80&gt;</span>
    <span class="cmd">ServerName cybershield.local</span>
    <span class="cmd">DocumentRoot /var/www/html/cybershield2026</span>

    <span class="cmd">&lt;Directory /var/www/html/cybershield2026&gt;</span>
        <span class="cmd">AllowOverride All</span>
        <span class="cmd">Require all granted</span>
    <span class="cmd">&lt;/Directory&gt;</span>

    <span class="cmd">ErrorLog ${APACHE_LOG_DIR}/cybershield_error.log</span>
    <span class="cmd">CustomLog ${APACHE_LOG_DIR}/cybershield_access.log combined</span>
<span class="cmd">&lt;/VirtualHost&gt;</span></pre>
                    <pre><span class="comment"># Aktifkan site dan mod_rewrite</span>
<span class="cmd">sudo a2ensite cybershield.conf</span>
<span class="cmd">sudo a2enmod rewrite</span>
<span class="cmd">sudo systemctl restart apache2</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 5: Konfigurasi Firewall (UFW)</h3>
                    <pre><span class="comment"># Aktifkan firewall</span>
<span class="cmd">sudo ufw enable</span>

<span class="comment"># Izinkan SSH (PENTING! Jangan sampai terkunci)</span>
<span class="cmd">sudo ufw allow 22/tcp</span>

<span class="comment"># Izinkan HTTP dan HTTPS</span>
<span class="cmd">sudo ufw allow 80/tcp</span>
<span class="cmd">sudo ufw allow 443/tcp</span>

<span class="comment"># Cek status</span>
<span class="cmd">sudo ufw status verbose</span></pre>
                    <div class="info-box danger">⚠️ <strong>JANGAN</strong> expose port MySQL (3306) ke publik! Database hanya boleh diakses dari localhost.</div>
                </div>

                <div class="step">
                    <h3>Langkah 6: Hardening (Opsional tapi Direkomendasikan)</h3>
                    <pre><span class="comment"># Disable directory listing</span>
<span class="cmd">sudo sed -i 's/Options Indexes/Options -Indexes/' /etc/apache2/apache2.conf</span>

<span class="comment"># Sembunyikan versi Apache & PHP</span>
<span class="cmd">echo 'ServerTokens Prod' | sudo tee -a /etc/apache2/conf-enabled/security.conf</span>
<span class="cmd">echo 'ServerSignature Off' | sudo tee -a /etc/apache2/conf-enabled/security.conf</span>
<span class="cmd">sudo sed -i 's/expose_php = On/expose_php = Off/' /etc/php/*/apache2/php.ini</span>

<span class="comment"># Restart Apache</span>
<span class="cmd">sudo systemctl restart apache2</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 7: (Bonus) HTTPS dengan Let's Encrypt</h3>
                    <p>Jika Anda punya domain yang mengarah ke server:</p>
                    <pre><span class="comment"># Install Certbot</span>
<span class="cmd">sudo apt install certbot python3-certbot-apache -y</span>

<span class="comment"># Generate SSL (ganti domain Anda)</span>
<span class="cmd">sudo certbot --apache -d cybershield.domain-anda.com</span>

<span class="comment"># Auto-renew (sudah otomatis via systemd timer)</span>
<span class="cmd">sudo certbot renew --dry-run</span></pre>
                </div>

                <div class="step">
                    <h3>Langkah 8: Buka di Browser</h3>
                    <pre><span class="url">http://IP-SERVER-ANDA/cybershield2026/</span>
<span class="comment"># atau jika pakai VirtualHost:</span>
<span class="url">http://cybershield.local/</span></pre>
                    <div class="info-box tip">✅ Selesai! Anda baru saja meng-deploy lab dari nol menggunakan LAMP stack.</div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- KONFIGURASI DATABASE                         -->
    <!-- ============================================ -->
    <h2 style="font-size:0.9rem; margin: 35px 0 15px; color:var(--accent-cyan);">🔧 KONFIGURASI DATABASE</h2>
    <div style="border:1px solid var(--text-dim); background:var(--bg-card); padding:20px; margin-bottom:25px;">
        <p style="color:var(--text-muted); font-size:0.82rem; margin-bottom:12px;">Semua file PHP menggunakan koneksi berikut:</p>
        <pre><span class="cmd">$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");</span></pre>
        <table class="config-table">
            <tr><th>Parameter</th><th>Nilai</th></tr>
            <tr><td>Host</td><td>127.0.0.1 <span style="color:var(--text-dim);">(atau <code>db</code> untuk Docker)</span></td></tr>
            <tr><td>Username</td><td>root</td></tr>
            <tr><td>Password</td><td><em style="color:var(--text-dim);">(kosong)</em></td></tr>
            <tr><td>Database</td><td>cybershield_lab</td></tr>
        </table>
        <p style="color:var(--text-muted); font-size:0.82rem; margin-top:12px;">File SQL yang harus diimport:</p>
        <table>
            <tr><th>File</th><th>Isi</th></tr>
            <tr><td><code>setup_database.sql</code></td><td>Tabel users, products, comments + data dummy</td></tr>
            <tr><td><code>setup_target.sql</code></td><td>Tabel news untuk lab SQLi Portal Berita</td></tr>
        </table>
    </div>

    <!-- ============================================ -->
    <!-- TROUBLESHOOTING                              -->
    <!-- ============================================ -->
    <h2 style="font-size:0.9rem; margin: 35px 0 15px; color:var(--accent-cyan);">❓ TROUBLESHOOTING</h2>
    <div style="border:1px solid var(--text-dim); background:var(--bg-card); padding:20px; margin-bottom:25px;">
        <details class="trouble-item">
            <summary>"Access denied for user 'root'"</summary>
            <p>Pastikan MySQL mengizinkan login tanpa password. Di XAMPP, user root defaultnya tanpa password. Jika menggunakan password, edit koneksi di file PHP.</p>
        </details>
        <details class="trouble-item">
            <summary>"Table doesn't exist"</summary>
            <p>Anda belum mengimport database. Jalankan: <code>mysql -u root < setup_database.sql</code></p>
        </details>
        <details class="trouble-item">
            <summary>Halaman blank / putih</summary>
            <p>Aktifkan error reporting: <code>error_reporting(E_ALL); ini_set('display_errors', 1);</code></p>
        </details>
        <details class="trouble-item">
            <summary>Port 80 sudah dipakai (XAMPP)</summary>
            <p>Kemungkinan IIS atau Skype menggunakan port 80. Ubah port Apache ke 8080 di file <code>httpd.conf</code>.</p>
        </details>
        <details class="trouble-item">
            <summary>Docker: "Cannot connect to MySQL"</summary>
            <p>Pastikan container db sudah sehat: <code>docker compose ps</code>. Ganti host dari 127.0.0.1 ke <code>db</code> di file PHP.</p>
        </details>
    </div>

    <!-- ============================================ -->
    <!-- WARNING                                      -->
    <!-- ============================================ -->
    <div class="info-box danger" style="padding:20px; margin-top:30px; text-align:center;">
        <p style="font-size:0.9rem; margin-bottom:8px;">⚠️ <strong>PERINGATAN KEAMANAN</strong></p>
        <p style="font-size:0.78rem;">Lab ini berisi kode yang <strong>SENGAJA DIBUAT RENTAN</strong> untuk edukasi.<br>
        <strong>JANGAN</strong> deploy ke server publik. Pelanggaran dikenai <strong>UU ITE Pasal 30-33</strong> (pidana hingga 10 tahun).</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Created by <a href="https://instagram.com/Indradwi.25" target="_blank">Indra — @Indradwi.25</a></p>
        <p style="margin-top:5px;">CYBERSHIELD 2026 — HIMTIF Universitas Pamulang</p>
    </div>

</div>

<script>
    function toggleSection(header) {
        const section = header.parentElement;
        section.classList.toggle('open');
    }

    function openSection(id) {
        const section = document.getElementById(id);
        if (section && !section.classList.contains('open')) {
            section.classList.add('open');
        }
        setTimeout(() => {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }

    // Copy button for all <pre> blocks
    document.querySelectorAll('pre').forEach(block => {
        const btn = document.createElement('button');
        btn.className = 'copy-btn';
        btn.textContent = 'COPY';
        btn.onclick = () => {
            const text = block.innerText.replace('COPY', '').trim();
            navigator.clipboard.writeText(text).then(() => {
                btn.textContent = '✓ OK';
                setTimeout(() => btn.textContent = 'COPY', 1500);
            });
        };
        block.style.position = 'relative';
        block.appendChild(btn);
    });
</script>

</body>
</html>
