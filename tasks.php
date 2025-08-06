<?php
// ========================
// tasks.php
// Purpose: Display user tasks and referral rewards
// Current Status: DISABLED - Showing "Coming Soon" message
// ========================

// Include database connection and authentication
// require 'config.php';
// auth();

// // Get user ID from session
// $user_id = $_SESSION['user_id'];

// // Count how many users this person has referred (based on phone number)
// $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE referred_by = (SELECT phone FROM users WHERE id = ?)");
// $stmt->execute([$user_id]);
// $ref_count = $stmt->fetchColumn();

// // Function to check if a task has already been completed
// function taskDone($pdo, $user_id, $task) {
//     $stmt = $pdo->prepare("SELECT id FROM tasks WHERE user_id = ? AND task_type = ?");
//     $stmt->execute([$user_id, $task]);
//     return $stmt->rowCount() > 0;
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>FXminer/Tasks</title>
    <link rel="stylesheet" type="text/css" href="tasks.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Page Header -->
<div class="upper"><center>Tasks</center></div>

<!-- Back Button to Home -->
<a href="home.php"><span class="back">&#x2190;</span></a>

<!-- Main Content -->
<center>
    <h1>Available Tasks</h1>
</center>

<!-- Instead of task table, show "Coming Soon" message -->
<div style="text-align: center; padding: 50px; font-family: Arial, sans-serif;">
    <h2>🎉 Tasks Are Coming Soon!</h2>
    <p>We're preparing exciting new ways for you to earn extra rewards.</p>
    <p>Stay tuned — more features launching soon!</p>
    <br>
    <img src="gift.png" width="80" alt="Coming Soon" style="opacity: 0.6;">
</div>

<!-- Hidden Task Table (Commented out - for future use) -->
<!--
<div class="divtasks">
<table class="tasks-table" border="1">
    <tr>
        <th>Invite 1 person to claim ₦200</th>
        <th>
            <?php if ($ref_count >= 1 && !taskDone($pdo, $user_id, 'invite_1')): ?>
                <a href="complete-task.php?task=invite_1"><button>Reward</button></a>
            <?php elseif (taskDone($pdo, $user_id, 'invite_1')): ?>
                Claimed
            <?php else: ?>
                <button disabled>Invite more</button>
            <?php endif; ?>
        </th>
    </tr>
    <tr>
        <th>Invite 5 people to claim ₦1,050</th>
        <th>
            <?php if ($ref_count >= 5 && !taskDone($pdo, $user_id, 'invite_5')): ?>
                <a href="complete-task.php?task=invite_5"><button>Reward</button></a>
            <?php elseif (taskDone($pdo, $user_id, 'invite_5')): ?>
                Claimed
            <?php else: ?>
                <button disabled>Invite more</button>
            <?php endif; ?>
        </th>
    </tr>
    <tr>
        <th>Invite 10 people to claim ₦2,200</th>
        <th>
            <?php if ($ref_count >= 10 && !taskDone($pdo, $user_id, 'invite_10')): ?>
                <a href="complete-task.php?task=invite_10"><button>Reward</button></a>
            <?php elseif (taskDone($pdo, $user_id, 'invite_10')): ?>
                Claimed
            <?php else: ?>
                <button disabled>Invite more</button>
            <?php endif; ?>
        </th>
    </tr>
</table>
</div><br>
-->

<!-- Rules Dialog (Commented out) -->
<!--
<button onclick="myDialog.showModal()">Invitation Rule</button>
<dialog id="myDialog">
    <ul>
        <h3>1. Each person you invite must register and deposit to count.<br>
        2. Fake accounts will result in permanent ban.</h3>
    </ul>
    <button onclick="myDialog.close()">Ok</button>
</dialog>
-->

<!-- Bottom Navigation Icons -->
<div class="divicons">
    <a href="home.php"><img class="icons" src="home icon.png" width="40" height="40"></a>
    <a href="tasks.php"><img class="icons" src="task icon.png" width="40" height="40"></a>
    <a href="mine.php"><img class="icons" src="me icon.png" width="40" height="40"></a>
    <a href="https://t.me/fxminer001"><img class="telegram" src="telegram icon.png" width="40" height="40"></a>
</div>

<!-- JavaScript for Dialog (Commented out) -->
<!--
<script>
const myDialog = document.getElementById("myDialog");
</script>
-->

</body>
</html>
