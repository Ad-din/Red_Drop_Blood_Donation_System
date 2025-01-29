<?php 
session_start();

include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$user_email=$_SESSION['email'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName=$_POST['firstname'];
    $lastName=$_POST['lastname'];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $bloodType = $_POST['bloodType'];
   
    $rawDoB = new DateTime($_POST['dateOfBirth']);
    $DOB = $rawDoB->format("y-m-d");
    $phoneNumber=$_POST['phoneNumber'];
    $gender=$_POST['gender'];
    $area=$_POST['area'];
    $city=$_POST['city'];
    $zipcode=$_POST['zipcode'];


    $sql = "UPDATE Users 
    SET firstName = ?, lastName = ?, phoneNumber = ?, dob = ?, gender = ?, bloodType = ?, area = ?, city = ?, zipcode = ?, password = ? 
    WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $firstName, $lastName, $phoneNumber, $DOB, $gender, $bloodType, $area, $city, $zipcode, $password, $user_email);

if ($stmt->execute()) {
echo "Profile updated successfully!";
} else {
echo "Error: " . $stmt->error;
}


}


?>