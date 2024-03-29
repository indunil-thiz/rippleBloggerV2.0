<?php
include "partials/header.php";
//fetch categories from databse;
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// get back form data
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-post-data']);
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">
    <h2>Add Post</h2>
    <?php if (isset($_SESSION['add-post'])) : ?>

      <div class="alert__message error">
        <p>
          <?= $_SESSION['add-post'];
          unset($_SESSION['add-post']);
          ?>
        </p>
      </div>


    <?php endif ?>

    <form action="<?= ROOT_URL ?>admin/add-post-logic.php" method="post" enctype="multipart/form-data" class="feed">
      <input type="text" name="title" placeholder="Title" value="<?= $title ?>" />
      <select name="category">

        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile ?>
      </select>

  
<textarea rows="10" placeholder="Body" name="body"><?= htmlspecialchars_decode($body) ?></textarea>


      <?php if (isset($_SESSION['user_is_admin'])) : ?>
        <div class="form_control inline">
          <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
          <label for="is_featured">Featured</label>
        </div>
      <?php endif ?>
      <div class="form_control">
        <label for="thumbnail">Add Thumbnail</label>
        <input type="file" id="thumbnail" name="thumbnail">
      </div>
      <button type="submit" class="btn" name="submit">Add Post</button>
    </form>
  </div>
</section>

<?php
include "partials/footer.php"
?>