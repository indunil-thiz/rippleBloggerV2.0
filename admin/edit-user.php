<?php
include "partials/header.php";

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM users WHERE id=$id";
  $result = mysqli_query($connection, $query);

  // Fetch user data as an associative array
  $user = mysqli_fetch_assoc($result);

  if (!$user) {
    // Handle the case where the user with the given ID is not found
    header('location:' . ROOT_URL . 'admin/manage-users.php');
    die();
  }
} else {
  header('location:' . ROOT_URL . 'admin/manage-users.php');
  die();
}
?>
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">
    <h2>Edit User</h2>

    <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="post" enctype="multipart/form-data">
      <input type="text" name="firstname" placeholder="First Name" value="<?= $user['firstname'] ?>" />
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <input type="text" name="lastname" placeholder="Last Name" value="<?= $user['lastname'] ?>" />
      <select name="userrole">
        <option value="0">Author</option>
        <option value="1">Admin</option>
      </select>

      <button type="submit" name="submit" class="btn">Update User</button>

    </form>
  </div>
</section>
<?php
include "partials/footer.php"
?>