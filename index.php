<?php
require 'config.php';
$title = "Log In";
$message = "";

if ($_POST['phone']) {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: home.php");
        exit();
    } else {
        $message = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Login</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<center>
<img src="png icon.png" width="400" height="400" alt="Logo">
<form method="POST">
<div><br>
    <input class="phone" type="text" name="phone" placeholder="Mobile Number"><br><br>
    <input class="phone" type="password" name="password" placeholder="Password"><br><br>
    <button class="button" type="submit">Log In</button><br><br>
    <input type="checkbox" name="remember"> <span>Remember Me</span>
    <h3>Don't have an account? <a href="register.php">Register</a></h3>
    <br><br>
    <small style="color:#ec0a0f">Forgot password</small>
</div>
</form>
<?php if ($message): ?>
    <script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>
</center>
</body>
</html>