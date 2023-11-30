<?php
require 'constants.php';

// connect to databse

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3309);

if (mysqli_errno($connection)) {
    die(mysqli_error($connection));
}
