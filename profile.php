<?php
session_start();
include './phpFiles/config.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$user_email=$_SESSION['email'];

$query = "SELECT userId,firstname,lastname,email,BloodType  FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();



?>











<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link rel="stylesheet" href="./assets/css/profile.css">
<section id="content" class="container">
    <!-- Begin .page-heading -->
    <div class="page-heading">
    <?php 
            if ($result->num_rows > 0) {
                $users = $result->fetch_assoc();
                
                
            
            
            
            ?>

        <div class="media clearfix">
          <div style="" class="media-left pr30">
            
          
            <div class="profile-picture" >
            <img id="profile-pic" class="media-object mw150" src="./phpFiles/get_profile_picture.php" alt="...">
            </div>
              
            
            
          </div>                      
          <div class="media-body va-m">
           
            <h2 class="media-heading"><?php echo $users["firstname"] ." ".$users["lastname"] ;?>
              <small> - Profile</small>
            </h2>
            <button onclick="location.href = './phpFiles/updateProfile.php';" id="myButton" class="float-left submit-button" >Complete Your Profile</button>
            <div class="media-links">
             
            </div>
          </div>
        </div>
        <?php 
         
          
        ?>
    </div>

    <div class="row">
        <div class="col-md-4">
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-icon">
                <i class="fa fa-star"></i>
              </span>
              <span class="panel-title">Your Details</span>
            </div>
            <div class="panel-body pn">
              <table class="table mbn tc-icon-1 tc-med-2 tc-bold-last">
               
                <tbody>
                  <tr>
                    <td>
                      <span class="fa fa-desktop text-warning"></span>
                    </td>
                    <td>Television</td>
                    <td>
                      <i class="fa fa-caret-up text-info pr10"></i>$855,913</td>
                  </tr>
                  <tr>
                    <td>
                      <span class="fa fa-microphone text-primary"></span>
                    </td>
                    <td>Radio</td>
                    <td>
                      <i class="fa fa-caret-down text-danger pr10"></i>$349,712</td>
                  </tr>
                  <tr>
                    <td>
                      <span class="fa fa-newspaper-o text-info"></span>
                    </td>
                    <td>Newspaper</td>
                    <td>
                      <i class="fa fa-caret-up text-info pr10"></i>$1,259,742</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-icon">
                <i class="fa fa-trophy"></i>
              </span>
              <span class="panel-title"> My Skills</span>
            </div>
            <div class="panel-body pb5">
              <span class="label label-warning mr5 mb10 ib lh15">Default</span>
              <span class="label label-primary mr5 mb10 ib lh15">Primary</span>
              <span class="label label-info mr5 mb10 ib lh15">Success</span>
              <span class="label label-success mr5 mb10 ib lh15">Info</span>
              <span class="label label-alert mr5 mb10 ib lh15">Warning</span>
              <span class="label label-system mr5 mb10 ib lh15">Danger</span>
              <span class="label label-info mr5 mb10 ib lh15">Success</span>
              <span class="label label-success mr5 mb10 ib lh15">Ui Design</span>
              <span class="label label-primary mr5 mb10 ib lh15">Primary</span>

            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-icon">
                <i class="fa fa-pencil"></i>
              </span>
              <span class="panel-title">About Me</span>
            </div>
            <div class="panel-body pb5">

              <h6>Experience</h6>

              <h4>Facebook Internship</h4>
              <p class="text-muted"> University of Missouri, Columbia
                <br> Student Health Center, June 2010 - 2012
              </p>

              <hr class="short br-lighter">

              <h6>Education</h6>

              <h4>Bachelor of Science, PhD</h4>
              <p class="text-muted"> University of Missouri, Columbia
                <br> Student Health Center, June 2010 through Aug 2011
              </p>

              <hr class="short br-lighter">

              <h6>Accomplishments</h6>

              <h4>Successful Business</h4>
              <p class="text-muted pb10"> University of Missouri, Columbia
                <br> Student Health Center, June 2010 through Aug 2011
              </p>

            </div>
          </div>
        </div>
        <div class="col-md-8">

          <div class="tab-block">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#tab1" data-toggle="tab">Your Posts</a>
              </li>
              <li>
                <a href="#tab1" data-toggle="tab">Social</a>
              </li>
              <li>
                <a href="#tab1" data-toggle="tab">Media</a>
              </li>
            </ul>
            <div class="tab-content p30" style="height: 730px;">
              <?php 
            $userId= $users["userId"];
             $sql = "SELECT postId, content, postDate FROM Posts WHERE userId = ? ORDER BY postDate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$posts = $stmt->get_result();

echo "<h2>Your Posts</h2>";
while ($post = $posts->fetch_assoc()) {
    echo "<div class='post'>";
    echo "<p>Content: " . htmlspecialchars($post['content']) . "</p>";
    echo "<p>Posted On: " . htmlspecialchars($post['postDate']) . "</p>";

    // Fetch like count for the post
    $likeQuery = "SELECT COUNT(*) AS likeCount FROM Likes WHERE postId = ?";
    $stmt = $conn->prepare($likeQuery);
    $stmt->bind_param("i", $post['postId']);
    $stmt->execute();
    $likeResult = $stmt->get_result();
    $likeData = $likeResult->fetch_assoc();
    echo "<p>Likes: " . $likeData['likeCount'] . "</p>";

    // Fetch and display comments
    $commentQuery = "SELECT c.content, c.date, u.firstName, u.lastName 
                     FROM Comments c 
                     JOIN Users u ON c.userId = u.userId 
                     WHERE c.postId = ? 
                     ORDER BY c.date ASC";
    $stmt = $conn->prepare($commentQuery);
    $stmt->bind_param("i", $post['postId']);
    $stmt->execute();
    $commentResult = $stmt->get_result();

    echo "<div class='comments'>";
    while ($comment = $commentResult->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($comment['firstName']) . " " . htmlspecialchars($comment['lastName']) . ":</strong> " . htmlspecialchars($comment['content']) . "</p>";
    }
    echo "</div>";

    echo "</div>";
}
              ?>
            </div>
          </div>
        </div>
        <?php 
         } else {
          echo "User not found.";
      }
    
        ?>
      </div>
  </section>

  <script src='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>