<?php
session_start();
include './phpFiles/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'];
    $content = $_POST['content'];
    $userEmail = $_SESSION['email'];

    // Fetch the `userId` of the logged-in user
    $query = "SELECT userId FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['userId'];

    // Insert comment
    $insertCommentQuery = "INSERT INTO Comments (postId, userId, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertCommentQuery);
    $stmt->bind_param("iis", $postId, $userId, $content);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
