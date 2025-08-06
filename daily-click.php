<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];
$message = "";

$stmt = $pdo->prepare("SELECT id FROM daily_clicks WHERE user_id = ? AND clicked_at = CURDATE()");
$stmt->execute([$user_id]);
if ($stmt->rowCount() > 0) {
    $message = "Already claimed today.";
} else {
    $pdo->prepare("UPDATE users SET balance = balance + 50 WHERE id = ?")->execute([$user_id]);
    $pdo->prepare("INSERT INTO daily_clicks (user_id, clicked_at) VALUES (?, CURDATE())")->execute([$user_id]);
    $message = "₦50 added!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daily-clicks</title>
    <link rel="stylesheet" type="text/css" href="dily-click.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="upper"><center>Daily-clicks</center></div>
<h2><?php echo $message; ?></h2>
<a class="dashboard" href="mine.php"><h2>Back to dashboard</h2></a>
<a class="home" href="home.php"><h2>Back to home</h2></a>
<script>alert("<?php echo $message; ?>");</script>
</body>
</html>