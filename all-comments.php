<?php

include 'partials/header.php';

// Fetch all comments for a specific post
if (isset($_GET['post_id'])) {
    $postId = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);

    $commentsQuery = "SELECT c.*, u.firstname, u.lastname, u.avatar FROM comments c
                      JOIN users u ON c.user_id = u.id
                      WHERE c.post_id = $postId
                      ORDER BY c.created_at DESC";

    $commentsResult = mysqli_query($connection, $commentsQuery);
} else {
    // Redirect to an error page or handle accordingly
    header('Location: error.php');
    exit();
}

?>

<section class="all_comments">
    <div class="container">
        <h2>All Comments</h2>

        <?php
        while ($comment = mysqli_fetch_assoc($commentsResult)) {
            include 'partials/comment.php';
        }
        ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>