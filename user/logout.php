<?php
session_start();
// Log out the user
unset($_SESSION['users_email']);
session_destroy();

// Redirect the user to the login page
echo "<script>window.location.href='../index.php';</script>";
?>
