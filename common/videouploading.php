<?php
include ('databaseconn.php');

$username = $_SESSION['username'] ?? '';

// Initialize total_posts to 0
$total_post = 0;

if (!empty($username)) {
    // SQL query to count total number of posts for the specific username
    $sql = "SELECT COUNT(videos_id) AS total_post FROM videos WHERE username = '$username' AND category ='videos'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_post = $row['total_post'];
    } else {
        // Handle error if the query fails
        echo "Error: " . mysqli_error($conn);
    }
}

?>