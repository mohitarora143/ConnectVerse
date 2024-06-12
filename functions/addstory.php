<?php
session_start();
include('../common/databaseconn.php');
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Story</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div id="story-container" style="position: relative; width: 300px; text-align: center; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.8); transition: transform 0.3s, box-shadow 0.3s;">
    <button class="close-btn" style="position: absolute; top: 10px; right: 10px; background-color: #ff5f5f; border: none; border-radius: 50%; color: #fff; width: 25px; height: 25px; cursor: pointer; font-size: 18px; line-height: 25px; text-align: center; transition: background-color 0.3s;" onclick="goBack()">&times;</button>
    <h2 style="margin-top: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Add Your Story</h2>
        <form id="storyForm" action="./addstory.php" method="post" enctype="multipart/form-data">
            <input type="file" name="story" id="storyInput" accept="image/*, video/*" style="display: none;" onchange="previewStory()" required>
            <div id="preview" style="width: 100%; height: 200px; border: 2px dashed #ddd; display: flex; justify-content: center; align-items: center; cursor: pointer; margin-bottom: 10px;" onclick="document.getElementById('storyInput').click();">
                <span style="color: #888;">Click to add your story</span>
            </div>
            <input type="text" name="caption" placeholder="Add a caption" required style="width: 100%; padding: 5px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px #ccc; transition: box-shadow 0.3s;">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="highlight" value="highlight_value">
            <input type="hidden" name="created_at" value="">
            <input type="hidden" name="story_id" value="story_id_value">
            <input type="hidden" name="featured" value="featured_value">
            <button type="submit" style="margin-top: 20px; padding: 10px 20px; border: none; background-color: #007bff; color: #fff; border-radius: 5px; cursor: pointer; box-shadow: 0 4px #0056b3; transition: background-color 0.3s, transform 0.3s;" >Upload Story</button>
        </form>
    </div>

    <script>
        function previewStory() {
            const fileInput = document.getElementById('storyInput');
            const preview = document.getElementById('preview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = '';
                    const fileType = fileInput.files[0].type;
                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '10px';
                        preview.appendChild(img);
                    } else if (fileType.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.style.width = '100%';
                        video.style.height = '100%';
                        video.style.borderRadius = '10px';
                        video.controls = true;
                        preview.appendChild(video);
                    }
                }

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        document.getElementById('storyForm').addEventListener('submit', function(e) {
            document.querySelector('input[name="created_at"]').value = new Date().toISOString();
        });
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $caption = $_POST['caption'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $highlight = $_POST['highlight'];
        $created_at = $_POST['created_at'];
        $story_id = $_POST['story_id'];
        $featured = $_POST['featured'];
        $storyFile = $_FILES['story'];

        $storyFilePath = '../Images/' . basename($storyFile['name']);
        if (move_uploaded_file($storyFile['tmp_name'], $storyFilePath)) {
            $addstory = $storyFilePath;

            $sql = "INSERT INTO `story`(`username`, `email`, `caption`, `addstory`, `highlight`, `created_at`, `story_id`, `featured`) VALUES ('$username','$email','$caption','$addstory','$highlight','$created_at','$story_id','$featured')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Story uploaded successfully!');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Failed to upload file.');</script>";
        }

        $conn->close();
    }
    ?>
    <script>
function goBack() {
    document.body.style.transition = 'opacity 0.5s';
    document.body.style.opacity = '0';
    setTimeout(() => {
        window.history.back();
    }, 500);
}
</script>

</body>
</html>
