<?php
session_start();
include '../common/databaseconn.php'; // Include the database connection
include '../common/profileupload.php'; // Include the profile upload script if needed
include '../common/postscounting.php';
include '../common/videouploading.php';
include('../common/follows.php');
include('../common/fetchingall.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnectVerse - Main Page</title>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes hoverEffect {
        0% { box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        100% { box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3); }
    }

    .animated {
        animation: fadeIn 1s ease-in-out;
    }

    .hover-effect:hover {
        animation: hoverEffect 0.3s forwards;
    }
</style>
<body>
<?php
if (!isset($_SESSION['username'])) {
    // Redirect to login page after 3 seconds
    echo '<script>setTimeout(function() { window.location.href = "../login.php"; }, 3000);</script>';
}
?>
<?php include '../common/topnavbar.php'; ?>
<?php include('../common/dashboardbox.php'); ?>
<?php include '../common/footer.php'; ?>
<script src="../js/click.js"></script>
</body>
</html>
