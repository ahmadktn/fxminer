<?php
require 'config.php';
auth();
$user_id = $_SESSION['user_id'];

if ($_POST['amount']) {
    $amount = (int)$_POST['amount'];
    if ($amount >= 3000) {
        $pdo->prepare("INSERT INTO deposits (user_id, amount) VALUES (?, ?)")->execute([$user_id, $amount]);
        header("Location: deposit-accounts.php?amount=" . $amount);
        exit();
    } else {
        echo "<script>alert('Min ₦3000');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Deposit</title>
    <link rel="stylesheet" type="text/css" href="deposit.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="header">Deposit</div>
<a href="home.php#"><span class="back">&#x2190;</span></a>
<p class="balance">&#x20a6; 0.00</p>

<section>
    <p class="deposit-instruction"><u><b>Deposit instruction</b></u><br> Minimum: ₦3000</p>
</section>

<section class="banks">
<form method="POST">
     <button type="button" onclick="document.getElementById('input').value=5000">5000</button>
     <button type="button" onclick="document.getElementById('input').value=1000">1000</button>
     <input type="number" class="myinput" id="input" name="amount" placeholder="Enter amount">
     <button type="submit" class="deposit-botton">Deposit</button>
</form>
</section>

<div class="divicons">...</div>
<script src="deposit.js"></script>
</body>
</html>