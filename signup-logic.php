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

  $firstname = ucfirst($firstname);
  $lastname = ucfirst($lastname);
  $username = ucfirst($username);

  //validate input values
  if (!ctype_alpha($firstname)) {
    $_SESSION['signup'] = "First Name should only contain alphabetic characters.";
  } elseif (!ctype_alpha($lastname)) {
    $_SESSION['signup'] = "Last Name should only contain alphabetic characters.";
  } elseif (strlen($firstname) < 3 || strlen($lastname) < 3) {
    $_SESSION['signup'] = "First Name and Last Name should be at least 3 characters long.";
  } elseif (!$username) {
    $_SESSION['signup'] = "Please Enter Your User Name.";
  } elseif (!$email) {
    $_SESSION['signup'] = "Please Enter Your Valid email.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup'] = "Invalid Email Format.";
  } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
    $_SESSION['signup'] = "Password Should be 8+ Characters.";
  } elseif (!$avatar['name']) {
    $_SESSION['signup'] = "Please Add Avatar Image.";
  } else {
    //check if password doesn't match
    if ($createpassword !== $confirmpassword) {
      $_SESSION['signup'] = "Password Does Not Match";
    } else {
      //hash password
      $hash_password = password_hash($createpassword, PASSWORD_DEFAULT);

      //check if username or email already exists in the database
      $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";

      $user_check_result = mysqli_query($connection, $user_check_query);

      if (mysqli_num_rows($user_check_result) > 0) {
        $existing_user = mysqli_fetch_assoc($user_check_result);
        if ($existing_user['email'] == $email) {
          $_SESSION['signup'] = "Email Already Exists. Please use a different email address.";
        } else {
          $_SESSION['signup'] = "Username Already Exists.";
        }
      } else {
        //work on avatar
        //rename avatar
        $time = time(); //make each image name unique
        $avatar_name = $time . $avatar['name'];

        $avatar_tmp = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : '';
        $avatar_destination_path = 'images/' . $avatar_name;

        //make sure the file is an image;
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
          //make sure the image is not too large(1mb)
          if ($avatar['size'] < 2000000) {
            //upload avatar
            move_uploaded_file($avatar_tmp, $avatar_destination_path);
          } else {
            $_SESSION['signup'] = 'File Size Too Big. Should Be Less Than 2mb';
          }
        } else {
          $_SESSION['signup'] = "File Should Be png, jpg, or jpeg.";
        }
      }
    }
  }

  //redirect back to the signup page if there was any problem
  if ($_SESSION['signup']) {
    //pass form data back to the signup page;
    $_SESSION['signup-data'] = $_POST;

    header('location:' . ROOT_URL . 'signup.php');
  } else {
    //insert new user into the user table
    $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname','$lastname','$username','$email','$hash_password','$avatar_name',0)";

    $insert_user_results = mysqli_query($connection, $insert_user_query);

    if (!mysqli_errno($connection)) {
      //redirect to the login page with success message
      $_SESSION['signup-success'] = 'Registration Successful. Please Log in.';
      header('location:' . ROOT_URL . 'signin.php');
      die();
    }
  }
} else {
  // If the button wasn't clicked, bounce back to the signup page
  header('location:' . ROOT_URL . 'signup.php');
}
?>
