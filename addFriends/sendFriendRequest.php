<?php
session_start();
include '../phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $friendId = $_POST['friendId'];
    $userEmail = $_SESSION['email'];

    // Get logged-in user's ID
    $query = "SELECT userId FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $loggedInUserId = $user['userId'];

    // Insert friend request
    $sql = "INSERT INTO UserFriends (userId, friendId, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $loggedInUserId, $friendId);

    if ($stmt->execute()) {
        echo "Friend request sent!";
        header("Location: allUsers.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
