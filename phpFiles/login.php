<?php
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

    // Retrieve email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful!";
            // Here you can create a session or redirect the user
            
            $_SESSION['email'] = $email;
            session_regenerate_id(true);
            header("Location: ../dashboard.php"); // Redirect to a dashboard or main page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
