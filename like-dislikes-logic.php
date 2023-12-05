
<?php
// Include your database connection logic here
require 'config/database.php';

// Check if the user is logged in
if ($_POST['isLoggedIn'] === 'true' && isset($_SESSION['user-id'])) {
    // Get the action and post ID from the AJAX request
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);

    // Validate the action
    if ($action !== 'like' && $action !== 'dislike') {
        exit('Invalid action');
    }

    // Check if the user has already liked or disliked the post
    $checkVoteQuery = "SELECT action FROM likes_dislikes WHERE post_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($connection, $checkVoteQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $postId, $_SESSION['user-id']);
    mysqli_stmt_execute($stmt);
    $existingVote = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Update the post's like or dislike count based on the action
    if (!$existingVote) {
        $updateQuery = "INSERT INTO likes_dislikes (post_id, user_id, action) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'iis', $postId, $_SESSION['user-id'], $action);
        mysqli_stmt_execute($stmt);
    } else {
        // User has already voted, remove the vote
        $deleteVoteQuery = "DELETE FROM likes_dislikes WHERE post_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($connection, $deleteVoteQuery);
        mysqli_stmt_bind_param($stmt, 'ii', $postId, $_SESSION['user-id']);
        mysqli_stmt_execute($stmt);
    }

    // Fetch the updated like and dislike counts
    $fetchCountsQuery = "SELECT SUM(CASE WHEN action = 'like' THEN 1 ELSE 0 END) as like_count, 
                                   SUM(CASE WHEN action = 'dislike' THEN 1 ELSE 0 END) as dislike_count
                         FROM likes_dislikes WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $fetchCountsQuery);
    mysqli_stmt_bind_param($stmt, 'i', $postId);
    mysqli_stmt_execute($stmt);
    $newCounts = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Return the updated counts as JSON
    header('Content-Type: application/json');
    echo json_encode($newCounts);
} else {
    // User is not logged in, handle accordingly
    exit('User not logged in');
}
