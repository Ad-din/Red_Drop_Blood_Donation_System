<?php
session_start();
include './phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bloodGroup = $_POST['bloodGroup'];
    $city = $_POST['city'];
    $content = $_POST['content'];
    $userEmail = $_SESSION['email'];

    // Get the userId of the logged-in user
    $query = "SELECT userId FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['userId'];

    // Insert the post into the Posts table
    $sql = "INSERT INTO Posts (userId, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $content);

    if ($stmt->execute()) {
        echo "Post created successfully!";

        // Notify users with matching blood type
        $notificationSql = "SELECT userId FROM Users WHERE bloodType = ? AND userId != ?";
        $stmt = $conn->prepare($notificationSql);
        $stmt->bind_param("si", $bloodGroup, $userId);
        $stmt->execute();
        $users = $stmt->get_result();

        while ($user = $users->fetch_assoc()) {
            $recipientId = $user['userId'];
            $message = "A new blood request for $bloodGroup in $city has been posted.";
            $insertNotification = "INSERT INTO Notifications (userId, message) VALUES (?, ?)";
            $stmt = $conn->prepare($insertNotification);
            $stmt->bind_param("is", $recipientId, $message);
            $stmt->execute();
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
