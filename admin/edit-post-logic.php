<?php
require 'config/database.php';

// Check if the edit post button is clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = nl2br(filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // Check and validate input values
    if (!$title || !$category_id || !$body) {
        $_SESSION['edit-post'] = "Couldn't Update Post. Invalid Form Data in Edit Post Page..!";
    } else {
        // Delete existing thumbnail
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            // Work on the new thumbnail
            // Rename the image
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // Make sure the file is an image
            $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

            if (in_array($extension, $allowed_files)) {
                // Make sure the image is not too big (2mb)
                if ($thumbnail['size'] < 2000000) {
                    // Upload the thumbnail
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Couldn't Update Post. Thumbnail Size Too Big. Add a thumbnail less than 2mb";
                }
            } else {
                $_SESSION['edit-post'] = "Couldn't Update Post. Thumbnail Should be PNG, JPG, JPEG, or WEBP File Type";
            }
        }
    }

    if ($_SESSION['edit-post']) {
        // Redirect to manage from page if invalid
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // Set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Set thumbnail name if a new one was uploaded
        $thumbnail_to_insert = isset($thumbnail_name) ? $thumbnail_name : $previous_thumbnail_name;

        // Use prepared statement to prevent SQL injection
        $query = "UPDATE posts SET title=?, body=?, thumbnail=?, category_id=?, is_featured=? WHERE id=? LIMIT 1";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssiii", $title, $body, $thumbnail_to_insert, $category_id, $is_featured, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!mysqli_errno($connection)) {
            $_SESSION['edit-post-success'] = "Post Updated Successfully..!";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
?>
