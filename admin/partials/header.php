<?php
//give access to the files for interact with database
require "../partials/header.php";

//check login status
if (!isset($_SESSION['user-id'])) {
  header('location:' . ROOT_URL . 'signin.php');
  die();
}
