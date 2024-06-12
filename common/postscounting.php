<?php
include ('databaseconn.php');

$username = $_SESSION['username'] ?? '';

// Initialize total_posts to 0
$total_posts = 0;

if (!empty($username)) {
    // SQL query to count total number of posts for the specific username
    $sql = "SELECT COUNT(post_id) AS total_posts FROM post WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_posts = $row['total_posts'];
    } else {
        // Handle error if the query fails
        echo "Error: " . mysqli_error($conn);
    }
}

?>