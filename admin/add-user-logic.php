<?php
require 'config/database.php';

// get form data if signup button was clicked


if (isset($_POST['submit'])) {

    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    $avatar = $_FILES['avatar'];

    // echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;
    // var_dump($avatar);

    // validate inputs
    if (!$firstname) {
        $_SESSION['add-user'] = "Please Enter Your First Name";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please Enter Your Last Name";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please Enter Your UserName";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please Enter Your Valid Email Address";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Password Should be 8 Characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please Select Your Avatar Image";
    } else {
        // check if password do not match

        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Password Do Not Match. Try Again ..!!";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword,  PASSWORD_DEFAULT);
            // echo $createpassword . '<br/>';
            // echo $hashed_password;

            // check if username or email already existing in the database

            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already Exists";
            } else {
                // work on avatar
                // rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);

                if (in_array($extention, $allowed_files)) {
                    // make sure image is not too large (1mb+)
                    if ($avatar['size'] < 2000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "File Size Too Big. Chose Less Than 2mb File..!";
                    }
                } else {
                    $_SESSION['add-user'] = "File Should Be PNG, JPG, JPEG or WEBP";
                }
            }
        }
    }


    // check redirect back to add-user page, there was an error
    if (isset($_SESSION['add-user'])) {
        // pass form data back to sign up page  
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            // success message
            $_SESSION['add-user-success'] = "New User $firstname $lastname Added Successful..!";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }



    // var_dump($avatar);
    // echo time();
} else {
    // if button was not clicked, back to signup page

    header(('location: ' . ROOT_URL . 'admin/add-user.php'));
    die();
}
