<?php
/**
 * ============================================================================
 * ⚠️ KODE INI SENGAJA DIBUAT RENTAN — HANYA UNTUK EDUKASI!
 * ============================================================================
 * Kategori  : A09:2021 — Security Logging and Monitoring Failures
 * Risiko    : HIGH
 * Deskripsi : Kode ini mendemonstrasikan tidak adanya logging dan monitoring.
 * 
 * DISCLAIMER: Jangan gunakan teknik ini untuk menyerang sistem tanpa izin!
 *             Baca DISCLAIMER.md untuk informasi hukum lengkap.
 * 
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

session_start();

echo "<h1>🔴 RENTAN — Logging & Monitoring Failures</h1>";
echo "<hr>";
echo "<p><strong>Skenario:</strong> Sistem tanpa pencatatan keamanan dan pemantauan.</p>";
echo "<hr>";

// ⚠️ RENTAN: Login tanpa logging
echo "<h3>1. Login Tanpa Logging ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Tidak ada log untuk percobaan login<br><br>";
echo "if (\$valid_login) {<br>";
echo "&nbsp;&nbsp;\$_SESSION['user'] = \$username;<br>";
echo "&nbsp;&nbsp;header('Location: /dashboard'); // ⚠️ Tidak ada log login berhasil<br>";
echo "} else {<br>";
echo "&nbsp;&nbsp;echo 'Login gagal'; // ⚠️ Tidak ada log login gagal!<br>";
echo "&nbsp;&nbsp;// Penyerang bisa brute-force tanpa terdeteksi<br>";
echo "}<br><br>";
echo "<span style='color:#ff6b6b;'>// Tidak ada yang tahu siapa yang login, kapan, dari mana</span><br>";
echo "<span style='color:#ff6b6b;'>// Tidak ada alert jika ada 1000 percobaan login gagal</span>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Error tidak di-log
echo "<h3>2. Error Tidak Dicatat ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Exception ditangkap tapi tidak di-log<br><br>";
echo "try {<br>";
echo "&nbsp;&nbsp;\$conn->query(\$dangerous_query);<br>";
echo "} catch (Exception \$e) {<br>";
echo "&nbsp;&nbsp;<span style='color:#ff6b6b;'>// Kosong! Error diabaikan begitu saja</span><br>";
echo "&nbsp;&nbsp;// Atau hanya:<br>";
echo "&nbsp;&nbsp;echo 'Terjadi kesalahan'; // ⚠️ Tidak ada log!<br>";
echo "}<br><br>";
echo "<span style='color:#ff6b6b;'>// SQL Injection attempt tidak terdeteksi</span><br>";
echo "<span style='color:#ff6b6b;'>// Penyerang bisa mencoba berkali-kali tanpa alert</span>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Tidak ada audit trail
echo "<h3>3. Tidak Ada Audit Trail ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Aksi penting tidak dicatat<br><br>";
echo "// Siapa yang menghapus data? Kapan? Dari mana?<br>";
echo "\$conn->query(\"DELETE FROM users WHERE id = \$id\"); // ⚠️ Tidak ada log!<br><br>";
echo "// Siapa yang mengubah role menjadi admin?<br>";
echo "\$conn->query(\"UPDATE users SET role = 'admin' WHERE id = \$id\"); // ⚠️ Tidak ada log!<br><br>";
echo "// Siapa yang mengakses data sensitif?<br>";
echo "\$conn->query(\"SELECT * FROM financial_data\"); // ⚠️ Tidak ada log!<br><br>";
echo "<span style='color:#ff6b6b;'>// Jika terjadi breach, forensik digital akan SANGAT SULIT</span>";
echo "</div>";

echo "<br>";

// ⚠️ RENTAN: Tidak ada alerting
echo "<h3>4. Tidak Ada Sistem Alerting ⚠️</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ⚠️ RENTAN: Tidak ada notifikasi untuk kejadian mencurigakan<br><br>";
echo "// Skenario yang TIDAK ter-alert:<br>";
echo "❌ 500x login gagal dalam 1 menit → <span style='color:#ff6b6b;'>Tidak ada alert</span><br>";
echo "❌ SQL Injection terdeteksi → <span style='color:#ff6b6b;'>Tidak ada alert</span><br>";
echo "❌ Admin baru ditambahkan → <span style='color:#ff6b6b;'>Tidak ada alert</span><br>";
echo "❌ Data massal di-download → <span style='color:#ff6b6b;'>Tidak ada alert</span><br>";
echo "❌ Akses dari IP mencurigakan → <span style='color:#ff6b6b;'>Tidak ada alert</span><br><br>";
echo "<span style='color:#ff6b6b;'>// Rata-rata breach baru terdeteksi setelah 277 HARI! (IBM Report)</span>";
echo "</div>";

echo "<br>";
echo "<div style='background:#ff6b6b;color:#fff;padding:15px;border-radius:8px;'>";
echo "<h3>⚠️ Kerentanan yang Ada:</h3>";
echo "<ol>";
echo "<li><strong>Tidak Ada Logging:</strong> Aktivitas penting tidak dicatat.</li>";
echo "<li><strong>Tidak Ada Monitoring:</strong> Tidak ada sistem pemantauan real-time.</li>";
echo "<li><strong>Tidak Ada Alert:</strong> Kejadian mencurigakan tidak memicu notifikasi.</li>";
echo "<li><strong>Tidak Ada Audit Trail:</strong> Forensik digital hampir mustahil.</li>";
echo "<li><strong>Silent Failures:</strong> Error diabaikan tanpa pencatatan.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='secure.php'>➡️ Lihat versi AMAN</a>";
?>
