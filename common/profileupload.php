<?php


// Include database connection
include('../common/databaseconn.php');

// Retrieve username from session
$username = $_SESSION['username'];

// Check if username is set
if (!isset($username)) {
    die("Username not found in session.");
}

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

// Bind parameters and execute query
$stmt->bind_param("s", $username);
if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

// Bind result variable
$stmt->bind_result($imagePath);

// Fetch result
$stmt->fetch();

// Close statement
$stmt->close();
?>
