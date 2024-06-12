<?php
session_start();
include('../common/databaseconn.php'); // Include the database connection

// Retrieve username and email from session
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Retrieve profile picture path
$stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($imagePath);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // Handle file upload
    $target_dir = "../Images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File is uploaded successfully, proceed with database insert
            $image = basename($_FILES["image"]["name"]); // the name of the file

            // Check if a post with the same username, image name, and email already exists
            $sql_check = "SELECT * FROM post WHERE username = '$username' AND image = '$image' AND email = '$email'";
            $result_check = mysqli_query($conn, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                // A post with similar details already exists
                echo "A post with similar details already exists.";
            } else {
                // Prepare and execute the SQL statement for inserting the new post
                $sql_insert = "INSERT INTO post (username, email, post_id, description, image, category, type, post_title, comment, likes, archive, time_of_post, featured)
                                VALUES ('$username', '$email', NULL, '$description', '$image', '$category', '$type', '$post_title', 1, 0, 0, NOW(), 0)";

                if (mysqli_query($conn, $sql_insert)) {
                    echo "New post created successfully";
                } else {
                    echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
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
            <div class="user-dp" id="images1">
                <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture">
            </div>

            <ul>
                <li>
                <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="<?php echo $username; ?>" readonly>
                    </div>
                </li>
                <li><a href="./addvideos.php">Upload videos</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </div>
        <div class="form-container">
            <div class="close-btn-container" style="display: flex; justify-content:flex-end">
                <button id="closeBtn">&times;</button> <!-- Close button -->
            </div>
            <h3>Add A New Post Photo</h3>
            <form id="postForm" action="addpost.php" method="post" enctype="multipart/form-data">
                
                <div class="form-slide active">
                <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input type="file" id="image" name="image" required onchange="checkFileType(this)">
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
