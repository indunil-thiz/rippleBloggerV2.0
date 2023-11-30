<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Update the category_id to the desired value (e.g., 10) for posts that belong to the deleted category
    $update_query = "UPDATE posts SET category_id = 14 WHERE category_id = $id";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)) {
        // Delete the category
        $query = "DELETE FROM categories WHERE id = $id";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Deleted Category Successfully..!";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
