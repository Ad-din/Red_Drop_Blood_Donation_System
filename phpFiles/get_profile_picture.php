<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get the user's email
$user_email = $_SESSION['email'];

// Fetch the profile picture from the database
$query = "SELECT profile_picture FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $profilePicture = $user['profile_picture'];

    if ($profilePicture) {
        header("Content-Type: image/jpeg"); // Adjust Content-Type to match your image type
        echo $profilePicture;
        exit();
    }
}

// If no image is found, you can serve a default profile picture
header("Content-Type: image/jpeg");
readfile("default-profile.jpg"); // Replace with the path to your default image
?>
