<!-- partials/comment.php -->
<div class="comment">
    <div class="post_author">
        <div class="post_author_avatar">
            <img src="<?= ROOT_URL ?>/images/<?= $comment['avatar'] ?>" alt="" />
        </div>

        <div class="post_author_info">
            <h5>By: <?= "{$comment['firstname']} {$comment['lastname']}" ?></h5>
            <small><?= date("M d, Y - H:i", strtotime($comment['created_at'])) ?></small>
        </div>
    </div>
    <p class="post_body comment_body"><?= $comment['body'] ?></p>

    <?php if ($comment['user_id'] == $_SESSION['user-id']) : ?>
        <div class="commented-btn-container">
            <!-- Button to trigger edit -->
            <button class="edit-comment-btn" data-comment-id="<?= $comment['id'] ?>">Edit</button>


            <!-- Button to trigger delete -->
            <form method="post" action="<?= ROOT_URL ?>comment-logic.php" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                <input type="hidden" name="commentId" value="<?= $comment['id'] ?>">

                <button class="delete-comment-btn custom-width" type="submit" name="deleteComment">Delete</button>
            </form>
        </div>



    <?php endif; ?>

    <!-- Edit Comment Modal -->
    <div class="modal edit-comment-modal" data-comment-id="<?= $comment['id'] ?>">
        <div class="modal-content" id="modal-content">
            <span class="close">&times;</span>
            <textarea class="editCommentTextarea" rows="6" placeholder="Edit your comment..."><?= htmlspecialchars($comment['body']) ?></textarea>
            <div class="move-right">

                <button class="updateCommentBtn">Update Comment</button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-comment');
        const editButtons = document.querySelectorAll('.edit-comment-btn');
        const modal = document.getElementById('editCommentModal');
        const modalCloseBtn = document.getElementById('closeModalBtn');
        const updateCommentBtn = document.getElementById('updateCommentBtn');
        const commentTextarea = document.getElementById('editCommentTextarea');

        // Function to handle comment deletion
        const deleteComment = (commentId) => {
            const confirmDelete = confirm('Are you sure you want to delete this comment?');

            if (confirmDelete) {
                // Prevent default form submission
                event.preventDefault();

                // Send AJAX request to delete comment
                fetch('comment-logic.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'deleteComment': true,
                            'commentId': commentId,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Update UI or handle the response as needed
                        // Here, you might want to remove the deleted comment from the DOM
                        const deletedComment = document.querySelector(`.comment[data-comment-id="${commentId}"]`);
                        if (deletedComment) {
                            deletedComment.remove();
                        }

                        // Close the modal if it is open
                        modal.style.display = 'none';
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        };

        // Attach event listeners
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const commentId = this.getAttribute('data-comment-id');
                deleteComment(commentId);
            });
        });


        const modals = document.querySelectorAll('.edit-comment-modal');
        const closeBtns = document.querySelectorAll('.modal .close');
        const updateButtons = document.querySelectorAll('.updateCommentBtn');

        editButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                const modal = modals[index];
                modal.style.display = 'block';
            });
        });

        closeBtns.forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.style.display = 'none';
            });
        });

        updateButtons.forEach(updateBtn => {
            updateBtn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                const commentId = modal.dataset.commentId;
                const newCommentBody = modal.querySelector('.editCommentTextarea').value.trim();

                if (newCommentBody !== "") {
                    // Send AJAX request to update comment
                    fetch('comment-logic.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            editComment: true,
                            commentId: commentId,
                            newCommentBody: newCommentBody,
                        }),
                    }).then(response => {
                        // Reload the page or update the comment section as needed
                        location.reload();
                    });
                }
            });
        });
    });
</script>