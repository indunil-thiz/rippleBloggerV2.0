<?php

require 'config/database.php';

// Get signup form data when the signup button is clicked
if (isset($_POST['submit'])) {
  $firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
  $lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
  $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
  $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
  $createpassword = isset($_POST['createpassword']) ? filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
  $confirmpassword = isset($_POST['confirmpassword']) ? filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';

  // Handle file upload
  $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : '';
  //$avatar_tmp = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : '';
  echo $firstname, $lastname, $username, $email, $confirmpassword, $confirmpassword, $avatar;

  //validate input values
  if (!$firstname) {
    $_SESSION['signup'] = "Please Enter your first Name.";
  } elseif (!$lastname) {
    $_SESSION['signup'] = "Please Enter your last Name.";
  } elseif (!$username) {
    $_SESSION['signup'] = "Please Enter your user Name.";
  } elseif (!$email) {
    $_SESSION['signup'] = "Please Enter your valid email.";
  } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
    $_SESSION['signup'] = "Password should be 8+ characters.";
  } elseif (!$avatar['name']) {
    $_SESSION['signup'] = "Please add avatar";
  } else {
    //check if passwaord don't match
    if ($createpassword !== $confirmpassword) {
      $_SESSION['signup'] = "Password does not match";
    } else {
      //hash password
      $hash_password = password_hash($createpassword, PASSWORD_DEFAULT);

      //check if username or email already exits in database
      $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";

      $user_check_result = mysqli_query($connection, $user_check_query);

      if (mysqli_num_rows($user_check_result) > 0) {
        $_SESSION['signup'] = "Username or Email already exist.";
      } else {
        //work on avatar
        //rename avater
        $time = time(); //make each image name unique
        $avatar_name = $time . $avatar['name'];

        $avatar_tmp = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : '';
        $avatar_destination_path = 'images/' . $avatar_name;

        //make sure file is an image;
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
          //make sure image is not too large(1mb)
          if ($avatar['size'] < 1000000) {
            //upload avatar
            move_uploaded_file($avatar_tmp, $avatar_destination_path);
          } else {
            $_SESSION['signup'] = 'File size too big. Should be less than 1mb';
          }
        } else {
          $_SESSION['signup'] = "File Should be png,jpg,jpeg";
        }
      }
    }
  }

  //redirect bakc to  sing up page if there was any problem
  if ($_SESSION['signup']) {
    //pass form data back to signup page;
    $_SESSION['signup-data'] = $_POST;

    header('location:' . ROOT_URL . 'signup.php');
  } else {
    //inser new user into user table
    $insert_user_query = "INSERT INTO users (firstname,lastname,username,email,password,avatar,is_admin) VALUES('$firstname','$lastname','$username','$email','$hash_password','$avatar_name',0)";

    $insert_user_results = mysqli_query($connection, $insert_user_query);


    if (!mysqli_errno($connection)) {
      //redirect to the login page with success message
      $_SESSION['signup-success'] = 'Registration successful. Please log in.';
      header('location:' . ROOT_URL . 'signin.php');
      die();
    }
  }
} else {
  // If the button wasn't clicked, bounce back to the signup page
  header('location:' . ROOT_URL . 'signup.php');
}
