<?php
session_start();
include('../common/databaseconn.php'); // Include the database connection

// Retrieve username and email from session
$username = $_SESSION['username'];
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $video = $_FILES['video'];

    // Validate video file
    $targetDir = "../videos/";
    $targetFile = $targetDir . basename($video["name"]);
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allow certain file formats
    $allowedTypes = ["mp4", "avi", "mov", "wmv"];
    if (!in_array($videoFileType, $allowedTypes)) {
        die("Sorry, only MP4, AVI, MOV, & WMV files are allowed.");
    }

    // Check file size (limit to 50MB)
    if ($video["size"] > 50000000) {
        die("Sorry, your file is too large.");
    }

    // Move file to target directory
    if (move_uploaded_file($video["tmp_name"], $targetFile)) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO videos (username,filename, filepath, post_title, description, category, type) VALUES (?,?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss",$username, $video["name"], $targetFile, $post_title, $description, $category, $type);

        // Execute statement
        if ($stmt->execute()) {
            echo "The file " . basename($video["name"]) . " has been uploaded and stored in the database.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Close connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="../css/new.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="user-dp" id="images1" style="align-items: center; text-align:center; justify-content:center">
                <?php  include('../common/profileupload.php'); ?>
                <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture">
            </div>

            <ul>
                <li>
                <div class="form-group">
                        <input type="text" id="username" style="text-align: center;" name="username" placeholder="<?php echo $username; ?>" readonly>
                    </div>
                </li>
                <li><a href="./addpost.php">Upload Photo</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </div>
        <div class="form-container">
        <div class="close-btn-container" style="display: flex; justify-content:flex-end">
                <button id="closeBtn">&times;</button> 
            </div>
            <h2>Add A New Post Video</h2>
            <form id="postForm" action="addvideos.php" method="post" enctype="multipart/form-data">
                
                <div class="form-slide active">
                <div class="form-group">
                <label for="video">Upload video </label>
               <input type="file" name="video" id="video" accept="video/*" required  onchange="checkFileType(this)">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" placeholder="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="post_title">Post Title:</label>
                        <input type="text" id="post_title" name="post_title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="options">

                        <div class="form-group">
                            <label for="type">Type:</label>
                            <select id="type" name="type" required>
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
                        </div>
                    </div>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="../js/index.js"></script>
    <script>
    document.getElementById('closeBtn').addEventListener('click', function() {
        document.querySelector('.container').style.opacity = '0'; // Fade out the container
        setTimeout(function() {
            history.back(); // Go back to the previous page after the animation
        }, 500); // Match this duration with the transition duration
    });
</script>


</body>
</html>
