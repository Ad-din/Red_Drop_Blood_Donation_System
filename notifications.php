<?php
session_start();
include './phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

// Fetch the `userId` of the logged-in user
$query = "SELECT userId FROM Users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$userId = $user['userId'];

// Fetch notifications for the user
$sql = "SELECT message, timestamp FROM Notifications WHERE userId = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$notifications = $stmt->get_result();


echo "<h2>Notifications</h2>";
while ($notification = $notifications->fetch_assoc()) {
    echo "<p>" . htmlspecialchars($notification['message']) . " - " . htmlspecialchars($notification['timestamp']) . "</p>";
}
?>
