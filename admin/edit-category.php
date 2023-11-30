<?php
include "partials/header.php";
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  //fetch catgeory from database
  $query = "SELECT * FROM categories WHERE id=$id";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    $category = mysqli_fetch_assoc($result);
  }
} else {
  header('location:' . ROOT_URL . 'admin/manage-categories.php');
  die();
}
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">
    <h2>Edit Category</h2>

    <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="post" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" value="<?= $category['title'] ?>" />
      <input type="hidden" name="id" value="<?= $category['id'] ?>" />
      <textarea rows="4" name="description" placeholder="Description"><?= $category['description'] ?></textarea>
      <button type="submit" class="btn" name="submit">Update Category</button>
    </form>

  </div>
</section>


<?php
include "partials/footer.php";
?>