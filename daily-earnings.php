<?php
// =============================
// AUTO DAILY EARNINGS SCRIPT
// Purpose: Credit users with daily returns from their investments
// Run once per day via CRON
// =============================

// Disable browser access (optional security)
if (php_sapi_name() !== 'cli' && !isset($_GET['cron'])) {
    http_response_code(403);
    die("Access denied. This script is for cron use only.");
}

require 'config.php';

echo "[START] Daily earnings script running at " . date('Y-m-d H:i:s') . "\n";

// Find all active investments where today is within the investment period
// and the user hasn't been paid today
$stmt = $pdo->prepare("
    SELECT i.id as investment_id, i.user_id, i.daily_return, i.end_date, u.balance
    FROM investments i
    JOIN users u ON i.user_id = u.id
    WHERE i.status = 'active'
    AND CURDATE() <= i.end_date
    AND NOT EXISTS (
        SELECT 1 FROM earnings_log el 
        WHERE el.investment_id = i.id 
        AND el.earned_at = CURDATE()
    )
");

$stmt->execute();
$investments = $stmt->fetchAll();

if (count($investments) === 0) {
    echo "[INFO] No earnings to process today.\n";
} else {
    $pdo->beginTransaction();
    try {
        foreach ($investments as $row) {
            // Add daily return to user's balance
            $new_balance = $row['balance'] + $row['daily_return'];
            $pdo->prepare("UPDATE users SET balance = ? WHERE id = ?")
                ->execute([$new_balance, $row['user_id']]);

            // Log the earning
            $pdo->prepare("INSERT INTO earnings_log (investment_id, user_id, amount, earned_at) VALUES (?, ?, ?, CURDATE())")
                ->execute([$row['investment_id'], $row['user_id'], $row['daily_return']]);

            echo "[SUCCESS] User ID: {$row['user_id']} earned ₦{$row['daily_return']} from investment.\n";
        }

        // Mark investments as completed if end date is today or passed
        $today = date('Y-m-d');
        $pdo->prepare("UPDATE investments SET status = 'completed' WHERE end_date < ? OR end_date = ?")
            ->execute([$today, $today]);

        $pdo->commit();
        echo "[END] Daily earnings distributed successfully.\n";
    } catch (Exception $e) {
        $pdo->rollback();
        echo "[ERROR] Failed to process earnings: " . $e->getMessage() . "\n";
    }
}
