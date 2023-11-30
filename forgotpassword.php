<?php
require 'config/constants.php';

$email = $_SESSION['reset']['email'] ?? null;
$step = $_SESSION['reset']['step'] ?? 1;



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
            <h2>Reset Password</h2>
            <?php


            if (!empty($_SESSION['reset']['error'])) : ?>
                <div class="alert_message error">
                    <p><?= $_SESSION['reset']['error']; ?></p>
                </div>
            <?php endif ?>

            <form action="<?= ROOT_URL ?>forgotpassword-logic.php" method="post" enctype="multipart/form-data">
                <?php if ($step === 1) : ?>
                    <input type="email" name="email" placeholder="Email" value="<?= $email ?>" />
                    <button type="submit" name="submit" class="btn">Check</button>
                <?php elseif ($step === 2) : ?>
                    <input type="email" name="email" value="<?= $email ?>" />
                    <input type="password" name="createpassword" placeholder="Create Password" required />
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" required />
                    <button type="submit" name="reset_password" class="btn">Reset</button>
                <?php endif ?>
                <small>Remember Password? <a href="<?= ROOT_URL ?>signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
</body>

</html>

<?php

//unset($_SESSION['reset']);
?>