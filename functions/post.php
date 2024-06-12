<?php
session_start();
include '../common/databaseconn.php';
$username = $_SESSION['username'];
include '../common/profileupload.php';
$sql = "SELECT * FROM `note`";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnectVerse - Main Page</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0;">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <header class="welcome-section">
        <div class="welcome-text">
          <h1>Welcome to Connect Verse</h1>
          <p>Explore, Create, and Connect Like Never Before</p>
        </div>
        <div class="user-info" id="userInfo">
          <div class="user-dp" id="images1" onclick="toggleOptions()">
            <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.9);">
          </div>
          <div id="options" style="display: none; position: absolute; top: 120px; right: 10px; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); padding: 10px;">
    <p style="margin: 5px 0;"><strong>@<?php echo htmlspecialchars($username); ?></strong></p>
    <a href="../functions/editprofile.php" style="display: block; padding: 8px 0; color: #4CAF50; text-decoration: none;">Edit Profile</a>
    <a href="logout.php" style="display: block; padding: 8px 0; color: #F44336; text-decoration: none;">Logout</a>
</div>

        </div>
      </header>
    </div>
  </div>
</nav>

<div class="add-post-options" style="display: flex; justify-content: center; margin-top: 20px;">
    <div class="option" id="add-post" style="margin: 0 10px;"><a href="addpost.php" style="text-decoration: none; color: #333;">Add Post</a></div>
    <div class="option" id="add-story" style="margin: 0 10px;"><a href="addstory.php" style="text-decoration: none; color: #333;">Add Story</a></div>
    <div class="option" id="add-blog" style="margin: 0 10px;"><a href="./addnewblog.php" style="text-decoration: none; color: #333;">Add Blog</a></div>
    <div class="option" id="add-note" style="margin: 0 10px;"><a href="../common/addnote.php" style="text-decoration: none; color: #333;">Add Note</a></div>
</div> 

<div style="position: relative; width: max-content; height: 300px; overflow: hidden; display: flex; justify-content: center; align-items: center; background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fad0c4, #ffdde1, #ff9a9e); background-size: 400% 400%; animation: gradientBG 15s ease infinite; border-radius: 14px; box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.6); margin: 0 auto; margin-top: 60px; padding: 0;">
    <div id="note-wrapper" style="display: flex; transition: transform 0.3s ease;">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): 
              // Check if note is older than 24 hours
              $noteDate = new DateTime($row['note_date']);
              $currentDate = new DateTime();
              $diff = $currentDate->diff($noteDate);
              if ($diff->h >= 24) {
                  continue; // Skip note if older than 24 hours
              }
              
              // Fetch image specific to note's username
              $noteUsername = $row['username'];
              $stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
              if (!$stmt) {
                  die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
              }
              
              // Bind parameters and execute query
              // Bind parameters and execute query
              $stmt->bind_param("s", $noteUsername);
              if (!$stmt->execute()) {
                  die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
              }
              
              // Bind result variable
              $stmt->bind_result($imagePaths);
              
              // Fetch result
              $stmt->fetch();
              
              // Close statement
              $stmt->close();?>
                <div style="width: 200px; height: 100%; margin: 0 10px; padding: 20px; background-color: rgba(255, 255, 255, 0.8); border-radius: 10px;border:2px solid grey; box-shadow: 0px 5px 15
px rgba(0, 0, 0, 0.7); transition: transform 0.3s ease, box-shadow 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0px 10px 20px rgba(0, 0, 0, 0.7)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 5px 15px rgba(0, 0, 0, 0.7)';">
                <h2 style="margin: 0 0 10px 0; font-size: 1.2em; color: #333; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"> @ <?php echo htmlspecialchars($noteUsername); ?></h2>   
                <img src="../Images/<?php echo htmlspecialchars($imagePaths); ?>" alt="User Profile Picture" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
          
                <h2 style="margin: 0 0 10px 0; font-size: 1.2em; color: #333; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"><?php echo htmlspecialchars($row['note_title']); ?></h2>
                    <p style="margin: 0; font-size: 1em; color: #666;"><?php echo htmlspecialchars($row['notes']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="font-size: 1.2em; color: #777;">No notes found</p>
        <?php endif; ?>
    </div>
    <button onclick="scrollLeft()" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); background-color: #2196f3; color: #fff; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; outline: none;">&#8249;</button>
    <button onclick="scrollRight()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background-color: #2196f3; color: #fff; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; outline: none;">&#8250;</button>
</div>

<!-- Text in the middle with animation -->
<div style="position: absolute; top: 35%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(255, 255, 255, 0.8); padding: 10px 20px; border-radius: 10px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3); animation: textAnimation 2s ease infinite;">
    <p style="font-size: 1.5em; color: #333; margin:0px;">Notes Are Here !</p>
</div>

<?php include '../common/footer.php'?>

<script>
    function scrollLeft() {
        var wrapper = document.getElementById('note-wrapper');
        wrapper.scrollBy({ left: -10, behavior: 'smooth' });
    }

    function scrollRight() {
        var wrapper = document.getElementById('note-wrapper');
        wrapper.scrollBy({ left: 10, behavior: 'smooth' });
    }
</script>

<!-- Inline CSS for background animation and text animation -->
<style>
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes textAnimation {
        0% { transform: translate(-50%, -50%); }
        50% { transform: translate(-50%, -45%); }
        100% { transform: translate(-50%, -50%); }
    }
</style>

<script>
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
</body>
</html>
