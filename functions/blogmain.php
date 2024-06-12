<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');
include('../common/fetchingall.php'); // Include fetchingall.php to fetch the user's location
$username = $_SESSION['username'];

// Get the selected topic from the URL, if any
$selected_topic = isset($_GET['category']) ? $_GET['category'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogging Website</title>
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
<?php  include('../common/mainpageheader.php'); ?> 
<section class="hero" style="background: linear-gradient(45deg, #ff4e00, #ff00e0, #00eaff, #00ff68); color: #fff; text-align: center; padding: 50px 20px;">
    <h1 style="margin: 0; font-size: 3em;">Welcome to the  Blogging Experience</h1>
    <p style="font-size: 1.2em;">Explore insightful articles, discover new perspectives, and join the conversation.</p>
    <button id="startReadingButton" style="padding: 10px 20px; font-size: 1em; color: #fff; background-color: #333; border: none; border-radius: 5px;">Start Reading</button>

</section>
<div class="container" style="margin-top: 20px; display: flex;">
    <!-- Left Side - Blog Content -->
    <div class="blog-content" style="width: 80%; display: flex; flex-wrap: wrap;">
        <?php
        // SQL query to fetch blog posts based on the selected topic
        $sql = $selected_topic ? "SELECT * FROM blog_posts WHERE category ='$selected_topic'" : "SELECT * FROM blog_posts";

        $result = $conn->query($sql);
        
        if ($result === false) {
            // Output the error message for debugging
            echo "<p>Debug: SQL Error: " . $conn->error . "</p>";
        } elseif ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
        ?>
        <!-- Individual Blog Post -->
        <div class="post" style="background-color: rgba(255, 255, 255, 0.9); border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px; padding: 20px; box-shadow: 0 10px 12px rgba(0, 0, 0, 0.9); transition: transform 0.3s ease; width: 100%; display: flex; justify-content: space-between; align-items: center;">
    <!-- Mains Div on the Left Side -->
    <div class="mains" style="width: 70%; display: flex; flex-direction: column;">
        <h1 style="font-size: 24px; color: #333; margin-bottom: 10px; transition: color 0.3s ease;"><strong>Posted By: <?php echo $row["username"]; ?></strong></h1>
        <h2 style="font-size: 24px; color: #333; margin-bottom: 10px; transition: color 0.3s ease;">Title: <?php echo $row["title"]; ?></h2>
        <p style="color: #666; line-height: 1.6; margin-bottom: 15px;"><?php echo $row["content"]; ?></p>
        <!-- Modify this line to pass the blog_id -->
        <a href="blogdetails.php?blog_id=<?php echo $row['blog_id']; ?>" style="color: #ff6f61; text-decoration: none; transition: color 0.3s ease;">Read More</a>
    </div>
    <!-- Image Div on the Right Side -->
    <div class="image" style="width: 30%; display: flex; justify-content: flex-end; height: 200px; width: 200px;">
        <a href="./homepage.php?image=<?php echo urlencode($row['featured_image']); ?>" style="color: #ff6f61; text-decoration: none; transition: color 0.3s ease;">
            <img src="../Images/<?php echo $row['featured_image']; ?>" alt="Blog Image" style="max-width: 100%; border-radius: 10px; transition: transform 0.3s ease;">
        </a>
    </div>
</div>

        <?php
            }
        } else {
            echo "<p style='color: #333; text-align: center; width: 100%;'>No posts available for this topic.</p>";
        }
        ?>
    </div>
    <!-- Right Side - Blog Topics -->
    <div class="blog-topics" style="width: 20%; padding-left: 20px; text-align: center; align-items: center; margin-left: 40px;">
        <a href="./addnewblog.php" style="font-size: 20px; color: #333; margin-bottom: 20px; text-decoration: none; transition: color 0.3s ease; border: 2px solid #ccc; padding: 10px 20px; border-radius: 5px; display: inline-block; background: linear-gradient(45deg, #f7f7f7, #eaeaea, #f7f7f7); text-align: center; font-family: Arial, sans-serif;">Add New Blog <span style="margin-left: 15px;">+</span></a>
        <div class="boxes">
            <h2 style="font-size: 20px; color: #333; margin-bottom: 20px; text-align: center; align-items: center; text-shadow: 1px 1px 2px #aaa;">Topics</h2>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 10px; padding: 10px; background: #e3f2fd; border: 2px solid #2196f3; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Entertainment" style="color: #1e88e5; text-decoration:
none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Entertainment</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #ffebee; border: 2px solid #f44336; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Study" style="color: #e53935; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Study</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #e8f5e9; border: 2px solid #4caf50; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Motivation" style="color: #43a047; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Motivation</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #fff3e0; border: 2px solid #ff9800; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Funny" style="color: #fb8c00; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Funny</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #f3e5f5; border: 2px solid #9c27b0; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=News" style="color: #8e24aa; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">News</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #e0f2f1; border: 2px solid #009688; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Sports" style="color: #00897b; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Sports</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #f1f8e9; border: 2px solid #8bc34a; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Documentary" style="color: #7cb342; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Documentary</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #ede7f6; border: 2px solid #673ab7; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Music" style="color: #5e35b1; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Music</a>
                </li>
                <li style="margin-bottom: 10px; padding: 10px; background: #fafafa; border: 2px solid #9e9e9e; border-radius: 5px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <a href="?category=Other" style="color: #757575; text-decoration: none; font-weight: bold; display: block; text-shadow: 1px 1px 2px #aaa;">Other</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php  include('../common/featuredblogs.php'); ?>

<script>
    // JavaScript to scroll to the container when "Start Reading" button is clicked
    document.getElementById('startReadingButton').addEventListener('click', function() {
        document.getElementById('blogContentSection').scrollIntoView({ behavior: 'smooth' });
    });

    function toggleOptions() {
    var options = document.getElementById('options');
    if (options.style.display === 'none' || options.style.display === '') {
      options.style.display = 'block';
      options.style.opacity = '1';
    } else {
      options.style.opacity = '0';
      setTimeout(function() {
        options.style.display = 'none';
      }, 500);
    }
  }

</script>
<?php  include('../common/footers.php'); ?>
</body>
</html>
