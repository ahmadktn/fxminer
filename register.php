<?php
require 'config.php';
$title = "Register";
$message = "";

if ($_POST['phone']) {
    $phone = $_POST['phone'];
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $ref = $_GET['ref'] ?? null;

    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $message = "Password too short.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $ref_code = generateReferralCode();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO users (phone, email, password, referral_code, referred_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$phone, $email, $hashed, $ref_code, $ref]);

            // Bonus if referred
            if ($ref) {
                $pdo->exec("UPDATE users SET balance = balance + 100 WHERE phone = '$ref'");
            }

            $pdo->commit();
            $message = "Registered! You can now log in.";
        } catch (Exception $e) {
            $pdo->rollback();
            $message = "Phone already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="register or log in.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<center>
<img src="png icon.png" width="400" height="400" alt="image">
<form method="POST">
<div><br><br>
<input class="phone" type="text" name="phone" placeholder="Mobile Number" required><br><br>
<input class="phone" type="email" name="email" placeholder="Email Address"><br><br>
<input class="phone" type="password" name="password" placeholder="Password" required><br><br>
<input class="phone" type="password" name="confirm_password" placeholder="Confirm password" required><br><br>
<button class="button" type="submit">Sign Up</button><br><br>
<a href="index.php" style="text-decoration: none; color:white;"><h3 class="login">Log in</h3></a>
</div>
</form>
<?php if ($message): ?>
    <script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>
</center>
</body>
</html>