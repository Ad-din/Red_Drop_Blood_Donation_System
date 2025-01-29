<?php

$conn=mysqli_connect("localhost","root","","red_drop") or die("Connenction With DB Failed");



?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title></title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="phpFiles/register.php" method="POST">
                <h1>Create Account</h1>
               
                <span> use your email for registeration</span>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name"  required >
                <input type="email" id="email" name="email" placeholder="Email" required>
                <?php 
                
                $sql="SHOW COLUMNS FROM Users WHERE Field = 'bloodType'";

$result=mysqli_query($conn,$sql);

if ($result && $row = $result->fetch_assoc()) {
    // Extract ENUM values
    preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
    $bloodTypes = explode("','", $matches[1]);
} else {
    echo "Error fetching blood types.";
    $bloodTypes = [];
}
                
                ?>
                <select name="bloodType" style="width: 320px;" required>
                <option value="" style="color:gray" >Select Blood Group</option>
                    <?php foreach ($bloodTypes as $bloodType): ?>
                     <option value="<?= htmlspecialchars($bloodType) ?>"><?= htmlspecialchars($bloodType) ?></option>
                     <?php endforeach; ?>
                </select>

                <input type="password" id="password" name="password" placeholder="Password">
                <button id="regFormBtn" name="save" type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form id="loginForm" method="POST" action="phpFiles/login.php">
                <h1>Sign In</h1>
               
                <span> use your email password</span>
                <input type="email" name="email"  placeholder="Email">
                <input type="password" name="password" placeholder="Password">

                <a href="#">Forget Your Password?</a>
                <button id="loginFormBtn" type="submit">Sign In</button>
                
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome To RedDrop!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
       

    </script>
    <script src="script.js"></script>
</body>

</html>