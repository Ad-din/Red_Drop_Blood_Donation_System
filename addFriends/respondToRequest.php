<?php
session_start();
include '../phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requesterId = $_POST['requesterId'];
    $response = $_POST['response'];
    $userEmail = $_SESSION['email'];

    // Get logged-in user's ID
    $query = "SELECT userId FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $loggedInUserId = $user['userId'];

    if ($response === 'accept') {
        // Update status to "Accepted"
        $sql = "UPDATE UserFriends SET status = 'Accepted' WHERE userId = ? AND friendId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $requesterId, $loggedInUserId);
        $stmt->execute();

        // Create reciprocal record
        $sql = "INSERT INTO UserFriends (userId, friendId, status) VALUES (?, ?, 'Accepted')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $loggedInUserId, $requesterId);
        $stmt->execute();

        echo "Friend request accepted!";
    } elseif ($response === 'reject') {
        // Remove the pending request
        $sql = "DELETE FROM UserFriends WHERE userId = ? AND friendId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $requesterId, $loggedInUserId);
        $stmt->execute();

        echo "Friend request rejected!";
    }

    header("Location: friendRequests.php");
}
?>
