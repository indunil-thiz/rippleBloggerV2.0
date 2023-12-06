<?php
require 'config/database.php';

// Assuming you have the user ID stored in a session variable
$userID = $_SESSION['user-id'] ?? null;

// Check if user ID is available
if ($userID) {
    if (isset($_POST['submit'])) {
        // Sanitize and validate form data
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        // Validate first name and last name
        if (!ctype_alpha($firstname)) {
            $_SESSION['update-profile'] = "First Name should only contain alphabetic characters.";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        } elseif (!ctype_alpha($lastname)) {
            $_SESSION['update-profile'] = "Last Name should only contain alphabetic characters.";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        }

        // Check minimum length for first name and last name
        if (strlen($firstname) < 3 || strlen($lastname) < 3) {
            $_SESSION['update-profile'] = "First Name and Last Name should be at least 3 characters long.";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        }

        // Check if any of the required fields are empty
        if (empty($firstname) || empty($lastname) || empty($username) || empty($email)) {
            $_SESSION['update-profile'] = "All fields are compulsory";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        }

        // Fetch the current email and username from the database
        $getCurrentDataQuery = "SELECT email, username FROM users WHERE id = $userID";
        $getCurrentDataResult = mysqli_query($connection, $getCurrentDataQuery);

        if ($getCurrentDataResult && mysqli_num_rows($getCurrentDataResult) > 0) {
            $currentData = mysqli_fetch_assoc($getCurrentDataResult);
            $currentEmail = $currentData['email'];
            $currentUsername = $currentData['username'];

            // Check if the email is changed and already exists
            if ($email !== $currentEmail) {
                $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
                $checkEmailResult = mysqli_query($connection, $checkEmailQuery);

                if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
                    $_SESSION['update-profile'] = "Email already exists. Choose a different one.";
                    header('location: ' . ROOT_URL . 'admin/update-profile.php');
                    die();
                }
            }

            // Check if the username is changed and already exists
            if ($username !== $currentUsername) {
                $checkUsernameQuery = "SELECT * FROM users WHERE username='$username'";
                $checkUsernameResult = mysqli_query($connection, $checkUsernameQuery);

                if ($checkUsernameResult && mysqli_num_rows($checkUsernameResult) > 0) {
                    $_SESSION['update-profile'] = "Username already exists. Choose a different one.";
                    header('location: ' . ROOT_URL . 'admin/update-profile.php');
                    die();
                }
            }
        }

        // Fetch the current avatar path from the database
        $getAvatarQuery = "SELECT avatar FROM users WHERE id = $userID";
        $getAvatarResult = mysqli_query($connection, $getAvatarQuery);

        if ($getAvatarResult && mysqli_num_rows($getAvatarResult) > 0) {
            $currentAvatar = mysqli_fetch_assoc($getAvatarResult)['avatar'];

            // Delete the old avatar if a new one is provided
            if (!empty($_FILES['avatar']['name'])) {
                if (!empty($currentAvatar) && file_exists('../images/' . $currentAvatar)) {
                    unlink('../images/' . $currentAvatar);
                }
            }
        }

        // Update user data in the database
        $update_user_query = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email' WHERE id = $userID";
        $update_user_result = mysqli_query($connection, $update_user_query);

        if ($update_user_result) {
            // Update avatar if a new one is provided
            if (!empty($_FILES['avatar']['name'])) {
                // Handle avatar upload similar to the add-user-logic.php file
                $avatar = $_FILES['avatar'];
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // Validate and move uploaded avatar
                if (move_uploaded_file($avatar_tmp_name, $avatar_destination_path)) {
                    // Update the avatar path in the database
                    $update_avatar_query = "UPDATE users SET avatar='$avatar_name' WHERE id = $userID";
                    $update_avatar_result = mysqli_query($connection, $update_avatar_query);

                    if (!$update_avatar_result) {
                        // Handle the case where updating the avatar path fails
                        $_SESSION['update-profile'] = "Error updating the avatar path in the database";
                        header('location: ' . ROOT_URL . 'admin/update-profile.php');
                        die();
                    }
                } else {
                    // Handle the case where moving the uploaded avatar fails
                    $_SESSION['update-profile'] = "Error moving the uploaded avatar";
                    header('location: ' . ROOT_URL . 'admin/update-profile.php');
                    die();
                }
            }

            // Success message
            $_SESSION['update-profile-success'] = "Profile updated successfully";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        } else {
            // Handle the case where the query to update user data fails
            $_SESSION['update-profile'] = "Error updating user data";
            header('location: ' . ROOT_URL . 'admin/update-profile.php');
            die();
        }
    } else {
        // If the submit button was not clicked, redirect back to the update-profile page
        header('location: ' . ROOT_URL . 'admin/update-profile.php');
        die();
    }
} else {
    // Handle the case where user ID is not available
    $_SESSION['update-profile'] = "User ID not found";
    header('location: ' . ROOT_URL . 'admin/update-profile.php');
    die();
}
?>
