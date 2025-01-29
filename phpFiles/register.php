<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $bloodType = $_POST['bloodType'];


    // Check if username or email already exists
    $checkUser = "SELECT * FROM users WHERE firstName='$firstName' OR email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO Users (firstName, lastName, email, password, bloodType) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $bloodType);
        
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
    }
    $conn->close();
} else {
    echo "Invalid request!";
}
?> 