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

// Fetch all users except the logged-in user
$sql = "SELECT userId, firstName, lastName, bloodType, city, 'default.png' AS image FROM Users WHERE userId != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$users = $stmt->get_result();

echo "<h2>All Users</h2>";
while ($user = $users->fetch_assoc()) {
    echo "<div class='user'>";
    echo "<img src='images/" . htmlspecialchars($user['image']) . "' alt='Profile Picture' style='width:50px;height:50px;border-radius:50%;'>";
    echo "<p>Name: " . htmlspecialchars($user['firstName']) . " " . htmlspecialchars($user['lastName']) . "</p>";
    echo "<p>Blood Type: " . htmlspecialchars($user['bloodType']) . "</p>";
    echo "<p>City: " . htmlspecialchars($user['city']) . "</p>";

    // Add Friend Button
    echo "<form method='POST' action='sendFriendRequest.php'>";
    echo "<input type='hidden' name='friendId' value='" . $user['userId'] . "'>";
    echo "<button type='submit'>Add Friend</button>";
    echo "</form>";
    echo "</div><hr>";
}
?>
