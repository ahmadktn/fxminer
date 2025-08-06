<?php
require 'config.php';
auth();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT referral_code FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$code = $stmt->fetchColumn();
$ref_link = "http://$_SERVER[HTTP_HOST]" . dirname($_SERVER['SCRIPT_NAME']) . "/register.php?ref=" . $code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FXminer/Invite</title>
    <link rel="stylesheet" href="invite.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="header">Invite</div>
<a href="home.php"><span class="back">&#x2190;</span></a>

<div class="container">
    <h2 class="link"><?php echo $ref_link; ?></h2>
    <button class="link-btn" onclick="copyLink()">Copy</button>
</div>

<hr>
<div class="invitation-container">
    <h2 class="invitation">Invitation Rule</h2>
</div>
<b>
<p class="iv-rule">Your invited friends must register and make a deposit before you earn cashback.</p>
</b>

<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="45" height="45"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="45" height="45"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="45" height="45"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="45" height="45"></a>
</div>

<script>
function copyLink() {
    const link = document.querySelector('.link');
    const tempInput = document.createElement('input');
    tempInput.value = link.textContent;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('Referral link copied!');
}
</script>

</body>
</html>