<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Blood Request</title>
</head>
<body>
    <h2>Create Blood Request</h2>
    <form method="POST" action="savePost.php">
        <label for="bloodGroup">Needed Blood Group:</label>
        <select name="bloodGroup" required>
            <option value="">Select</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <label for="city">Search City:</label>
        <input type="text" name="city" placeholder="Enter city name" required>

        <label for="content">Additional Information (Optional):</label>
        <textarea name="content" placeholder="Write something..."></textarea>

        <button type="submit">Post</button>
    </form>
</body>
</html>
