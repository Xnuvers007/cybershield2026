<div align="center">

# 🛡️ CYBERSHIELD 2026

### From Code to Zero — OWASP Top 10 Security Lab

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
[![OWASP](https://img.shields.io/badge/OWASP-Top_10_(2021)-000000?style=for-the-badge&logo=owasp&logoColor=white)](https://owasp.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-10b981?style=for-the-badge)](LICENSE)

> *Lab praktik keamanan web interaktif berbasis OWASP Top 10 (2026)*  
> **HIMTIF — Universitas Pamulang** | Webinar 24 September 2026

---

</div>

## 📸 Screenshot

| Portal Utama | Presentasi Interaktif |
|:---:|:---:|
| ![Portal](https://img.shields.io/badge/🖥️-Hacker_Theme_Portal-000?style=flat-square) | ![Presentasi](https://img.shields.io/badge/📊-22+_Slides-111128?style=flat-square) |

---

## ⚠️ DISCLAIMER

> **🔴 WAJIB DIBACA SEBELUM MENGGUNAKAN LAB INI**

Seluruh kode dalam repositori ini dibuat **KHUSUS untuk tujuan edukasi**. Kode yang ada **SENGAJA mengandung kerentanan** keamanan sebagai bahan pembelajaran.

| ❌ DILARANG | ✅ DIIZINKAN |
|---|---|
| Menyerang sistem tanpa izin tertulis | Belajar di environment lokal sendiri |
| Meng-deploy ke server production publik | Menggunakan sebagai bahan ajar/presentasi |
| Mengeksploitasi data pengguna nyata | Penetration testing dengan izin tertulis |

**Pelanggaran dikenai sanksi pidana:**
- **UU ITE Pasal 30** — Penjara 6-8 Tahun
- **UU ITE Pasal 32** — Denda 2 Miliar Rupiah
- **UU ITE Pasal 33** — Penjara 10 Tahun

📄 Baca disclaimer lengkap: [`DISCLAIMER.md`](DISCLAIMER.md)

---

## 🚀 Quick Start

```bash
# 1. Clone repositori
git clone <url-repo> pelatihancyber
cd pelatihancyber

# 2. Import database
mysql -u root < setup_database.sql
mysql -u root < setup_target.sql

# 3. Jalankan server
php -S 0.0.0.0:8000

# 4. Buka di browser
# http://localhost:8000
```

> 📖 **Panduan instalasi lengkap** (XAMPP, Laragon, Docker, Manual Linux VPS):  
> Buka [`install.php`](install.php) di browser atau baca [`INSTALL.md`](INSTALL.md)

---

## 🐳 Docker (Satu Perintah!)

```bash
docker compose up -d --build
```

| Layanan | URL |
|---------|-----|
| 🌐 Lab Web | `http://localhost:8080` |
| 🗄️ phpMyAdmin | `http://localhost:8081` |

---

## 📋 Daftar Lab Kerentanan

### OWASP Top 10 (2026)

| # | Folder | Kategori | Kerentanan | Severity |
|:-:|--------|----------|------------|:--------:|
| 01 | `01_Broken_Access_Control/` | A01:2021 | IDOR, Privilege Escalation | 🔴 Critical |
| 02 | `02_Cryptographic_Failures/` | A02:2021 | Plaintext Password, MD5 vs Bcrypt | 🟠 High |
| 03 | `03_Injection/` | A03:2021 | SQL Injection, Login Bypass | 🔴 Critical |
| 04 | `04_Insecure_Design/` | A04:2021 | Business Logic Flaw, No Rate Limit | 🟡 Medium |
| 05 | `05_Security_Misconfiguration/` | A05:2021 | Error Leak, Debug Mode, Headers | 🟠 High |
| 06 | `06_Vulnerable_Components/` | A06:2021 | Simulasi CVE, Outdated Library | 🟠 High |
| 07 | `07_Auth_Failures/` | A07:2021 | Session Fixation, Weak Auth | 🔴 Critical |
| 08 | `08_Data_Integrity_Failures/` | A08:2021 | Insecure Deserialization | 🟠 High |
| 09 | `09_Logging_Monitoring_Failures/` | A09:2021 | Audit Trail Bypass | 🟡 Medium |
| 10 | `10_SSRF/` | A10:2021 | Server-Side Request Forgery | 🟠 High |

### Bonus Labs

| # | Folder | Kerentanan | Deskripsi |
|:-:|--------|------------|-----------|
| 11 | `11_LFI/` | Local File Inclusion | Membaca file sensitif server |
| 12 | `12_RCE/` | Remote Code Execution | Command Injection via input |
| 13 | `13_XXE/` | XML External Entity | XXE Basic + Online Shop Logic Flaw |
| 14 | `14_Zombie_Cookies/` | Persistent Tracking | Tracking via LocalStorage |
| 15 | `15_File_Upload/` | Unrestricted Upload | MIME Manipulation & Defacement |
| 16 | `16_SQLi_News/` | SQL Injection Advanced | Error-based, UNION, DIOS |
| 17 | `17_Open_Redirect/` | Unvalidated Redirect | Phishing via trusted domain |
| ★ | `bonus_XSS/` | Cross-Site Scripting | Reflected & Stored XSS |

> Setiap folder berisi **`vuln.php`** (kode rentan) dan **`secure.php`** (kode aman) untuk perbandingan langsung.

---

## 🎯 CyberBoard — Target Web Application

Aplikasi web target lengkap untuk simulasi serangan berantai (*attack chaining*).

```
📂 CyberTarget_Web/
├── 🔴 vuln/    → Versi rentan (SQLi Login Bypass, Stored XSS, IDOR, LFI, Bruteforce)
└── 🟢 secure/  → Versi aman (Prepared Statement, CSRF Token, Rate Limiting)
```

---

## 🗂️ Struktur Proyek

```
pelatihancyber/
│
├── 📄 index.php                    # Portal utama (hacker theme + matrix rain)
├── 📊 presentasi.html              # Slide presentasi interaktif (22+ slides)
├── 📝 contekan_security.php        # Live cheat sheet: kode salah vs benar
├── 🔧 install.php                  # Panduan instalasi interaktif
├── 🎮 quiz_kahoot.md               # Bank soal kuis Kahoot
│
├── 🗄️ setup_database.sql           # Database utama (users, products, comments)
├── 🗄️ setup_target.sql             # Database portal berita (SQLi News)
├── 🔄 reset_all.php                # Reset seluruh lab ke kondisi awal
│
├── 🐳 Dockerfile                   # Docker image (PHP 8.2 + Apache)
├── 🐳 docker-compose.yml           # Docker Compose (Web + MySQL + phpMyAdmin)
│
├── 📂 01_Broken_Access_Control/    # Lab A01 (vuln.php + secure.php)
├── 📂 02_Cryptographic_Failures/   # Lab A02
├── 📂 ...                          # Lab A03 - A10
├── 📂 11_LFI/ ~ 17_Open_Redirect/ # Bonus Labs
├── 📂 bonus_XSS/                   # XSS Lab
│
├── 📂 CyberTarget_Web/             # Aplikasi target lengkap
├── 📂 Animasi/                     # Animasi visual kerentanan
├── 📂 Wordlists_and_Scripts/       # Payload & wordlist untuk testing
└── 📂 praktek/                     # Playground latihan mandiri
```

---

## 🔑 Akun Lab (Testing)

| Username | Password | Role | Keterangan |
|----------|----------|:----:|------------|
| `admin` | `admin123` | 👑 Admin | Akun utama lab |
| `user1` | `user1234` | 👤 User | Akun user biasa |
| `user2` | `belajar567` | 👤 User | Akun user biasa |

**Akun CyberBoard (Target Web):**

| Username | Password | Role |
|----------|----------|:----:|
| `admin` | `CyberAdmin2026!` | 👑 Admin |
| `hacker_wannabe` | `password123` | 👤 User |

> ⚠️ Password ini **HANYA** untuk lab edukasi. Jangan gunakan di environment production!

---

## 🔧 Konfigurasi Database

```php
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");
```

| Parameter | Nilai |
|-----------|-------|
| Host | `127.0.0.1` (atau `db` untuk Docker) |
| Username | `root` |
| Password | *(kosong)* |
| Database | `cybershield_lab` |

---

## 📊 Presentasi

Buka **`presentasi.html`** di browser untuk presentasi interaktif OWASP Top 10.

| Tombol | Fungsi |
|--------|--------|
| `←` `→` | Navigasi slide |
| `F` | Fullscreen |
| `Esc` | Keluar fullscreen |
| `Home` / `End` | Slide pertama / terakhir |
| Swipe | Navigasi di mobile |

---

## 📚 Referensi & Sumber Belajar

| Sumber | Link |
|--------|------|
| OWASP Top 10 (2026) | [owasp.org/www-project-top-ten](https://owasp.org/www-project-top-ten/) |
| OWASP Cheat Sheet Series | [cheatsheetseries.owasp.org](https://cheatsheetseries.owasp.org/) |
| OWASP Testing Guide | [owasp.org/www-project-web-security-testing-guide](https://owasp.org/www-project-web-security-testing-guide/) |
| PHP Security Best Practices | [php.net/manual/en/security.php](https://www.php.net/manual/en/security.php) |
| PortSwigger Web Academy | [portswigger.net/web-security](https://portswigger.net/web-security) |
| HackTheBox Academy | [academy.hackthebox.com](https://academy.hackthebox.com/) |
| UU ITE — UU No. 27/2008 | [peraturan.bpk.go.id](https://peraturan.bpk.go.id/Details/38723/uu-no-27-tahun-2008) |

---

<div align="center">

## 🏛️ Kredit

**Webinar HIMTIF: CYBERSHIELD 2026**  
Universitas Pamulang — Program Studi Teknik Informatika

Created by **[Indra](https://instagram.com/Indradwi.25)** | 📷 [@Indradwi.25](https://instagram.com/Indradwi.25)

---

```
╔══════════════════════════════════════════════════╗
║  🔐 Hack Responsibly. Learn Ethically.           ║
║  💻 Code Securely. Protect Always.               ║
╚══════════════════════════════════════════════════╝
```

</div>
