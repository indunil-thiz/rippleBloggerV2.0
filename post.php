<?php
include 'partials/header.php';
// // Include comment logic
// include 'comment-logic.php';

// fetch post from database
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . 'blog.php');
  die();
}

// Fetch the like and dislike counts from the database
$getLikesDislikesQuery = "SELECT 
    SUM(CASE WHEN action = 'like' THEN 1 ELSE 0 END) as like_count, 
    SUM(CASE WHEN action = 'dislike' THEN 1 ELSE 0 END) as dislike_count
FROM likes_dislikes WHERE post_id = ?";
$stmt = mysqli_prepare($connection, $getLikesDislikesQuery);
mysqli_stmt_bind_param($stmt, 'i', $post['id']);
mysqli_stmt_execute($stmt);
$likesDislikes = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$likeCount = $likesDislikes['like_count'];
$dislikeCount = $likesDislikes['dislike_count'];

// If the counts are null, set them to 0
$likeCount = is_null($likeCount) ? 0 : $likeCount;
$dislikeCount = is_null($dislikeCount) ? 0 : $dislikeCount;


?>

<section class="single_post">
  <div class="container single_post_container">
    <h2><?= $post['title'] ?></h2>
    <div class="post_author">
      <?php
      $author_id = $post['author_id'];
      $author_query = "SELECT * FROM users WHERE id=$author_id";
      $author_result = mysqli_query($connection, $author_query);
      $author = mysqli_fetch_assoc($author_result);
      ?>
      <div class="post_author_avatar">
        <img src="./images/<?= $author['avatar'] ?>" alt="avatar">
      </div>

      <div class="post_author_info">
        <h5>Post By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
        <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
      </div>
    </div>

    <div class="single_post_thumbnail">
      <img src="./images/<?= $post['thumbnail'] ?>" alt="wildlife">
    </div>
    <p><?= $post['body'] ?></p>

    <!-- Functionality -->
    <div class="buttons-container">
      <button id="likeBtn" class="like-btn" onclick="likeDislikePost(<?= $post['id'] ?>, 'like')">Like <span id="likeCount"><?= $likeCount ?></span></button>
      <button id="dislikeBtn" class="dislike-btn" onclick="likeDislikePost(<?= $post['id'] ?>, 'dislike')">Dislike <span id="dislikeCount"><?= $dislikeCount ?></span></button>
      <button id="commentBtn" class="comment-btn">Comment <span id="commentCount"><?= $post['comments_count'] ?></span></button>
     
    </div>

    <div class="comments-section" id="commentsSection">

      <?php
      $commentsQuery = "SELECT c.*, u.firstname, u.lastname, u.avatar FROM comments c
                        JOIN users u ON c.user_id = u.id
                        WHERE c.post_id = $id
                        ORDER BY c.created_at DESC
                        LIMIT 2";
      $commentsResult = mysqli_query($connection, $commentsQuery);

      if ($commentsResult) {
        // Check if there are rows in the result
        if (mysqli_num_rows($commentsResult) > 0) {
          while ($comment = mysqli_fetch_assoc($commentsResult)) {
            include 'partials/comment.php';
          }
        }
      }

      ?>

      <div class="seeall">
        <?php if ($post['comments_count'] > 2) : ?>
          <a href="<?= ROOT_URL ?>all-comments.php?post_id=<?= $post['id']; ?>" class="see-all-btn">See All &rarr;</a>
        <?php endif; ?>
      </div>

      <div class="user-comment-section">
        <?php

        if (isset($_SESSION['user-id'])) {
          $loggedInUserId = $_SESSION['user-id'];
          $loggedInUserQuery = "SELECT * FROM users WHERE id=$loggedInUserId";
          $loggedInUserResult = mysqli_query($connection, $loggedInUserQuery);
          $loggedInUser = mysqli_fetch_assoc($loggedInUserResult);
        ?>


          <form action="<?= ROOT_URL ?>comment-logic.php" method="post" enctype="multipart/form-data " id="commentForm">
            <div class="commentInput">
              <div id="commentAvatar">
                <img src="./images/<?= $loggedInUser['avatar'] ?>" alt="Avatar" />
              </div>
              <input type="hidden" name="postId" value="<?= $post['id'] ?>">
              <textarea id="userComment" name="commentBody" rows="5" placeholder="Write a comment..."></textarea>
            </div>
            <div class="sendCommentBtn">
              <button type="submit" name="submitComment" id="sendCommentBtn" class="btn">Send <i class="uil uil-telegram"></i></button>
            </div>
          </form>
        <?php } else { ?>
          <div class="alert_message error">
            <p>Log in to post a comment.</p>
          </div>
        <?php } ?>
      </div>


    </div>
  </div>
</section>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const postId = <?php echo $post['id']; ?>;

    const commentBtn = document.getElementById('commentBtn');
    const commentsSection = document.getElementById('commentsSection');
    const seeAllBtn = document.getElementById('seeAllBtn');
    const userCommentSection = document.querySelector('.user-comment-section');
    const sendCommentBtn = document.getElementById('sendCommentBtn');

    commentBtn.addEventListener('click', () => {
      commentsSection.classList.toggle('showComment')

    });

    seeAllBtn.addEventListener('click', () => {
      window.location.href = `all_comments.php?post_id=${postId}`;
    });


    sendCommentBtn.addEventListener('click', () => {
      const userCommentInput = document.getElementById('userComment').value;

      // Validate if the comment is not empty
      if (userCommentInput.trim() !== "") {
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'comment_logic.php';

        const postIdInput = document.createElement('input');
        postIdInput.type = 'hidden';
        postIdInput.name = 'postId';
        postIdInput.value = postId;

        const commentBodyInput = document.createElement('input');
        commentBodyInput.type = 'hidden';
        commentBodyInput.name = 'commentBody';
        commentBodyInput.value = userCommentInput;

        const submitBtn = document.createElement('input');
        submitBtn.type = 'submit';
        submitBtn.name = 'submitComment';
        submitBtn.value = 'Submit';

        form.appendChild(postIdInput);
        form.appendChild(commentBodyInput);
        form.appendChild(submitBtn);

        document.body.appendChild(form);
        form.submit();
      } else {
        alert('Please enter a comment before submitting.');
      }
    });
  });

  function likeDislikePost(postId, action) {
    const isLoggedIn = <?php echo isset($_SESSION['user-id']) ? 'true' : 'false'; ?>;
    // Send AJAX request to like or dislike the post
    fetch('like-dislikes-logic.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          postId: postId,
          action: action,
          isLoggedIn: isLoggedIn // Include isLoggedIn in the request
        }),
      })
      .then(response => response.json())
      .then(data => {
        console.log('Response data:', data); // Log the response data
        document.getElementById('likeCount').textContent = data.like_count;
        document.getElementById('dislikeCount').textContent = data.dislike_count;
      })
      .catch(error => console.error(`Error :::${error}`));
  }
</script>
<?php include "partials/footer.php" ?>