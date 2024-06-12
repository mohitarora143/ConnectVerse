<?php
session_start();
include('../common/databaseconn.php');

// Check if the image information is passed through the URL
if(isset($_GET['featured_image'])) {
    // Sanitize the input
    $image = mysqli_real_escape_string($conn, $_GET['featured_image']);

    // Retrieve the blog post details based on the image
    $sql = "SELECT * FROM blog_posts WHERE featured_image = '$image'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Blog post details
        $username = $row['username'];
        $title = $row['title'];
        $content = $row['content'];
        $date_published = $row['date_published'];

        // You can include additional details here if needed
    } else {
        // Handle case when no blog post is found
        echo "Blog post not found!";
    }
} else {
    // Redirect to homepage or handle case when image information is not passed
    header("Location: homepage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Blog Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}
</style>
<body>
<!-- Navbar -->
<?php include('../common/mainpageheader.php'); ?> 

<div class="container" style="margin-top: 20px;">
    <div class="blog-post">
        <h1><?php echo $title; ?></h1>
        <p><strong>Posted By:</strong> <?php echo $username; ?></p>
        <p><strong>Date Published:</strong> <?php echo $date_published; ?></p>
        <div class="content">
            <?php echo $content; ?>
        </div>
        <a href="homepage.php" class="btn btn-primary">Back to Homepage</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
