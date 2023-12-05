<?php
require 'config/database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitComment'])) {
    // Validate user session
    if (!isset($_SESSION['user-id'])) {
        // Handle unauthorized access
        // You can redirect or show an error message
        die("Unauthorized access");
    }

    $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user-id'];
    $commentBody = filter_input(INPUT_POST, 'commentBody', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    // Insert comment into the database
    $insertCommentQuery = "INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertCommentQuery);
    mysqli_stmt_bind_param($stmt, 'iis', $postId, $userId, $commentBody);
    mysqli_stmt_execute($stmt);

    // Update the comments count in the posts table
    $updateCountQuery = "UPDATE posts SET comments_count = comments_count + 1 WHERE id = ?";
    $stmt = mysqli_prepare($connection, $updateCountQuery);
    mysqli_stmt_bind_param($stmt, 'i', $postId);
    mysqli_stmt_execute($stmt);

    // Redirect back to the post page
    header("Location: " . ROOT_URL . "post.php?id={$postId}");
    exit();
}


//update comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editComment'])) {
    if (!isset($_SESSION['user-id'])) {
        die("Unauthorized access");
    }

    $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
    $newCommentBody = filter_input(INPUT_POST, 'newCommentBody', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Update comment in the database
    $updateCommentQuery = "UPDATE comments SET body = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($connection, $updateCommentQuery);
    mysqli_stmt_bind_param($stmt, 'sii', $newCommentBody, $commentId, $_SESSION['user-id']);
    mysqli_stmt_execute($stmt);
}

// Delete comment

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteComment'])) {
    if (!isset($_SESSION['user-id'])) {
        die("Unauthorized access");
    }

    $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);

    // Get the post ID before deleting the comment
    $getPostIdQuery = "SELECT post_id FROM comments WHERE id = ?";
    $stmt = mysqli_prepare($connection, $getPostIdQuery);
    mysqli_stmt_bind_param($stmt, 'i', $commentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $postId = $row['post_id'];

    // Delete comment
    $deleteCommentQuery = "DELETE FROM comments WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($connection, $deleteCommentQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $commentId, $_SESSION['user-id']);
    mysqli_stmt_execute($stmt);

    // Update the comments count in the posts table
    $updateCountQuery = "UPDATE posts SET comments_count = comments_count - 1 WHERE id = ?";
    $stmt = mysqli_prepare($connection, $updateCountQuery);
    mysqli_stmt_bind_param($stmt, 'i', $postId);
    mysqli_stmt_execute($stmt);

    header("Location: " . ROOT_URL . "post.php?id={$postId}");
    exit();
}
