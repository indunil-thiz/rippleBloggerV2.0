<?php
include "partials/header.php";

//get back form data if valid
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">

    <?php
    if (isset($_SESSION['add-category'])) : ?>
      <div class="alert_message error container">
        <p><?= $_SESSION['add-category'];
            unset($_SESSION['add-category']);

            ?></p>

      </div>

    <?php endif ?>

    <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="post" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" value="<?= $title ?>" />
      <textarea rows="4" placeholder="Description" name="description" value="<?= $description ?>"></textarea>
      <button type="submit" class="btn" name="submit">Add Category</button>
    </form>
  </div>
</section>


<?php
include "partials/footer.php"
?>