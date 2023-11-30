<?php
require 'config/database.php';




if (isset($_POST['submit'])) {
    //get form data
    $username_email = isset($_POST['username_email']) ? filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';

    $password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';

    if (!$username_email) {
        $_SESSION['signin'] = "Username or Email required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password Required";
    } else {

        //fetch user form database
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email ='$username_email'";

        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            //connect the record into assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);

            $db_password = $user_record['password'];

            //compare form password with database password
            if (password_verify($password, $db_password)) {
                //set seeion for access
                $_SESSION['user-id'] = $user_record['id'];

                //set session
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                //log user in
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Please check your inputs";
            }
        } else {
            $_SESSION['signin'] = "User not found!";
        }
    }
    //if any problem, redirect  back to signing page with login data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location:' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}
