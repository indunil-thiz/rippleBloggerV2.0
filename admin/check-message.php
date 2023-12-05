<?php
include "partials/header.php";

//fetch users from database but not current user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM contact_messages";
$messagesResult = mysqli_query($connection, $query);
?>
<!-- END OF NAVBAR -->

<section class="dashboard">
   
    <div class="container dashboard_container">
        <button id="show_sidebar" class="sidebar_toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide_sidebar" class="sidebar_toggle"><i class="uil uil-angle-left-b"></i></button>

        <aside>
            <ul>
                <li><a href="<?= ROOT_URL ?>admin/add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a></li>
                <li><a href="<?= ROOT_URL ?>admin/index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5>
                    </a></li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li><a href="<?= ROOT_URL ?>admin/all-post.php"><i class="uil uil-user-plus"></i>
                            <h5>Manage All Post</h5>
                        </a></li>
                    <li><a href="<?= ROOT_URL ?>admin/add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a></li>
                    <li><a href="<?= ROOT_URL ?>admin/manage-users.php" ><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a></li>
                    <li><a href="<?= ROOT_URL ?>admin/add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a></li>
                    <li><a href="<?= ROOT_URL ?>admin/manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Category</h5>
                        </a></li>
<li><a href="<?= ROOT_URL ?>admin/check-message.php" class="active"><i class="uil uil-whatsapp"></i>
                            <h5>Messages</h5>
                        </a></li>
                <?php endif ?>
            </ul>
        </aside>
<main>
            <h2>Contact Messages</h2>
            
            <?php if (mysqli_num_rows($messagesResult) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($message = mysqli_fetch_assoc($messagesResult)) : ?>
                            <tr>
                                <td><?= $message['name'] ?></td>
                                <td><?= $message['email'] ?></td>
                                <td><?= $message['message'] ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error">
                    <?= 'No messages found' ?>
                </div>
            <?php endif  ?>
        </main>

    </div>
</section>

<?php
include "partials/footer.php"
?>