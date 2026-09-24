<?php
// Lab 17: Open Redirect (Vulnerable)
// Skenario: 
// 1. GET Parameter dengan filter lemah
// 2. Referer Header berbasis Open Redirect
// 3. X-Forwarded-Host Header Injection berbasis Open Redirect

$url = $_GET['url'] ?? '';
$action = $_GET['action'] ?? '';

// SCENARIO 2: Logout Redirect based on Referer
if ($action === 'logout') {
    // RENTAN: Langsung mempercayai HTTP_REFERER dari pengguna
    $referer = $_SERVER['HTTP_REFERER'] ?? 'vuln.php';
    header("Location: $referer");
    exit;
}

// SCENARIO 3: Login Redirect based on Host / X-Forwarded-Host
if ($action === 'login') {
    // RENTAN: Mempercayai X-Forwarded-Host yang dikirim oleh pengguna
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'luckysoraa.co-id.id';
    header("Location: http://$host/dashboard");
    exit;
}

// SCENARIO 1: GET Parameter Redirect
if (!empty($url)) {
    // ⚠️ RENTAN: Filter Sangat Lemah (Hanya menggunakan strpos)
    $whitelist = 'luckysoraa.co-id.id';

    if (strpos($url, $whitelist) !== false) {
        // ⚠️ Eksekusi Redirect!
        header("Location: $url");
        exit;
    } else {
        // Diblokir
        echo "<body style='background:#050505; color:#FF003C; font-family:monospace; padding:40px;'>";
        echo "<h3>[ BLOCKED ] </h3>";
        echo "<p>URL tujuan tidak valid! Tautan harus mengandung string: $whitelist</p>";
        echo "</body>";
        exit;
    }
}

// Halaman antarmuka utama
$html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lab 17 - Open Redirect (Vuln)</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #050505; color: #00FF41; font-family: 'Fira Code', monospace; padding: 40px; }
        .terminal { border: 1px solid #FF003C; padding: 20px; box-shadow: 0 0 15px rgba(255,0,60,0.3); background: rgba(20,0,0,0.8); margin-bottom: 20px; }
        a { color: #39ff14; }
        h2 { color: #FF003C; text-transform: uppercase; margin-bottom: 10px; }
        h3 { color: #FF003C; margin-top: 15px; border-bottom: 1px dashed #FF003C; display: inline-block;}
        code, pre { background: rgba(255,0,60,0.1); padding: 2px 6px; border: 1px solid rgba(255,0,60,0.3); }
        pre { padding: 15px; overflow-x: auto; font-size: 0.9rem; margin: 10px 0; border-left: 3px solid #FF003C;}
    </style>
</head>
<body>
    <div class="terminal">
        <h2>[!] VULNERABLE: OPEN REDIRECT LABS</h2>
        <p>> Sistem ini memiliki 3 celah Open Redirect yang umum ditemukan di Bug Bounty.</p>
        
        <h3>1. GET Parameter Manipulation (?url=)</h3>
        <p>Sistem mencoba memfilter URL dengan <code>strpos()</code> untuk mencari string <code>luckysoraa.co-id.id</code>.</p>
        <ul>
            <li><a href="?url=https://google.com%23luckysoraa.co-id.id">Bypass ke Google (via Fragment Hash)</a></li>
            <li><a href="?url=https://evil.com/luckysoraa.co-id.id">Bypass ke Evil.com (via Path)</a></li>
        </ul>

        <h3>2. Unvalidated HTTP Referer</h3>
        <p>Saat pengguna melakukan <a href="?action=logout">Logout</a>, sistem mengalihkan mereka kembali ke halaman sebelumnya menggunakan header <code>Referer</code> tanpa divalidasi.</p>
        
        <h4>[EXPLOIT] Python Script untuk Unvalidated Referer</h4>
        <p>Gunakan script Python di bawah ini (membutuhkan library <code>requests</code>) untuk membuktikan bahwa server mengambil header Referer penyerang mentah-mentah:</p>
<pre><code>import requests

target_url = "http://luckysoraa.co-id.id/17_Open_Redirect/vuln.php?action=logout"
evil_url = "https://google.com"

headers = {
    "Referer": evil_url,
    "User-Agent": "Mozilla/5.0 (Hacker/1.0)"
}

print(f"[*] Mengirim request eksploitasi ke {target_url}...")
print(f"[*] Menyisipkan Header Referer: {evil_url}\\n")

# Cegah otomatis follow redirect untuk melihat respon asli server
response = requests.get(target_url, headers=headers, allow_redirects=False)

if response.status_code in [301, 302, 303, 307, 308]:
    location = response.headers.get('Location')
    print("[+] BERHASIL: Server merespons dengan HTTP Redirect (302)!")
    print(f"[+] Server mengarahkan kita ke: {location}")
    if location == evil_url:
        print("[!] VULN CONFIRMED: Open Redirect via Unvalidated Referer sukses!")
else:
    print("[-] GAGAL: Tidak ada pengalihan (redirect).")</code></pre>

        <h3>3. Host Header Injection (X-Forwarded-Host)</h3>
        <p>Saat pengguna melakukan <a href="?action=login">Login</a>, sistem membuat link dinamis berbasis header Host. Jika terdapat proxy, ia mempercayai <code>X-Forwarded-Host</code>.</p>
        <p style="color: var(--text-muted);">> <strong>Eksploitasi:</strong> Kirim request ke <code>?action=login</code> dengan menambahkan header <code>X-Forwarded-Host: bing.com</code>. Aplikasi akan mengalihkan ke <code>http://bing.com/dashboard</code>.</p>
        
        <hr style="border: 1px dashed #FF003C; margin: 30px 0;">
        <h2>[?] DETAIL DAMPAK & CARA KERJA (IMPACT)</h2>
        <p>Kerentanan Open Redirect mungkin terlihat "hanya mengalihkan halaman", tetapi di tangan aktor ancaman yang andal, dampaknya bisa sangat kritis.</p>
        
        <br>
        <h3 style="margin-top:0;">1. Phishing Kredensial Berkualitas Tinggi</h3>
        <p style="margin-top: 5px;"><strong>Cara Kerja:</strong> Penyerang akan membuat tiruan halaman *login* yang bentuknya sama persis dengan situs `luckysoraa.co-id.id`. Penyerang kemudian mengirim link eksploitasi <code>luckysoraa.co-id.id/vuln.php?url=https://evil.com/login</code> ke email korban.</p>
        <p><strong>Dampak:</strong> Korban mengecek URL di browser dan melihat awalan link adalah domain institusi asli (`luckysoraa.co-id.id`), sehingga korban percaya. Saat diklik, korban diarahkan mulus ke `evil.com/login`. Karena korban percaya, mereka akan memasukkan <i>username</i> dan <i>password</i>. Kredensial berhasil dicuri.</p>
        
        <br>
        <h3>2. Pencurian Token / Session OAuth (Token Leakage)</h3>
        <p style="margin-top: 5px;"><strong>Cara Kerja:</strong> Banyak aplikasi modern menggunakan SSO atau OAuth. Saat *login* berhasil, server otentikasi akan mengirim *Access Token* di URL. Jika aplikasi klien rentan terhadap Open Redirect di bagian parameter <code>redirect_uri</code> atau header `Referer`, penyerang dapat mencegat respon otentikasi tersebut.</p>
        <p><strong>Dampak:</strong> Token akses yang sangat sensitif (sering kali memberikan akses administratif penuh ke akun pengguna) dikirim (bocor) ke <i>server log</i> milik penyerang. Penyerang dapat menyalin token itu dan mengambil alih sesi korban tanpa membutuhkan <i>password</i>.</p>

        <br>
        <h3>3. Cross-Site Scripting (XSS) via Protocol Scheme</h3>
        <p style="margin-top: 5px;"><strong>Cara Kerja:</strong> Jika aplikasi tidak memvalidasi skema protokol (seperti `http://` atau `https://`), penyerang bisa memberikan protokol `javascript:` atau `data:`.</p>
        <p><strong>Dampak:</strong> Jika pengguna mengklik tautan atau halaman memuat ulang secara otomatis (misalnya melalui tag <code>meta refresh</code> atau <code>window.location</code>), eksploit akan dijalankan: <code>javascript:alert(document.cookie)</code>. Penyerang sukses mencuri <i>cookie</i> sesi pengguna dan membajak akun (Account Takeover).</p>

        <br>
        <h3>4. Melewati Filter SSRF (Server-Side Request Forgery)</h3>
        <p style="margin-top: 5px;"><strong>Cara Kerja:</strong> Beberapa aplikasi memiliki fitur untuk mengunduh gambar/file dari internet (misal: *fetch URL*). Jika aplikasi ini rentan SSRF tetapi memiliki filter yang membatasi pengambilan file *hanya dari domain sendiri*, penyerang bisa memanfaatkan *Open Redirect*.</p>
        <p><strong>Dampak:</strong> Penyerang meminta server mengunduh dari <code>http://domain-sendiri.com/redirect?url=http://169.254.169.254/metadata</code> (IP metadata cloud). Server akan mengizinkan request awal, mengikuti *redirect*, dan akhirnya membocorkan kredensial <i>Cloud Infrastructure</i> (AWS/GCP).</p>

    </div>
</body>
</html>
HTML;
echo $html;
?>
