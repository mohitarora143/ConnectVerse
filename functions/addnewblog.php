<?php
session_start();
$servername = "localhost";
$dbname = "project";
$dbusername = "root";
$dbpassword = "";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $status = $_POST['status'];
   $featuredimage=$_POST['featured_image'];
    // Check if the combination of email, username, title, and category already exists
    $check_query = "SELECT * FROM blog_posts WHERE email = '$email' AND username = '$username' AND title = '$title' AND category = '$category' AND featured_image='$featuredimage'";
    $result = $conn->query($check_query);

    if ($result && $result->num_rows > 0) {
        echo "Error: Entry with the same email, username, title, and category already exists.";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO blog_posts (title,featured_image, content, category, author, username, email, status) VALUES (?, ? , ?, ?, ?, ?, ?, ?)";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssssssss", $title,$featuredimage, $content, $category, $author, $username, $email, $status);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to a success page or display a success message
                echo "<h1>Blog Entered Sucessfully</h1>";
                header("Location: ./blogmain.php");
                exit();
            } else {
                // Handle the error
                echo "Error: " . $stmt->error;
            }
        } else {
            // Handle the error
            echo "Error: " . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Blog Post</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  background: linear-gradient(45deg, #f8f9fa, #dee2e6, #ced4da, #adb5bd); color: #333;">

<div style="max-width: 600px; margin: 50px auto; padding: 20px; background-color: rgba(255, 255, 255, 0.9); border-radius: 20px; box-shadow: 0 12px 20px rgba(0, 0, 0, 0.7);">

<h2 style="font-size: 34px; text-align: center; color: #333; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); transition: font-size 0.3s, color 0.3s, text-shadow 0.3s;">Create New Blog Post</h2>

    <form action="./addnewblog.php" method="POST" style="display: flex; flex-direction: column;">
        <label for="title" style="color: #333; margin-bottom: 10px;">Title</label>
        <input type="text" id="title" name="title" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;" required>

        <label for="content" style="color: #333; margin-bottom: 10px;">Content</label>
        <textarea id="content" name="content" rows="6" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;"required></textarea>

        <label for="category" style="color: #333; margin-bottom: 10px;">Category/Tags</label>
        <select id="category" name="category" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;" required>
                                <option value="">Select a type</option>
                                <option value="entertainment">Entertainment</option>
                                <option value="study">Study</option>
                                <option value="motivation">Motivation</option>
                                <option value="funny">Funny</option>
                                <option value="news">News</option>
                                <option value="sports">Sports</option>
                                <option value="documentary">Documentary</option>
                                <option value="music">Music</option>
                                <option value="other">Other</option>
                            </select>  

        <label for="featured_image" style="color: #333; margin-bottom: 10px;">Featured Image</label>
        <input type="file" id="featured_image" name="featured_image" accept="image/*" style="margin-bottom: 20px; transition: border-color 0.3s;"required>

        <label for="author" style="color: #333; margin-bottom: 10px;">Author</label>
        <input type="text" id="author" name="author" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;"required>

        <label for="publish-date" style="color: #333; margin-bottom: 10px;">Publish Date</label>
        <input type="datetime-local" id="publish-date" name="publish-date" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;" required>

<label for="status" style="color: #333; margin-bottom: 10px;">Status</label>
<select id="status" name="status" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; transition: border-color 0.3s;" required>
    <option value="draft">Draft</option>
    <option value="published">Published</option>
    <option value="scheduled">Scheduled</option>
</select>
<button type="submit" style="padding: 10px 20px; background-color: #009688; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Publish</button>
<button type="button" onclick="resetForm()" style="padding: 10px 20px; background-color: #ff5722; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; transition: background-color 0.3s;">Cancel</button>
<button type="button" onclick="goBack()" style="padding: 10px 20px; background-color: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; transition: background-color 0.3s;">Close</button>
    </form>

</div>

<script>
    // Function to go back to the previous page
    function goBack() {
        window.history.back();
    }

    // Function to reset the form fields
    function resetForm() {
        // Get all form elements
        var formElements = document.getElementsByTagName("input");
        var textareas = document.getElementsByTagName("textarea");
        var selects = document.getElementsByTagName("select");

        // Reset input fields
        for (var i = 0; i < formElements.length; i++) {
            if (formElements[i].type !== "submit" && formElements[i].type !== "reset") {
                formElements[i].value = "";
            }
        }

        // Reset textareas
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].value = "";
        }

        // Reset select fields
        for (var i = 0; i < selects.length; i++) {
            selects[i].selectedIndex = 0;
        }
    }
</script>

</body>
</html>
