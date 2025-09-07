<?php
session_start();
require_once '../model/hydrationModel.php';

$user_id = $_SESSION['user_id'] ?? 1;
$conn = connectDB();

ensureGoalExists($conn, $user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['log_water']) && isset($_POST['amount'])) {
        logWater($conn, $user_id, intval($_POST['amount']));
    }

    if (isset($_POST['update_goal']) && isset($_POST['daily_goal'])) {
        updateGoal($conn, $user_id, intval($_POST['daily_goal']));
    }

    
    header("Location: ../controller/hydrationController.php");
    exit;
}


$total_today = getTotalToday($conn, $user_id);
$daily_goal = getDailyGoal($conn, $user_id);
$history = getRecentEntries($conn, $user_id);

$conn->close();

require_once '../view/hydrationView.php';
?>
