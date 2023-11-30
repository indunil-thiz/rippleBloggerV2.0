<?php
//give access to the files for interact with database
require "config/database.php";

//fetch current user form database
if (isset($_SESSION['user-id'])) {
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $query = "SELECT avatar FROM users WHERE id ='$id'";
  $result = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="<?= ROOT_URL ?>favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="<?= ROOT_URL ?>favicon.png" type="image/x-icon">
  <title>RippleBlogger✍️</title>

  <!-- Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Link Style Sheet -->
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
  <!-- Js -->
  <script defer src="<?= ROOT_URL ?>js/main.js"></script>
</head>

<body>
  <nav>
    <div class="container nav_container">
      <a href="<?= ROOT_URL ?>index.php" class="nav_logo">RippleBlogger✍️</a>

      <ul class="nav_items">
        <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
        <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
        <!-- <li><a href="<?= ROOT_URL ?>services.php">Services</a></li> -->
        <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <li class="nav_profile">
            <div class="avatar">
              <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="nav-bar-profile-images" />
            </div>
            <ul>
              <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
              <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
        <?php endif ?>
      </ul>
      <button id="open_nav_btn"><i class="uil uil-bars"></i></button>
      <button id="close_nav_btn"><i class="uil uil-multiply"></i></button>
    </div>
  </nav>