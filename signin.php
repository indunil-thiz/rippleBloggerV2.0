<?php

require 'config/constants.php';
// $secondmethod = $_SESSION['signin-data']['username_email'] ? $_SESSION['signin-data']['username_email'] : null;


$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);


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
      <h2>Sign In</h2>
      <?php
      if (isset($_SESSION['signup-success'])) : ?>
        <div class="alert_message success">
          <p><?= $_SESSION['signup-success'];
              unset($_SESSION['signup-success']);

              ?></p>

        </div>
        
      <?php

      elseif (isset($_SESSION['signin'])) : ?>
        <div class="alert_message error">
          <p><?= $_SESSION['signin'];
              unset($_SESSION['signin']); ?>

          </p>

        </div>


      <?php

      elseif (isset($_GET['message']) && $_GET['message'] === 'reset_success') : ?>
        <div class="alert_message success">
          <p>Password update successful!</p>

        </div>


      <?php endif ?>




      <form action="<?= ROOT_URL ?>signin-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="username_email" placeholder="Username or Email" value="<?= $username_email ?>" />

        <input type="password" name="password" placeholder="Password" value="<?= $password ?>" />

        <button type="submit" name="submit" class="btn">Sign In</button>


      </form>
      <small>Don't have an account ? <a href="signup.php">Sign Up</a></small>

      <small> <a href="forgotpassword.php">Forgot Password?</a></small>
    </div>
  </section>
</body>

</html>

<?php
unset($_SESSION['reset']); ?>