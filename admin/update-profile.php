<?php
include "partials/header.php";

// Initialize variables to avoid undefined variable warnings
$firstname = $lastname = $username = $email = $currentAvatar = '';

// Assuming you have the user ID stored in a session variable
$userID =$_SESSION['user-id'] ?? null;

// Check if user ID is available
if ($userID) {
    // Fetch user data from the database
    $getUserQuery = "SELECT * FROM users WHERE id = $userID";
    $getUserResult = mysqli_query($connection, $getUserQuery);

    // Check if the query was successful
    if ($getUserResult) {
        // Check if user data is available
        if (mysqli_num_rows($getUserResult) > 0) {
            $currentUser = mysqli_fetch_assoc($getUserResult);

            $firstname = $currentUser['firstname'];
            $lastname = $currentUser['lastname'];
            $username = $currentUser['username'];
            $email = $currentUser['email'];
            $currentAvatar = $currentUser['avatar'];
        } else {
            echo "User data not found in the database for ID: $userID";
        }
    } else {
        echo "Error fetching user data from the database. Error: " . mysqli_error($connection);
    }
} else {
    echo "User ID not found in session";
}
?>

<!-- Rest of your HTML code -->

<section class="form_section">
    <div class="container form_section_container">
        <h2>Update Profile</h2>

        <?php
        // Display session messages
        if (isset($_SESSION['update-profile'])) {
            echo '<div class="alert_message error">' . $_SESSION['update-profile'] . '</div>';
            unset($_SESSION['update-profile']);
        }elseif(isset( $_SESSION['update-profile-success'])){
           echo '<div class="alert_message success">' . $_SESSION['update-profile-success'] . '</div>';
            unset($_SESSION['update-profile-success']); 
        }
        ?>

        <form action="<?= ROOT_URL ?>admin/update-profile-logic.php" method="post" enctype="multipart/form-data">
            <input type="text" name="firstname" placeholder="First Name" value="<?= $firstname ?>" required />
            <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname ?>" required />
            <input type="text" name="username" placeholder="Username" value="<?= $username ?>" required />
            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" required />

            <!-- Display current avatar -->
            <?php if (!empty($currentAvatar)) : ?>
                <img src="<?= ROOT_URL ?>images/<?= $currentAvatar ?>" alt="Current Avatar" style="max-width: 100px; max-height: 100px;">
            <?php endif; ?>

            <!-- Avatar field -->
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>

            <button type="submit" class="btn" name="submit">Update Profile</button>
        </form>
    </div>
</section>

<?php
include "partials/footer.php";
?>
