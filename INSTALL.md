# 🛡️ CYBERSHIELD 2026 — Panduan Instalasi Lengkap

> Lab Praktik Keamanan Web — OWASP Top 10  
> HIMTIF Universitas Pamulang

---

## 📋 Persyaratan Sistem

| Komponen | Versi Minimum |
|----------|---------------|
| Koneksi Internet | ✅ Wajib (untuk download & Docker) |
| PHP      | 7.4+ (Rekomendasi: 8.x) |
| MySQL    | 5.7+ atau MariaDB 10.x |
| Web Server | Apache / Nginx / PHP Built-in Server |
| Git      | Opsional (Bisa pakai Download ZIP) |
| Browser  | Chrome / Firefox / Edge (terbaru) |

---

## 🚀 Pilih Metode Instalasi

Ada **4 cara** untuk menjalankan lab ini. Pilih yang paling sesuai:

| Metode | Tingkat Kesulitan | Cocok Untuk |
|--------|-------------------|-------------|
| [A. XAMPP](#a-xampp-windows---paling-mudah) | ⭐ Sangat Mudah | Pemula di Windows |
| [B. Laragon](#b-laragon-windows---ringan--cepat) | ⭐ Sangat Mudah | Pemula di Windows |
| [C. Docker](#c-docker-semua-os---paling-profesional) | ⭐⭐⭐ Menengah | Semua OS, sudah familiar terminal |
| [D. PHP Built-in Server](#d-php-built-in-server-tanpa-install-apapun) | ⭐⭐ Mudah | Sudah punya PHP & MySQL terinstall |

---

## A. XAMPP (Windows — Paling Mudah)

### Langkah 1: Download & Install XAMPP

1. Buka [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
2. Download versi **Windows (64-bit)** — pilih PHP 8.x
3. Jalankan installer, klik **Next** terus sampai selesai
4. Lokasi instalasi default: `C:\xampp`

### Langkah 2: Jalankan Apache & MySQL

1. Buka **XAMPP Control Panel** (cari di Start Menu)
2. Klik **Start** pada **Apache**
3. Klik **Start** pada **MySQL**
4. Pastikan keduanya berwarna **hijau**

### Langkah 3: Copy File Lab

```
Salin seluruh folder "cybershield2026" ke:
C:\xampp\htdocs\cybershield2026
```

Atau via Git (Pastikan Git terinstall dari [git-scm.com](https://git-scm.com)):
```bash
cd C:\xampp\htdocs
git clone <url-repo> cybershield2026
```
*(Jika tidak mau install Git, silakan klik tombol "Code" -> "Download ZIP" di GitHub, lalu ekstrak ke htdocs).*

### Langkah 4: Import Database

**Cara A — Lewat phpMyAdmin (GUI):**
1. Buka browser → `http://localhost/phpmyadmin`
2. Klik tab **Import**
3. Pilih file `setup_database.sql` dari dalam folder `cybershield2026/database`
4. Klik **Go / Kirim**

**Cara B — Lewat Terminal (CMD):**
```bash
cd C:\xampp\htdocs\cybershield2026
C:\xampp\mysql\bin\mysql.exe -u root < database/setup_database.sql
```

### Langkah 5: Buka di Browser

```
http://localhost/cybershield2026/
```

✅ **Selesai!** Anda sekarang bisa mengakses seluruh lab.

---

## B. Laragon (Windows — Ringan & Cepat)

### Langkah 1: Download & Install Laragon

1. Buka [https://laragon.org/download/](https://laragon.org/download/)
2. Download **Laragon Full** (sudah termasuk PHP, MySQL, Apache, phpMyAdmin)
3. Install seperti biasa

### Langkah 2: Jalankan Laragon

1. Buka **Laragon**
2. Klik tombol **Start All**
3. Apache dan MySQL akan berjalan otomatis

### Langkah 3: Copy File Lab

```
Salin folder "cybershield2026" ke:
C:\laragon\www\cybershield2026
```

### Langkah 4: Import Database

**Lewat Terminal Laragon:**
1. Klik kanan di Laragon → **Terminal**
2. Jalankan:
```bash
cd C:\laragon\www\cybershield2026
mysql -u root < database/setup_database.sql
```

**Lewat phpMyAdmin:**
1. Buka `http://localhost/phpmyadmin`
2. Import file `setup_database.sql` dan `setup_target.sql`

### Langkah 5: Buka di Browser

```
http://localhost/cybershield2026/
```

> 💡 **Tips Laragon:** Laragon juga mendukung **Pretty URL**. Anda bisa mengakses lab via `http://cybershield2026.test/` secara otomatis.

✅ **Selesai!**

---

## C. Docker (Semua OS — Paling Profesional)

### Langkah 1: Install Docker

**Windows:**
1. Buka [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
2. Download **Docker Desktop for Windows**
3. Install dan restart komputer jika diminta
4. Pastikan **WSL 2** sudah terinstall (Docker Desktop akan memandu Anda)

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install docker.io docker-compose-plugin -y
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
# Logout dan login kembali
```

**macOS:**
```bash
# Menggunakan Homebrew
brew install --cask docker
# Atau download dari https://www.docker.com/products/docker-desktop/
```

### Langkah 2: Jalankan Lab dengan Satu Perintah!

Buka terminal, lalu masuk ke folder tempat Anda menyimpan project ini:
```bash
# Masuk ke folder project (sesuaikan dengan lokasi Anda)
cd /lokasi/folder/cybershield2026

docker compose up -d --build
```

> Docker akan otomatis:
> - Membangun image PHP+Apache
> - Menjalankan MySQL dan mengimport `database/setup_database.sql`
> - Menjalankan phpMyAdmin

### Langkah 3: Buka di Browser

| Layanan | URL |
|---------|-----|
| 🌐 Lab Web | [http://localhost:8080](http://localhost:8080) |
| 🗄️ phpMyAdmin | [http://localhost:8081](http://localhost:8081) |

### Perintah Docker Berguna

```bash
# Melihat status container
docker compose ps

# Melihat log real-time
docker compose logs -f web

# Menghentikan semua container
docker compose down

# Menghentikan & hapus semua data (termasuk database)
docker compose down -v

# Restart setelah mengubah kode
docker compose restart web
```

### ⚠️ Catatan Penting untuk Docker

Karena di dalam Docker, web server dan database berada di **container yang berbeda**, koneksi database harus mengarah ke hostname `db` (bukan `127.0.0.1`).

**Solusi:** Edit koneksi di file PHP jika menggunakan Docker:
```php
// Untuk Docker, ganti 127.0.0.1 menjadi "db"
$conn = new mysqli("db", "root", "", "cybershield_lab");
```

Atau gunakan variabel environment (sudah disediakan di `docker-compose.yml`):
```php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$conn = new mysqli($host, "root", "", "cybershield_lab");
```

✅ **Selesai!**

---

## D. PHP Built-in Server (Tanpa Install Apapun)

> Metode ini untuk Anda yang sudah punya PHP dan MySQL terinstall di sistem.

### Langkah 1: Pastikan PHP & MySQL Sudah Tersedia

```bash
php -v      # Harus muncul versi PHP
mysql -V    # Harus muncul versi MySQL
```

### Langkah 2: Import Database

Buka terminal, lalu masuk ke folder tempat Anda menyimpan project:

**PowerShell (Windows):**
```powershell
# Masuk ke folder project (sesuaikan path-nya)
cd C:\xampp\htdocs\cybershield2026   # contoh jika pakai XAMPP

cmd /c "mysql -u root < database/setup_database.sql"
```

**Bash (Linux/macOS):**
```bash
# Masuk ke folder project (sesuaikan path-nya)
cd ~/cybershield2026

mysql -u root < database/setup_database.sql
```

### Langkah 3: Jalankan PHP Built-in Server

Dari dalam folder project yang sama, jalankan:
```bash
php -S 0.0.0.0:8000
```

### Langkah 4: Buka di Browser

```
http://localhost:8000
```

✅ **Selesai!**

---

## 🔧 Konfigurasi Database

Semua file PHP di lab ini menggunakan koneksi database berikut:

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

## 🗂️ Struktur Database

Lab ini membutuhkan **2 file SQL** yang harus diimport:

| File | Isi |
|------|-----|
| `database/setup_database.sql` | Tabel lab dan portal berita + data dummy |

---

## ❓ Troubleshooting

### "Access denied for user 'root'"
- Pastikan MySQL mengizinkan login tanpa password
- Di XAMPP, user `root` defaultnya tanpa password
- Jika menggunakan password, edit koneksi di file PHP

### "Table doesn't exist"
- Anda belum mengimport database. Jalankan:
  ```bash
  mysql -u root < database/setup_database.sql
  ```

### Halaman blank / putih
- Aktifkan error reporting di PHP:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```

### Port 80 sudah dipakai (XAMPP)
- Kemungkinan IIS atau Skype menggunakan port 80
- Di XAMPP, ubah port Apache ke 8080 di `httpd.conf`

### Docker: "Cannot connect to MySQL"
- Pastikan container `db` sudah sehat: `docker compose ps`
- Ganti host dari `127.0.0.1` ke `db` di file PHP

---

## 📝 Catatan Keamanan

> ⚠️ **PERINGATAN:** Lab ini berisi kode yang **SENGAJA DIBUAT RENTAN** untuk tujuan edukasi.
> 
> - **JANGAN** deploy lab ini ke server production yang bisa diakses publik
> - **JANGAN** gunakan teknik yang dipelajari untuk menyerang sistem tanpa izin
> - Pelanggaran dapat dikenai **UU ITE Pasal 30-33** (pidana hingga 10 tahun penjara)

---

**Created by Indra** | [📷 @Indradwi.25](https://instagram.com/Indradwi.25) | HIMTIF Universitas Pamulang
