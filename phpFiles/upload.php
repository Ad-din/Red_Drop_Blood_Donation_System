<?php
session_start();
include 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileType = $_FILES['profile_picture']['type'];

        // Read the file content
        $fileContent = file_get_contents($fileTmpPath);

        // Get the user's email from the session
        $user_email = $_SESSION['email'];

        // Update the user's profile picture in the database
        $query = "UPDATE users SET profile_picture = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("bs", $fileContent, $user_email); // "b" is for binary data
        $stmt->send_long_data(0, $fileContent); // Sending binary data for the first parameter
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Profile picture updated successfully.";
        } else {
            echo "Failed to update profile picture.";
        }
    } else {
        echo "No file uploaded or an error occurred.";
    }
}
?>
