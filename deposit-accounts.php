<?php
require 'config.php';
auth();
$amount = $_GET['amount'] ?? 0;
if ($amount < 3000) die("Invalid amount.");
?>
<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Deposit-accounts</title>
    <link rel="stylesheet" type="text/css" href="deposit.css">
    <meta charset="UTF-8">
</head>
<body>
<header class="header">Deposit-accounts</header>
<section class="getway">
    <h1>Getway 1</h1>
    <ul>
        <li>Account: Moniepoint</li>
        <li>Account No: 5363841856</li>
        <li>Account Name: Muhammad Mukhtar</li>
    </ul>
    <h2>Narration: DEP-<?php echo $_SESSION['user_id']; ?></h2>
   <!-- <button>Copy Ac Details</button> -->
</section>
<section class="getway">
    <h1>Getway 1</h1>
    <ul>
        <li>Account: UBA</li>
        <li>Account No: 2299122045</li>
        <li>Account Name: Farida Dayyabu</li>
    </ul>
    <h2>Narration: DEP-<?php echo $_SESSION['user_id']; ?></h2>
   <!-- <button>Copy Ac Details</button> -->
</section>
<!-- Repeat for Getway 2, 3 -->
<div class="divicons">...</div>
</body>

</html>
