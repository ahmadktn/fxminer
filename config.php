<?php
session_start();

$host = '161.97.84.20';
$dbname = 'fxminer';
$username = 'user';
$password = 'fxminerweb123';
$port = 3309;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function generateReferralCode() {
    return strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
}

// Check if user is logged in
function auth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>
