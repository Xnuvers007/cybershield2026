<?php
/**
 * ============================================================================
 * ✅ KODE AMAN — Logging & Monitoring Failures yang Sudah Diperbaiki
 * ============================================================================
 * Kategori  : A09:2021 — Security Logging and Monitoring Failures
 * Solusi    : Structured logging, audit trail, real-time alerting
 * 
 * DISCLAIMER: Materi edukasi — baca DISCLAIMER.md
 * CYBERSHIELD 2026 — HIMTIF Universitas Pamulang
 * ============================================================================
 */

echo "<h1>🟢 AMAN — Logging & Monitoring (Fixed)</h1>";
echo "<hr>";
echo "<p><strong>Solusi:</strong> Structured logging, audit trail, dan sistem alerting.</p>";
echo "<hr>";

// ✅ AMAN: Class untuk Security Logger
echo "<h3>1. Security Logger ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Class SecurityLogger untuk pencatatan terstruktur<br><br>";
echo "class <span style='color:#51cf66;'>SecurityLogger</span> {<br>";
echo "&nbsp;&nbsp;private \$log_file;<br><br>";
echo "&nbsp;&nbsp;public function log(\$level, \$event, \$details = []) {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$entry = [<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'timestamp' => <span style='color:#51cf66;'>date('c')</span>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// ISO 8601<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'level'&nbsp;&nbsp;&nbsp;&nbsp; => \$level,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// INFO, WARNING, CRITICAL<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'event'&nbsp;&nbsp;&nbsp;&nbsp; => \$event,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// login_success, login_failed<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'ip'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; => \$_SERVER['REMOTE_ADDR'],<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'user_agent'=> \$_SERVER['HTTP_USER_AGENT'],<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'session_id'=> <span style='color:#51cf66;'>session_id()</span>,<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'details'&nbsp;&nbsp; => \$details<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;];<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;file_put_contents(\$this->log_file, <span style='color:#51cf66;'>json_encode</span>(\$entry).\"\\n\", FILE_APPEND);<br>";
echo "&nbsp;&nbsp;}<br>";
echo "}<br>";
echo "</div>";

echo "<br>";

// ✅ AMAN: Contoh penggunaan logging
echo "<h3>2. Login dengan Logging Lengkap ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";

// Simulasi log entries
$log_entries = [
    [
        'timestamp' => '2024-03-15T10:30:45+07:00',
        'level' => 'INFO',
        'event' => 'login_success',
        'ip' => '192.168.1.100',
        'details' => ['username' => 'admin', 'method' => 'password+MFA']
    ],
    [
        'timestamp' => '2024-03-15T10:31:02+07:00',
        'level' => 'WARNING',
        'event' => 'login_failed',
        'ip' => '10.0.0.50',
        'details' => ['username' => 'admin', 'reason' => 'wrong_password', 'attempt' => 3]
    ],
    [
        'timestamp' => '2024-03-15T10:31:15+07:00',
        'level' => 'CRITICAL',
        'event' => 'account_lockout',
        'ip' => '10.0.0.50',
        'details' => ['username' => 'admin', 'reason' => 'max_attempts_exceeded']
    ],
    [
        'timestamp' => '2024-03-15T10:32:00+07:00',
        'level' => 'WARNING',
        'event' => 'sql_injection_attempt',
        'ip' => '10.0.0.50',
        'details' => ['input' => "' OR 1=1--", 'parameter' => 'search']
    ]
];

echo "// ✅ Contoh log entries (JSON structured):<br><br>";
foreach ($log_entries as $entry) {
    $color = match($entry['level']) {
        'CRITICAL' => '#ff6b6b',
        'WARNING' => '#ffd43b',
        default => '#51cf66'
    };
    echo "<span style='color:{$color};'>" . json_encode($entry, JSON_PRETTY_PRINT) . "</span><br><br>";
}
echo "</div>";

echo "<br>";

// ✅ AMAN: Audit Trail
echo "<h3>3. Audit Trail untuk Aksi Penting ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Setiap aksi penting dicatat ke audit trail<br><br>";
echo "function <span style='color:#51cf66;'>auditLog</span>(\$action, \$target, \$old_value, \$new_value) {<br>";
echo "&nbsp;&nbsp;\$audit = [<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'timestamp'&nbsp; => date('c'),<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'actor'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; => \$_SESSION['username'],<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'action'&nbsp;&nbsp;&nbsp;&nbsp; => \$action,&nbsp;&nbsp;&nbsp;&nbsp;// 'delete_user', 'change_role'<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'target'&nbsp;&nbsp;&nbsp;&nbsp; => \$target,&nbsp;&nbsp;&nbsp;&nbsp;// 'user:42'<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'old_value'&nbsp; => \$old_value, // 'role:user'<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'new_value'&nbsp; => \$new_value, // 'role:admin'<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;'ip'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; => \$_SERVER['REMOTE_ADDR']<br>";
echo "&nbsp;&nbsp;];<br>";
echo "&nbsp;&nbsp;// Simpan ke tabel audit_log (append-only, tidak bisa dihapus)<br>";
echo "&nbsp;&nbsp;\$db->insert('audit_log', \$audit);<br>";
echo "}<br><br>";
echo "// Contoh penggunaan:<br>";
echo "<span style='color:#51cf66;'>auditLog</span>('change_role', 'user:42', 'role:user', 'role:admin');";
echo "</div>";

echo "<br>";

// ✅ AMAN: Alerting rules
echo "<h3>4. Sistem Alerting ✅</h3>";
echo "<div style='background:#1a1a2e;color:#eee;padding:15px;border-radius:8px;font-family:monospace;'>";
echo "// ✅ AMAN: Alert rules untuk kejadian mencurigakan<br><br>";
echo "Skenario yang memicu ALERT:<br><br>";
echo "🚨 <span style='color:#ff6b6b;'>CRITICAL</span> — 10+ login gagal dalam 5 menit → Email + SMS ke admin<br>";
echo "🚨 <span style='color:#ff6b6b;'>CRITICAL</span> — SQL Injection terdeteksi → Block IP + alert<br>";
echo "⚠️ <span style='color:#ffd43b;'>WARNING</span>&nbsp; — Login dari negara/IP baru → Email notifikasi<br>";
echo "⚠️ <span style='color:#ffd43b;'>WARNING</span>&nbsp; — Password diubah → Email konfirmasi ke user<br>";
echo "ℹ️ <span style='color:#51cf66;'>INFO</span>&nbsp;&nbsp;&nbsp;&nbsp; — Admin baru ditambahkan → Log + notifikasi<br>";
echo "ℹ️ <span style='color:#51cf66;'>INFO</span>&nbsp;&nbsp;&nbsp;&nbsp; — Data massal di-export → Log + rate limit<br><br>";
echo "// Tools monitoring: ELK Stack, Grafana, Splunk, Wazuh<br>";
echo "// Cloud: AWS CloudWatch, Google Cloud Logging, Azure Monitor";
echo "</div>";

echo "<br>";
echo "<div style='background:#51cf66;color:#000;padding:15px;border-radius:8px;'>";
echo "<h3>✅ Teknik Pencegahan yang Diterapkan:</h3>";
echo "<ol>";
echo "<li><strong>Structured Logging:</strong> Log dalam format JSON untuk kemudahan parsing.</li>";
echo "<li><strong>Security Events:</strong> Log semua event keamanan (login, failed auth, akses data).</li>";
echo "<li><strong>Audit Trail:</strong> Catat siapa, apa, kapan, dari mana untuk setiap aksi penting.</li>";
echo "<li><strong>Real-time Alerting:</strong> Notifikasi otomatis untuk kejadian mencurigakan.</li>";
echo "<li><strong>Log Integrity:</strong> Log disimpan di sistem terpisah (append-only).</li>";
echo "<li><strong>Monitoring Dashboard:</strong> Gunakan ELK/Grafana untuk visualisasi.</li>";
echo "</ol>";
echo "</div>";

echo "<br><a href='vuln.php'>⬅️ Lihat versi RENTAN</a>";
?>
