<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT p.name, p.image, i.amount, i.daily_return, i.end_date, i.status 
    FROM investments i
    JOIN products p ON i.product_id = p.id
    WHERE i.user_id = ?
");
$stmt->execute([$user_id]);
$investments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
<div class="header">My Products</div>
<a href="mine.php"><span class="back">&#x2190;</span></a>

<?php if (count($investments) > 0): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 15px; padding: 10px;">
        <?php foreach ($investments as $inv): ?>
        <div style="text-align: center; border: 1px solid #ddd; padding: 10px; border-radius: 8px; width: 180px;">
            <img src="<?php echo $inv['image']; ?>" width="150" height="200"><br>
            <strong><?php echo $inv['name']; ?></strong><br>
            Earn: ₦<?php echo number_format($inv['daily_return']); ?>/day<br>
            Ends: <?php echo $inv['end_date']; ?><br>
            Status: <span style="color: <?php echo $inv['status'] == 'active' ? 'green' : 'red'; ?>">
                <?php echo ucfirst($inv['status']); ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p style="text-align: center; margin-top: 50px;">You haven't invested in any product yet.</p>
<?php endif; ?>

<div class="divicons">...</div>
</body>
</html>

