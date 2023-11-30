<?php

require 'config/constants.php';

//get back form data if there was an error;
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

//delete signup data session
unset($_SESSION['signup-data'])
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>
  <!-- Link Style Sheet -->
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
  <!-- Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

<body>
  <section class="form_section">
    <div class="container form_section_container">
      <h2>Sign Up</h2>
      <?php
      if (isset($_SESSION['signup'])) : ?>
        <div class="alert_message error">
          <p><?= $_SESSION['signup'];
              unset($_SESSION['signup']);

              ?></p>

        </div>


      <?php endif ?>

      <form action="<?= ROOT_URL ?>signup-logic.php" method="post" enctype="multipart/form-data">
        <input type="text" name="firstname" placeholder="First Name" value="<?= $firstname ?>" />
        <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname ?>" />
        <input type="text" name="username" placeholder="Username" value="<?= $username ?>" />
        <input type="email" name="email" placeholder="Email" value="<?= $email ?>" />
        <input type="password" name="createpassword" placeholder="Create Password" value="<?= $createpassword ?>" />
        <input type="password" name="confirmpassword" placeholder="Confirm Password" value="<?= $confirmpassword ?>" />
        <div class="form_control">
          <label for="avatar"></label>
          <input type="file" name="avatar" id="avatar" />
        </div>
        <button type="submit" name="submit" class="btn">Sign Up</button>
        <small>Already have an account ? <a href="<?= ROOT_URL ?>signin.php">Sign In</a></small>
      </form>

    </div>
  </section>
</body>

</html>