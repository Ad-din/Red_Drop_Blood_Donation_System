<?php



if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    echo 'email Seession Error';
    exit();
}
$userEmail = $_SESSION['email'];

// Get the userId of the logged-in user
$query = "SELECT userId FROM Users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$uId = $user['userId'];


function getUserProfilePicture($userId, $conn) {
    // SQL query to fetch the profile picture
    $query = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $userId); // Bind the userId as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $profilePicture = $user['profile_picture'];

        if ($profilePicture) {
            header("Content-Type: image/jpeg"); // Adjust this based on your image type
            echo $profilePicture; // Output the binary image data
            exit();
        }
    }

    // If no image is found, serve a default profile picture
    header("Content-Type: image/jpeg");
    readfile("default-profile.jpg");
    exit();
}



// Fetch all posts
$sql = "SELECT p.postId, p.content, p.postDate, u.firstName, u.lastName 
        FROM Posts p 
        JOIN Users u ON p.userId = u.userId 
        ORDER BY p.postDate DESC";
$result = $conn->query($sql);


while ($post = $result->fetch_assoc()) {
    ?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="description" content="function Facebook Post">
  <meta name="keywords" content="HTML, CSS, JavaScript">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/postStyle2.css">
  <title>Facebook Posts</title>
</head>

<body>

  <h2 id="js-error" style="padding: 20px;">Loading...</h2>

  <div="mother">

    <div id="option">
      <div class="container">
        <ul>
          <li>
            <img src="assets/save_post.png" class="icon">
            <span class="option-title">Save Post</span>
            <p class="option-title">Add this to your saved items</p>
          </li>
          <li class="turn_off_post">
            <img src="assets/notification.png" class="icon">
            <span class="option-title">Turn off notification for this post.</span>
          </li>
          <li>
            <img src="assets/hide_post.png" class="icon">
            <span class="option-title">Hide post</span>
            <p class="option-title">Add this to your saved items.</p>
          </li>
          <li>
            <img src="assets/snooze.png" class="icon">
            <span class="option-title">Snooze</span>
            <p class="option-title">Temporarily stop seeing posts.</p>
          </li>
          <li>
            <img src="assets/unfollow.png" class="icon">
            <span class="option-title">Unfollow Rejwan Islam Rijvy</span>
            <p class="option-title">Temporarily stop seeing posts.</p>
          </li>
          <li>
            <img src="assets/find_post.png" class="icon">
            <span class="option-title">Find support or report pos</span>
            <p class="option-title">I'm concerned about this post.</p>
          </li>
        </ul>
      </div>
    </div>

  


    <div class="fb-post" id="fpost1">

      <!-- Top Section -->

      <div class="top-s">
        <div class="top-info">
          <div class="profile-picture">
            <img src="./phpFiles/get_profile_picture.php">
          </div>
          <div class="top-title">
            <div class="profile-name">
              <a href="#"><?php 
              echo "<p><strong>" . htmlspecialchars($post['firstName']) . " " . htmlspecialchars($post['lastName']) . "</strong> posted:</p>";

              
              ?></a>
            </div>
            <div class="post-time">
              <span><?php 
          echo "<p>Posted On: " . htmlspecialchars($post['postDate']) . "</p>";
          
          ?> </span>
              <img src="./svg/lock.svg">
            </div>
          </div>
          <div class="top-options">
            <button>
              <img src="./svg/three_dot.svg">
            </button>
          </div>
        </div>
        <div class="post-content">
          <?php 
          echo "<p>" . htmlspecialchars($post['content']) . "</p>";
          
          ?>
        </div>
      </div>

      <!-- Like section -->

      <div class="like-section">
        <div class="top-part">
          <div class="left-part">
            <div class="react">
              
            <?php 
            
              // Display like count
    $likeQuery = "SELECT COUNT(*) AS likeCount FROM Likes WHERE postId = ?";
    $stmt = $conn->prepare($likeQuery);
    $stmt->bind_param("i", $post['postId']);
    $stmt->execute();
    $likeResult = $stmt->get_result();
    $likeData = $likeResult->fetch_assoc();
   
            
            ?>


              <img src="./svg/like.svg" alt="">
            </div>
            <div class="id-name">
              <?php  echo "<p>Likes: " . $likeData['likeCount'] . "</p>";?>
            </div>
          </div>
          <div class="right-part">
            <p><span>1</span>Comments</p>
          </div>
        </div>
        
            
        <div class="bottom-part">
        <form action="likePost.php" method="POST">
        <?php echo "<input type='hidden' name='postId' value='" . $post['postId'] . "'>";?>
        <button type="submit">
            <div class="like-btn" fpost="1">
            <img src="./svg/thumbs-up.svg" alt="">
            <span>Like</span>
            </div>
            </button>
        
        
                     
          </form>
          <div class="comment-btn" fpost="1">
            <img src="./svg/message-square.svg" alt="">
            <span>Comment</span>
          </div>
        </div> 
        
      </div>

         <!-- Comment section-->


         <?php 
         
         $commentQuery = "SELECT c.content, c.date, u.firstName, u.lastName,u.userId 
                     FROM Comments c 
                     JOIN Users u ON c.userId = u.userId 
                     WHERE c.postId = ? 
                     ORDER BY c.date ASC";
    $stmt = $conn->prepare($commentQuery);
    $stmt->bind_param("i", $post['postId']);
    $stmt->execute();
    $commentResult = $stmt->get_result();
         
    
         ?>



         <div class="all-comments">
        <h4>All comments <img src="svg/sort-down.svg" class="all-comments-h4-i" alt=""></h4>
      </div>
    <?php 
    while ($comment = $commentResult->fetch_assoc()) {
    ?>
      <div class="comment-box">
        <div class="comment-container">
          <div class="comment">
            <img src="<?php getUserProfilePicture($comment['userId'],$conn)?>" alt="" class="comment-img">
            <div class="comment-text">
              <div class="comment-header">
                <p><strong>
                <?php   
                 echo  htmlspecialchars($comment['firstName']) . " " . htmlspecialchars($comment['lastName'])
                
                ?></strong></p>
              </div>
              <p><?php echo htmlspecialchars($comment['content'])?></p>
            </div>
          </div> 
        </div>
      </div>

    <?php 
    }
    ?>
    <form action="commentPost.php" method="POST">
      <div class="comment-s">
        <div class="comment-area">
          <div class="comment-profile-pic">
            <img src="<?php getUserProfilePicture($uId,$conn)?>" alt="user">
          </div>
          <div class="comment-input-area">
            <?php echo "<input type='hidden' name='postId' value='" . $post['postId'] . "'>";?>
            <input type="text" name="content" placeholder="Write a comment..." fpost="1" required>
            <button type='submit'>Comment</button>
            
          </div>
        </div>
      </div>
      </form>
    </div>
</div>
<script src="./assets/js/postScript.js"></script>
</body>
<?php


};


?>