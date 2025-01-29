<?php 
session_start();
include './phpFiles/config.php';

$conn=mysqli_connect("localhost","root","","red_drop") or die("DB CONNECT FAILED");


$sql="SELECT * FROM users";

$res=mysqli_query($conn,$sql);

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$user_email=$_SESSION['email'];

$query = "SELECT firstname,lastname,email,BloodType profile_picture FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();





?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beautiful Bootstrap Navbar with Menu Icons</title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="./assets/css/header.css">
</head> 
<body>
<nav class="navbar navbar-inverse navbar-expand-xl navbar-dark">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><i class="fa fa-cube"></i>Red<b>Drop</b></a>  		
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">		
		<form class="navbar-form form-inline">
			<div class="input-group search-box">								
				<input type="text" id="search" class="form-control" placeholder="Search here...">
				<span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
			</div>
		</form>
		<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="dasboard.php"><i class="fa fa-home"></i><span>Home</span></a></li>

			<li class="active"><a href="./addFriends/allUsers.php"><i class="bi bi-person-fill-add"></i><span>Friends</span></a></li>

			<li><a href=""><i class="fa fa-envelope"></i><span>Messages</span></a></li>		

			<li><a href="notifications.php"><i class="fa fa-bell"></i><span>Notifications</span></a></li>

			<?php  
			
			if ($result->num_rows > 0) {
				$user = $result->fetch_assoc();
				$profilePicture = $user['profile_picture'];
		
			
			
			?>
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle user-action"><img src="./phpFiles/get_profile_picture.php" class="avatar" alt="Avatar"><?php echo $user["firstname"] ." ".$user["lastname"] ?><b class="caret"></b></a>

				<?php
				
			} else {
				echo "User not found.";
			}
				
				?>
				<ul class="dropdown-menu">
					<li><a href="profile.php"><i class="fa fa-user-o"></i> Profile</a></li>
					<li><a href="#"><i class="fa fa-calendar-o"></i> Calendar</a></li>
					<li><a href="#"><i class="fa fa-sliders"></i> Settings</a></li>
					<li class="divider"></li>
					<li><a href="<?php 
					 ?>
					 index.php
					 "><i class="material-icons">&#xE8AC;</i> Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
</body>
</html>                            