<?php
// AMAN: Membatasi Origin yang diizinkan (Whitelist)
$allowed_origins = [
    "http://localhost:8000",
    "http://127.0.0.1:8000",
    "https://cybershield.lab"
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type");
}

header('Content-Type: application/json');

$sensitive_data = [
    "status" => "success",
    "user" => "Admin",
    "email" => "admin@cybershield.lab",
    "api_key" => "sk_live_998877665544332211"
];

echo json_encode($sensitive_data);
?>
