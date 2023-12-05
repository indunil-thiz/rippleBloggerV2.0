<?php
include "partials/header.php";

// get back form data
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
$userrole = $_SESSION['add-user-data']['userrole'] ?? null;

// delete session data
unset($_SESSION['add-user-data']);
?>
<!-- END OF NAVBAR -->
<section class="form_section">
  <div class="container form_section_container">
    <h2>Add User</h2>
    <?php if (isset($_SESSION['add-user'])) : ?>
      <div class="alert_message error">
        <p><?= $_SESSION['add-user'];
            unset($_SESSION['add-user']);
            ?></p>
      </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="post" enctype="multipart/form-data">
      <input type="text" name="firstname" placeholder="First Name" value="<?= $firstname ?>" />
      <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname ?>" />
      <input type="text" name="username" placeholder="Username" value="<?= $username ?>" />
      <input type="email" name="email" placeholder="Email" value="<?= $email ?>" />

      <input type="password" name="createpassword" placeholder="Create Password" value="<?= $createpassword ?>" />
      <input type="password" name="confirmpassword" placeholder="Confirm Password" value="<?= $confirmpassword ?>" />

      <select name="userrole">
        <option value="0">Author</option>
        <option value="1">Admin</option>
      </select>

      <div class="form_control">
        <label for="avatar">User Avatar</label>
        <input type="file" name="avatar" id="avatar">
      </div>

      <button type="submit" class="btn" name="submit">Add User</button>

    </form>
  </div>
</section>


<?php
include "partials/footer.php";
?>