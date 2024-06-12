<?php
if (!empty($username)) {
    // SQL query to fetch all posts for users other than the specified username
    $sql = "SELECT `username`, `description`, `image`, `post_title` FROM `post` WHERE username != ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            // Fetch posts and display them
            while ($row = mysqli_fetch_assoc($result)) {
                $username = $row['username'];
                $post = $row['image'];
                $description = $row['description'];
                $post_title = $row['post_title'];
                
                // Display the details of the post
                echo "<div>";
                echo "<p>Username: $username</p>";
                echo "<img src='$post' alt='Post Image'>";
                echo "<h3>$post_title</h3>";
                echo "<p>$description</p>";
                echo "</div>";
            }
        } else {
            // Handle error if the query fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle statement preparation error
        echo "Error: Unable to prepare statement.";
    }
}
?>
