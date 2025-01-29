<?php
session_start();
include '../phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get logged-in user's ID
$userEmail = $_SESSION['email'];
$query = "SELECT userId FROM Users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$loggedInUserId = $user['userId'];

// Fetch all accepted friends
$sql = "SELECT u.firstName, u.lastName, u.bloodType, u.city 
        FROM UserFriends uf 
        JOIN Users u ON uf.friendId = u.userId 
        WHERE uf.userId = ? AND uf.status = 'Accepted'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$friends = $stmt->get_result();

echo "<h2>Your Friends</h2>";
while ($friend = $friends->fetch_assoc()) {
    echo "<div class='friend'>";
    echo "<p>Name: " . htmlspecialchars($friend['firstName']) . " " . htmlspecialchars($friend['lastName']) . "</p>";
    echo "<p>Blood Type: " . htmlspecialchars($friend['bloodType']) . "</p>";
    echo "<p>City: " . htmlspecialchars($friend['city']) . "</p>";
    echo "</div><hr>";
}
?>
