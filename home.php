<?php
require 'config.php';
auth();
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$balance = $user['balance'];
$title = "Home";
?>
<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Home</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="header">Home</div>
<section class="img-container"></section><br><br>

<div class="deposit-main-container">
    <div class="divdeposit">
        <a href="deposit.php"><img class="deposit" src="deposit.png" width="90" height="120"></a>
        <a href="withdraw.php"><img class="deposit" src="Withdrawt.png" width="90" height="120"></a>
        <a href="invite.php"><img class="deposit" src="invite.png" width="90" height="120"></a>
        <a href="mine.php"><img class="deposit" src="me.png" width="90" height="120"></a>
    </div>
</div><br>

<div class="container">
    <marquee behavior="scroll" direction="left">
        <div class="scroll" id="scrolling">Welcome! You have ₦<?php echo number_format($balance); ?> in your wallet.</div>
    </marquee>
</div>
<!--
<h2 class="OP">Our Products</h2>
<div class="products-container">
    <a href="#"><img class="Products" src="gold.png" width="190" height="290"></a>
    <a href="#"><img class="Products" src="platineum.png" width="190" height="290"></a>
    <a href="#"><img class="Products" src="diamond.png" width="190" height="290"></a>
    <a href="#"><img class="Products" src="master.png" width="190" height="290"></a>
</div><br><br>
-->


<h2 class="OP">Our Products</h2>
<div class="products-container">
    <?php
    $stmt = $pdo->query("SELECT * FROM products ORDER BY price");
    while ($product = $stmt->fetch()) {
        echo "
        <div class='product-card'>
            <a href='invest.php?product={$product['id']}' style='text-decoration: none; color: inherit;'>
                <img src='{$product['image']}' alt='{$product['name']}' class='product-img'>
                <div class='product-info'>
                    <strong>{$product['name']}</strong><br>
                    <small>
                        ₦" . number_format($product['price']) . " | 
                        ₦" . number_format($product['daily_return']) . "/day
                    </small>
                </div>
            </a>
        </div>";
    }
    ?>
</div><br><br>


<section><a href="daily-click.php"><img class="daily-click" src="gift.png" width="70" height="70"><h2 class="dailyclick">Daily-click</h2></a></section>

<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="45" height="45"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="45" height="45"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="45" height="45"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="45" height="45"></a>
</div>

<script src="home.js"></script>
</body>
</html>
