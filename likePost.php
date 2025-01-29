<?php
session_start();
include './phpFiles/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'];
    $userEmail = $_SESSION['email'];

    // Fetch the `userId` of the logged-in user
    $query = "SELECT userId FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['userId'];

    // Check if the user has already liked the post
    $checkLikeQuery = "SELECT * FROM Likes WHERE postId = ? AND userId = ?";
    $stmt = $conn->prepare($checkLikeQuery);
    $stmt->bind_param("ii", $postId, $userId);
    $stmt->execute();
    $likeExists = $stmt->get_result()->num_rows > 0;

    if (!$likeExists) {
        // Insert like
        $insertLikeQuery = "INSERT INTO Likes (postId, userId) VALUES (?, ?)";
        $stmt = $conn->prepare($insertLikeQuery);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
    }

    header("Location: dashboard.php");
}
?>
