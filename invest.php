<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product'] ?? null;

// Get product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Invalid product selected.");
}

// Get user balance
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$balance = $stmt->fetchColumn();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($balance < $product['price']) {
        $message = "Insufficient balance. Need ₦" . number_format($product['price'] - $balance) . " more.";
    } else {
        try {
            // Start transaction
            $pdo->beginTransaction();

            // Deduct from balance
            $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?")
                ->execute([$product['price'], $user_id]);

            // Record investment
            $end_date = date('Y-m-d', strtotime("+{$product['duration_days']} days"));
            $pdo->prepare("INSERT INTO investments (user_id, product_id, amount, daily_return, duration_days, end_date) 
                          VALUES (?, ?, ?, ?, ?, ?)")
                ->execute([
                    $user_id,
                    $product['id'],
                    $product['price'],
                    $product['daily_return'],
                    $product['duration_days'],
                    $end_date
                ]);

            $pdo->commit();
            $message = "✅ Successfully invested in {$product['name']}! You'll earn ₦{$product['daily_return']}/day for {$product['duration_days']} days.";
        } catch (Exception $e) {
            $pdo->rollback();
            $message = "Error processing investment.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invest - FXminer</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="header">Confirm Investment</div>
<a href="home.php"><span class="back">&#x2190;</span></a>

<div style="padding: 20px; text-align: center;">
    <img src="<?php echo $product['image']; ?>" width="150" height="220"><br><br>
    <h2><?php echo $product['name']; ?></h2>
    <p>
        <strong>Price:</strong> ₦<?php echo number_format($product['price']); ?><br>
        <strong>Daily Return:</strong> ₦<?php echo number_format($product['daily_return']); ?><br>
        <strong>Duration:</strong> <?php echo $product['duration_days']; ?> days<br>
        <strong>Total Return:</strong> ₦<?php echo number_format($product['daily_return'] * $product['duration_days']); ?>
    </p>

    <form method="POST">
        <button type="submit" style="background: green; color: white; padding: 10px 30px; font-size: 18px; border: none; border-radius: 5px;">
            Confirm Purchase
        </button>
    </form>

    <p style="margin-top: 20px; font-size: 14px; color: #555;">
        You will start earning daily returns immediately after purchase.
    </p>
</div>

<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="45" height="45"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="45" height="45"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="45" height="45"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="45" height="45"></a>
</div>

<?php if ($message): ?>
<script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>
</body>
</html>
