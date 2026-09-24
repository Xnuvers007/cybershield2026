# 🎯 Kuis Interaktif: CYBERSHIELD 2026 (Mode MEDIUM ⚖️)

Kuis ini dirancang dengan tingkat kesulitan *Medium* (Menengah). Pertanyaannya tidak semudah mengedipkan mata, tetapi juga tidak sesulit soal ujian akhir semester. Pas untuk menguji pemahaman peserta setelah mengikuti lab!

---

### Soal 1: Tameng SQL Injection 🛡️
**Pertanyaan:** Bagaimana tepatnya cara kerja *Prepared Statements* (seperti PDO) dalam melindungi website dari serangan SQL Injection?
- [A] Mengenkripsi semua input yang masuk menjadi teks acak.
- [B] Menghapus secara otomatis semua simbol kutip (`'`) dan titik koma (`;`).
- [C] Memisahkan secara tegas antara struktur perintah (Query SQL) dengan data yang diinput oleh pengguna.
- [D] Memblokir alamat IP yang mencoba memasukkan karakter aneh.
> **Jawaban Benar:** **[C]**
> *Penjelasan:* *Prepared Statements* memperlakukan input pengguna **murni sebagai data**, sehingga *database* tidak akan pernah mengeksekusinya sebagai perintah (kode) SQL.

### Soal 2: Gembok IDOR yang Hilang 🚪
**Pertanyaan:** Di lab, kita bisa melihat profil Admin hanya dengan mengubah `?id=2` menjadi `?id=1` di URL (celah IDOR). Bagaimana cara paling benar untuk menambal celah ini?
- [A] Mengenkripsi angka `1` di URL menggunakan MD5.
- [B] Menyembunyikan parameter `?id=` menggunakan metode POST alih-alih GET.
- [C] Memastikan di kode PHP bahwa *Session ID* milik pengguna yang *login* memiliki hak akses/kepemilikan atas data ID tersebut.
- [D] Mengganti angka ID menjadi huruf (A, B, C).
> **Jawaban Benar:** **[C]**
> *Penjelasan:* Solusi utama IDOR adalah Otorisasi (*Authorization*). Server harus selalu mengecek "Apakah pengguna A *berhak* melihat data milik B?".

### Soal 3: Pensiunnya Sang MD5 🪦
**Pertanyaan:** Mengapa saat ini kita sangat dilarang menggunakan algoritma MD5 untuk menyimpan *password* pengguna dan diwajibkan beralih ke Bcrypt?
- [A] Karena MD5 sangat lambat dan memberatkan kinerja *server*.
- [B] Karena MD5 adalah algoritma kuno yang sangat cepat diproses, sehingga sangat rentan dibongkar dengan serangan *Brute-Force* dan *Rainbow Tables*.
- [C] Karena teks yang panjang tidak bisa di-hash oleh MD5.
- [D] Karena MD5 merupakan produk berbayar.
> **Jawaban Benar:** **[B]**
> *Penjelasan:* Untuk *password*, kita justru membutuhkan algoritma yang "lambat dan berat" seperti Bcrypt agar peretas membutuhkan waktu berbulan-bulan untuk menebak satu *password* saja.

### Soal 4: Diskon Ekstrem (Logic Flaw) 🛒
**Pertanyaan:** Pada lab Online Shop, seorang *hacker* berhasil membeli Laptop mahal dengan harga Rp 0. Celah *Business Logic* apa yang menyebabkan ini terjadi?
- [A] Harga laptop bisa diubah menggunakan *Inspect Element* di *browser*.
- [B] *Hacker* menyisipkan *script* XSS di kolom pencarian.
- [C] *Hacker* mencegat dan mengganti respons dari *Payment Gateway*.
- [D] Server tidak memvalidasi kuantitas (`qty`), sehingga *hacker* bisa memasukkan angka belanja *negatif* (minus).
> **Jawaban Benar:** **[D]**
> *Penjelasan:* *Logic Flaw* adalah celah pada "alur bisnis" aplikasi. Mengalikan harga dengan kuantitas bernilai minus (misal -100) akan membuat total harga menjadi negatif yang justru menambah saldo peretas.

### Soal 5: Mencuci Kode Berbahaya (XSS) 🧼
**Pertanyaan:** Fungsi `htmlspecialchars()` di PHP adalah senjata utama mencegah XSS. Apa yang dilakukan fungsi tersebut pada input jahat seperti `<script>`?
- [A] Menghapus sepenuhnya kata `script` dari database.
- [B] Mengubah karakter `<` dan `>` menjadi entitas HTML (seperti `&lt;` dan `&gt;`) sehingga *browser* hanya menampilkannya sebagai teks biasa.
- [C] Menolak (*reject*) dan mengembalikan pesan *Error* ke pengguna.
- [D] Memasukkan IP penyerang ke dalam *Blacklist*.
> **Jawaban Intervention:** **[B]**
> *Penjelasan:* Karakter yang sudah diubah (di-*encode*) tidak akan dianggap sebagai tag/kode HTML oleh *browser*, sehingga *payload* XSS gagal dieksekusi.

### Soal 6: Harta Karun LFI 🗺️
**Pertanyaan:** Celah *Local File Inclusion* (LFI) memungkinkan peretas membaca file sistem di *server*. Di OS Linux, file sistem apa yang paling sering dibidik pertama kali untuk membuktikan adanya LFI?
- [A] `/etc/passwd`
- [B] `C:\Windows\System32`
- [C] `index.html`
- [D] `config.exe`
> **Jawaban Benar:** **[A]**
> *Penjelasan:* File `/etc/passwd` berisi daftar *user* di OS Linux dan biasanya memiliki hak akses baca untuk semua *user*, menjadikannya target validasi utama serangan LFI.

### Soal 7: Mengikat Sesi Korban (Session Fixation) 🪢
**Pertanyaan:** Pada serangan *Session Fixation*, peretas memaksa korban *login* menggunakan *Session ID* (contoh: `PHPSESSID=123`) yang sengaja ia berikan. Bagaimana cara paling gampang mencegah hal ini?
- [A] Menggunakan IP Address alih-alih *Session ID*.
- [B] Selalu menjalankan fungsi `session_regenerate_id()` (mengacak ulang ID sesi) tepat setelah korban berhasil memasukkan sandi dengan benar.
- [C] Menghapus semua *cookies* dari *browser*.
- [D] Menambahkan CAPTCHA di halaman *Login*.
> **Jawaban Benar:** **[B]**
> *Penjelasan:* Dengan memperbarui *Session ID* saat otentikasi berhasil, sesi lama (`123`) milik *hacker* akan hangus dan tidak lagi valid.

### Soal 8: Mencegah RCE (Command Injection) 🛑
**Pertanyaan:** Di lab simulasi alat "Ping", kita menggunakan fungsi `escapeshellarg()` untuk menutup celah *Remote Code Execution*. Tanpa fungsi ini, apa yang bisa dilakukan peretas?
- [A] Menyisipkan simbol titik koma (`;`) atau *ampersand* (`&&`) untuk menjalankan perintah Linux/Windows sesuka hati mereka di *server*.
- [B] Mengubah alamat IP *server* secara permanen.
- [C] Menghapus koneksi *database* menggunakan SQL Injection.
- [D] Membaca isi pesan WhatsApp admin.
> **Jawaban Benar:** **[A]**
> *Penjelasan:* Dalam *Terminal / Command Prompt*, tanda `;` atau `&&` berfungsi sebagai pemisah antar perintah. Peretas bisa mengirimkan `127.0.0.1; whoami` untuk membajak perintah asli.

### Soal 9: Si Bunglon Polyglot (File Upload) 🦎
**Pertanyaan:** Bagaimana sebuah file berbahaya (seperti `demo.jpg`) bisa menipu pengecekan file *upload* yang menggunakan fungsi pembaca *Magic Bytes* seperti `finfo()`?
- [A] Karena *hacker* menyuap administrator *server*.
- [B] Karena fungsi `finfo()` hanya mengecek kecocokan beberapa byte pertama di kepala file, namun mengabaikan teks kode HTML/PHP yang disembunyikan di bagian bawah file.
- [C] Karena file tersebut di-*upload* dengan kecepatan sangat tinggi.
- [D] Karena ekstensi `.jpg` tidak bisa diretas.
> **Jawaban Benar:** **[B]**
> *Penjelasan:* File *Polyglot* sengaja meletakkan "KTP" (Header Valid) palsu di bagian awal file agar diloloskan *server*, sementara sisanya berisi racun.

### Soal 10: XML yang Haus Data (XXE) 📄
**Pertanyaan:** Celah XXE (XML External Entity) bisa berakibat sangat fatal karena ia bisa memerintahkan *Parser* XML pada server untuk...
- [A] Menghapus baris kode HTML secara permanen.
- [B] Membaca isi file lokal rahasia (*Local File Read*) dan menarik data dari *server* internal (SSRF).
- [C] Menjalankan *file upload* tanpa batas.
- [D] Mematikan koneksi internet.
> **Jawaban Benar:** **[B]**
> *Penjelasan:* Dengan mendefinisikan *External Entity* pada dokumen XML yang dimanipulasi, aplikasi akan tanpa sadar mengambil dan menampilkan kembali (*reflect*) isi file server kepada penyerang.

---

**Saran Pelaksanaan Kuis:**
Waktu **30 detik** per soal adalah durasi paling ideal untuk tipe soal *Medium* ini. Selamat bersenang-senang menguji mental peserta! 🎉
