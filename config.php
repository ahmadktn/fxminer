<?php
session_start();
$host = '161.97.84.20';
$dbname = 'fxminer';
$username = 'user';
$password = 'fxminerweb123';
$port = 3309;



$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function generateReferralCode() {
    return strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
}

function auth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>
