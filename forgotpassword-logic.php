<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/database.php';
$_SESSION['reset'] = $_SESSION['reset'] ?? [];

// Check if 'check_email' form has been submitted
if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        $_SESSION['reset']['error'] = "Email is required.";
    } else {
        $fetch_user_query = "SELECT * FROM users WHERE email = ?";
        
        $stmt = mysqli_prepare($connection, $fetch_user_query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $fetch_user_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            $_SESSION['reset']['email'] = $email;
            $_SESSION['reset']['step'] = 2;
        } else {
            $_SESSION['reset']['error'] = "Email not found in the database.";
        }
    }

    // Redirect after processing the form data
    header('Location: ' . ROOT_URL . 'forgotpassword.php');
    exit();
}

// Handle reset_password logic
if (isset($_POST['reset_password'])) {
    $email = $_SESSION['reset']['email'] ?? null;

    // Debugging: Output the current session for inspection
    // echo "Current Session:<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    // Check if email is set in the session
    if (!$email) {
        $_SESSION['reset']['error'] = "Email not found in the session.";
        header('Location: ' . ROOT_URL . 'forgotpassword.php');
        exit();
    }

    $newPassword = $_POST['createpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    // Check password length
    if (strlen($newPassword) < 8) {
        $_SESSION['reset']['error'] = "Password must contain at least 8 characters.";
        header('Location: ' . ROOT_URL . 'forgotpassword.php');
        exit();
    }

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['reset']['error'] = "Passwords don't match.";
        header('Location: ' . ROOT_URL . 'forgotpassword.php');
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in the database
    $update_password_query = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = mysqli_prepare($connection, $update_password_query);

    // Output the SQL query for debugging
    //echo "SQL Query: $update_password_query<br>";

    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
    $update_password_result = mysqli_stmt_execute($stmt);

    // Output whether the update query was successful or any error
    if ($update_password_result) {
        //echo "Password update successful!";
        unset($_SESSION['reset']['email']); // unset email from the session
        header("Location: " . ROOT_URL . "signin.php?message=reset_success");
        exit();
    } else {
        $_SESSION['reset']['error'] = "Password reset failed.";
        header('Location: ' . ROOT_URL . 'forgotpassword.php');
        exit();
    }
}
