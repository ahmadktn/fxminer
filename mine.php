<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT phone, balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Me</title>
    <link rel="stylesheet" type="text/css" href="mine.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="header">Me</div>

<div class="divbalance">
    <a href="home.php"><span class="back">&#x2190;</span></a>
    <p class="balance">&#x20a6; <?php echo number_format($user['balance'], 2); ?></p>
</div>

<a href="deposit.php"><button>Deposit</button></a>
<a href="withdraw.php"><button>Withdraw</button></a>

<ul>
    <!--<li>Change Password</li><hr>-->
    <li><a style="color: white;" href="my-products.php">My Products</a></li><hr>
    <li><a style="color: white;" href="logout.php">Log Out</a></li>
</ul>

<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="45" height="45"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="45" height="45"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="45" height="45"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="45" height="45"></a>
</div>

</body>
</html>
