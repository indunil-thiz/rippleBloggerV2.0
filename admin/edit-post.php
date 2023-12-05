<?php
include 'partials/header.php';

// fetch the category form db
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);


// fetch post data from db

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";

  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . '/admin');
  die();
}
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">
    <h2>Edit Post</h2>

    <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $post['id'] ?>">
      <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">

      <input type="text" name="title" placeholder="Title" value="<?= $post['title'] ?>">
      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile ?>

      </select>
      <textarea rows="10" placeholder="Body" name="body"><?= htmlspecialchars_decode(str_replace('<br />', PHP_EOL, $post['body'])) ?></textarea>

         <?php if (isset($_SESSION['user_is_admin'])) : ?>
      <div class="form__control inline">
        <input type="checkbox" name="is_featured" id="is_feactured" value="1" checked>
        <label for="is_feactured">Featured</label>
      </div>
        <?php endif ?>
      <div class="form_control">
        <label for="thumbnail">Change Thumbnail</label>
        <input type="file" id="thumbnail" name="thumbnail">
      </div>
      <button type="submit" name="submit" class="btn">Update Post</button>
    </form>
  </div>
</section>


<?php
include "partials/footer.php"
?>