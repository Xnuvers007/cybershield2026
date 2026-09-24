<?php
// vuln.php - Rentan terhadap CORS Misconfiguration
// Secara dinamis menerima origin apapun yang dikirim di HTTP_ORIGIN
// dan mengizinkan credential (cookies/session).

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type");
}

header('Content-Type: application/json');

// Asumsikan data ini adalah data sensitif milik user yang sedang login
$sensitive_data = [
    "status" => "success",
    "user" => "Admin",
    "email" => "admin@cybershield.lab",
    "api_key" => "sk_live_998877665544332211"
];

echo json_encode($sensitive_data);
?>
