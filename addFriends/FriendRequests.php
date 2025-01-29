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

// Fetch incoming friend requests
$sql = "SELECT uf.userId, u.firstName, u.lastName, u.bloodType, u.city 
        FROM UserFriends uf 
        JOIN Users u ON uf.userId = u.userId 
        WHERE uf.friendId = ? AND uf.status = 'Pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$requests = $stmt->get_result();

echo "<h2>Friend Requests</h2>";
while ($request = $requests->fetch_assoc()) {
    echo "<div class='request'>";
    echo "<p>Name: " . htmlspecialchars($request['firstName']) . " " . htmlspecialchars($request['lastName']) . "</p>";
    echo "<p>Blood Type: " . htmlspecialchars($request['bloodType']) . "</p>";
    echo "<p>City: " . htmlspecialchars($request['city']) . "</p>";

    // Accept and Reject Buttons
    echo "<form method='POST' action='respondToRequest.php'>";
    echo "<input type='hidden' name='requesterId' value='" . $request['userId'] . "'>";
    echo "<button type='submit' name='response' value='accept'>Accept</button>";
    echo "<button type='submit' name='response' value='reject'>Reject</button>";
    echo "</form>";
    echo "</div><hr>";
}
?>
