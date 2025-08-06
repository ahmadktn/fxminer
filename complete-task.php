<?php
require 'config.php';
auth();

$task = $_GET['task'] ?? '';
$user_id = $_SESSION['user_id'];
$rewards = ['invite_1' => 200, 'invite_5' => 1050, 'invite_10' => 2200];

if (in_array($task, array_keys($rewards))) {
    if (!taskDone($pdo, $user_id, $task)) {
        $pdo->prepare("INSERT INTO tasks (user_id, task_type) VALUES (?, ?)")->execute([$user_id, $task]);
        $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?")->execute([$rewards[$task], $user_id]);
        $msg = "₦" . $rewards[$task] . " added to your balance!";
    } else {
        $msg = "Already claimed.";
    }
} else {
    $msg = "Invalid task.";
}

echo "<script>alert('$msg'); location.href='tasks.php';</script>";