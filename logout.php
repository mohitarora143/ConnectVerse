<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other page after logout
header("Location: ./login.php");
exit; // Make sure to exit after redirecting
?>
