<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];

// Get current balance
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$balance = $stmt->fetchColumn();

$message = '';

if ($_POST['amount']) {
    $amount = (float)$_POST['amount'];
    $acc_num = trim($_POST['acc_num']);
    $acc_name = trim($_POST['acc_name']);
    $bank = $_POST['bank'];
    $charge = $amount * 0.1; // 10% fee

    if ($amount < 1000) {
        $message = "Minimum withdrawal is ₦1,000.";
    } elseif ($amount > 50000) {
        $message = "Daily limit is ₦50,000.";
    } elseif ($amount + $charge > $balance) {
        $message = "Insufficient balance.";
    } else {
        // Deduct from balance and record withdrawal
        $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?")->execute([$amount + $charge, $user_id]);
        $pdo->prepare("INSERT INTO withdrawals (user_id, amount, account_number, account_name, bank) VALUES (?, ?, ?, ?, ?)")
            ->execute([$user_id, $amount, $acc_num, $acc_name, $bank]);

        $message = "Withdrawal of ₦" . number_format($amount) . " submitted successfully (fee: ₦" . number_format($charge) . ").";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Withdrawal</title>
    <link rel="stylesheet" type="text/css" href="withdraw.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="header"><center>Withdrawal</center></div>

<div class="divbalance">
    <a href="home.php"><span class="back">&#x2190;</span></a>
    <p class="balance">&#x20a6; <?php echo number_format($balance, 2); ?></p>
</div>

<button class="withdrawal-info" onclick="myDialog.showModal()">Withdrawal Info</button>
<dialog id="myDialog">
    <ul class="bayani">
        <li>Minimum withdrawal: ₦1,000</li>
        <li>Daily limit: ₦50,000</li>
        <li>Withdrawal charge: 10%</li>
        <li>You can withdraw without referrals</li>
    </ul>
    <button style="width: 100px;background: blue;color: white;" onclick="myDialog.close()">Ok</button>
</dialog>

<div class="divwithdraw">
    <center>
        <form method="POST">
            <input type="number" name="amount" placeholder="Amount" required><br>
            <input type="number" name="acc_num" placeholder="Account Number" required><br>
            <input type="text" name="acc_name" placeholder="Account Name" required><br>
            
            <select class="bank" name="bank" required>
                <option value="">Bank</option>
                <option>Opay</option>
                <option>Moniepoint</option>
                <option>PalmPay</option>
                <option>Kuda Bank</option>
                <option>Wema Bank</option>
                <option>First Bank</option>
                <option>Access Bank</option>
                <option>UBA Bank</option>
                <option>Guaranty Trust Bank(GT)</option>
                <option>First City Monument Bank(FCMB)</option>
            </select><br><br>
            <button class="withdrawbutton" type="submit">Withdraw</button>
        </form>
    </center>
</div>

<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="40" height="40"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="40" height="40"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="40" height="40"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="40" height="40"></a>
</div>

<script>
const myDialog = document.getElementById("myDialog");
</script>

<?php if ($message): ?>
<script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>

</body>
</html>