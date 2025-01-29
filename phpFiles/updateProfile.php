
<?php  


session_start();

include 'config.php';

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
if(mysqli_num_rows($result)>0){
    $user = $result->fetch_assoc();
    




?>
<head>
  <link rel="stylesheet" href="./assets/css/updateProfile.css">
  

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">

</head>



            
            <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="get_profile_picture.php"><span class="font-weight-bold"><?php echo $user['firstname']." ".$user['lastname']?></span><span class="text-black-50"><?php echo $user['email']?></span><span> <div style="">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Upload Profile Picture:</label>
             <input type="file" name="profile_picture" id="profile_picture" required>
              <button type="submit">Upload</button>
            </form>


            </div></span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form action="updateProfileData.php" method="post">
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">FirstName</label><input type="text" name="firstname" class="form-control" placeholder="first name" value="<?php echo $user['firstname']?>"></div>
                    <div class="col-md-6"><label class="labels">LastName</label><input type="text" name="lastname" class="form-control" value="<?php echo $user['lastname']?>" placeholder="last Name"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" name="phoneNumber" class="form-control" placeholder="enter phone number" value=""></div>
                    <div class="col-md-12"><label class="labels">Blood Type</label>
                  
                    <?php 
// Fetch blood types
$sql = "SHOW COLUMNS FROM Users WHERE Field = 'bloodType'";
$result = mysqli_query($conn, $sql);

if ($result && $row = $result->fetch_assoc()) {
    // Extract ENUM values
    preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
    $bloodTypes = explode("','", $matches[1]);
} else {
    echo "Error fetching blood types.";
    $bloodTypes = [];
}

// Fetch user's current bloodType

$user_email = $_SESSION['email']; // Assuming you're storing the user's email in a session
$sqlUser = "SELECT bloodType FROM users WHERE email = '$user_email'";
$resultUser = mysqli_query($conn, $sqlUser);

if ($resultUser && $rowUser = $resultUser->fetch_assoc()) {
    $selectedBloodType = $rowUser['bloodType']; // Current blood type of the user
} else {
    $selectedBloodType = ''; // Default to empty if no record is found
}
?>

<!-- Dropdown -->
<select class="form-control" name="bloodType" required>
    <option value="" style="color:gray">Select Blood Group</option>
    <?php foreach ($bloodTypes as $bloodType): ?>
        <option value="<?= htmlspecialchars($bloodType) ?>" 
            <?php if ($bloodType == $selectedBloodType) echo "selected"; ?>>
            <?= htmlspecialchars($bloodType) ?>
        </option>
    <?php endforeach; ?>
</select>

                  
                  </div>
                    <div class="col-md-12"><label class="labels">Area</label><input type="text" name="area" class="form-control" placeholder="enter area address" value=""></div>
                    <div class="col-md-12"><label class="labels">City</label><input type="text" name="city" class="form-control" placeholder="enter city name" value=""></div>
                    <div class="col-md-12"><label class="labels">ZipCode</label><input type="text" name="zipcode" class="form-control" placeholder="enter zipcode" value=""></div>
                    <div class="col-md-12"><label class="labels">Gender</label>

                    
<?php 
                
                $sql="SHOW COLUMNS FROM Users WHERE Field = 'gender'";

                 $result=mysqli_query($conn,$sql);

                 if ($result && $row = $result->fetch_assoc()) {
                     // Extract ENUM values
                     preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
                     $genders = explode("','", $matches[1]);
                 } else {
                     echo "Error fetching blood types.";
                     $genders = [];
                 }
         
              ?>
          <select class="form-control" name="gender"  required>
             <option value="" style="color:gray" >Select Gender</option>
             <?php foreach ($genders as $gender): ?>
              <option value="<?= htmlspecialchars($gender) ?>"><?= htmlspecialchars($gender) ?></option>
              <?php endforeach; ?>
         </select>

                  
                  </div>
                    <div class="col-md-12"><label class="labels">Date Of Birth</label><input type="date" name="dateOfBirth"class="form-control" placeholder="enter your BirthDate" value=""></div>
                    <div class="col-md-12"><label class="labels">Email ID</label><input type="text" name="email" class="form-control" placeholder="enter email id" value="<?php echo $user['email'];?>"></div>
                    <div class="col-md-12"><label class="labels">Change Password</label><input type="password" name="password" class="form-control" placeholder="change your Password" value=""></div>
                    
                </div>
                
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
            </div>
            </form>
        </div>
        <?php 
        
      }else{
        echo "data couldnot be extractede!";
    }

        ?>
        <div class="col-md-4">
            <!-- <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                <div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
                <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
            </div> -->
        </div>
    </div>
</div>
</div>
</div>           
