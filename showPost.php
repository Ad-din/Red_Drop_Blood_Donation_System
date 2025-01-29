<?php

include './phpFiles/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch all posts
$sql = "SELECT p.postId, p.content, p.postDate, u.firstName, u.lastName 
        FROM Posts p 
        JOIN Users u ON p.userId = u.userId 
        ORDER BY p.postDate DESC";
$result = $conn->query($sql);

while ($post = $result->fetch_assoc()) {
    echo "<div class='post' style='border:1px black solid;border-radius:10%'>";
    echo "<p><strong>" . htmlspecialchars($post['firstName']) . " " . htmlspecialchars($post['lastName']) . "</strong> posted:</p>";
    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
    echo "<p>Posted On: " . htmlspecialchars($post['postDate']) . "</p>";

    // Like button
    echo "<form method='POST' action='likePost.php'>";
    echo "<input type='hidden' name='postId' value='" . $post['postId'] . "'>";
    echo "<button type='submit'>Like</button>";
    echo "</form>";

    // Display like count
    $likeQuery = "SELECT COUNT(*) AS likeCount FROM Likes WHERE postId = ?";
    $stmt = $conn->prepare($likeQuery);
    $stmt->bind_param("i", $post['postId']);
    $stmt->execute();
    $likeResult = $stmt->get_result();
    $likeData = $likeResult->fetch_assoc();
    echo "<p>Likes: " . $likeData['likeCount'] . "</p>";

    // Comment form
    echo "<form method='POST' action='commentPost.php'>";
    echo "<input type='hidden' name='postId' value='" . $post['postId'] . "'>";
    echo "<textarea name='content' placeholder='Write a comment...' required></textarea>";
    echo "<button type='submit'>Comment</button>";
    echo "</form>";

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
