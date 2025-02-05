<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or homepage
header("Location: index.php?action=login");
exit();
?>
