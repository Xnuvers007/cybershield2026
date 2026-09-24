<?php
session_start();
$conn = new mysqli("127.0.0.1", "root", "", "cybershield_lab");
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Generate simple CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
