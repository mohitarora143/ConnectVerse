<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');

// Get the currently logged-in username
$username = $_SESSION['username'];

// Prepare the SQL statement to fetch distinct usernames for stories
$usernames_sql_stories = "SELECT DISTINCT username FROM story";

// Prepare the SQL statement to fetch distinct usernames for notes
$usernames_sql_notes = "SELECT DISTINCT username FROM note";

// Prepare the SQL statement to fetch posts
$posts_sql = "SELECT * FROM post WHERE username = '$username'";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Stories, Notes, and Posts</title>
    <style>
        * {
            overflow-x: hidden;
        }
        .user-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #6a11cb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .user-icon:hover {
            transform: scale(1.1);
        }
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes star-animation {
            0% {transform: translateY(0);}
            100% {transform: translateY(-1000px);}
        }
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            animation: star-animation linear infinite;
        }
        .star:nth-child(1) {
            left: 20%;
            animation-duration: 5s;
        }
        .star:nth-child(2) {
            left: 40%;
            animation-duration: 3s;
        }
        .star:nth-child(3) {
            left: 60%;
            animation-duration: 4s;
        }
        .star:nth-child(4) {
            left: 80%;
            animation-duration: 2s;
        }
        .no-stories-message {
            animation: slideInRight 2s ease-in-out;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; min-height: 100vh; background-color: #f0f0f0;">
    
    <!-- Navbar -->
    <nav style="background: linear-gradient(45deg, #6a11cb, #2575fc); padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; color: white; width: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <a href="../functions/addfriends.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 1em; transition: color 0.3s;" onmouseover="this.style.color='#ffdd57';" onmouseout="this.style.color='white';">Search Friends</a>
                 
        <form id="searchForm" method="POST" action="" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 20px; border: 2px solid transparent; transition: all 0.3s ease; visibility:hidden">
                <span style="margin-right: 10px; font-size: 1.2em; color: #6a11cb;">&#128269;</span>
                <input type="text" name="search" id="searchInput" placeholder="Search Usernames" style="width: 100%; border: none; font-size: 1em; outline: none; background: transparent;" onfocus="this.parentNode.style.borderColor='#6a11cb'; this.parentNode.style.background='#e0e0e0';" onblur="this.parentNode.style.borderColor='transparent'; this.parentNode.style.background='white';" autocomplete="off">
                <button type="submit" style="background: #6a11cb; color: white; border: none; padding: 10px 15px; border-radius: 20px; margin-left: 10px; cursor: pointer;"></button>
            </form>
            <div style="display: flex; align-items: center; margin-left: 20px;">
                <a href="../functions/recent.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 1em; transition: color 0.8s;" onmouseover="this.style.color='#ffdd57';" onmouseout="this.style.color='white';">Recent Activities</a>
                <a href="../functions/yourfollowers.php" style="color: white; text-decoration: none; margin-left: 20px; margin-right:10px; font-size: 1em; transition: color 0.7s;" onmouseover="this.style.color='#ffdd57';" onmouseout="this.style.color='white';">Your Followers' Activities</a>
            </div>
        </div>
    </nav>

<div style="width: 100%; max-width: 1200px; margin: 20px auto; position: relative;">

    <!-- Animated Stars -->
    <div class="star" style="left: 10%; animation-duration: 6s;"></div>
    <div class="star" style="left: 30%; animation-duration: 4s;"></div>
    <div class="star" style="left: 50%; animation-duration: 5s;"></div>
    <div class="star" style="left: 70%; animation-duration: 3s;"></div>
    <div class="star" style="left: 90%; animation-duration: 2s;"></div>

    <!-- Container for User Stories and Notes -->
    <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 20px; border: 2px solid #6a11cb; padding: 20px;">

        <!-- Container for User Stories -->
        <h2 style="text-align: center; color: #6a11cb; background-color: rgba(106, 17, 203, 0.1); padding: 10px; border-radius: 10px; border: 2px solid #6a11cb;">Your Today's Stories</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; margin-bottom: 20px;">
            <?php
            $hasStories = false;
            if ($result = $conn->query($usernames_sql_stories)) {
                while ($row = $result->fetch_assoc()) {
                    // Check if the current row's username matches the logged-in username
                    $isCurrentUser = ($row['username'] === $username);
                    if ($isCurrentUser) {
                        $hasStories = true;
                        echo '<form method="GET" action="user_stories.php" style="margin: 10px;">';
                        echo '<input type="hidden" name="username" value="' . $username . '">';
                        echo '<button type="submit" class="user-icon" style="background-color: #ffffff !important;">';
                        echo '<img src="../Images/'. htmlspecialchars($imagePath) .'" alt="" style="width: 90px; height: 80px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); border: 2px dotted;">';
                        echo '</button>';
                        echo '</form>';
                    }
                }
            }

            // Show message if the current user has no stories
            if (!$hasStories) {
                echo '<div class="no-stories-message" style="margin-top: 20px; color: #6a11cb; font-weight: bold;">No stories uploaded today!</div>';
            }
            ?>
            <!-- Icon for Adding Stories -->
            <form method="GET" action="addstory.php" style="display: flex; align-items: center;">
                <button type="submit" style="font-size: 20px; color: #333; text-decoration: none; transition: color 0.3s ease; border: 2px solid #ccc; padding: 10px 20px; border-radius: 5px; display: inline-block; background: linear-gradient(45deg, #f7f7f7, #eaeaea, #f7f7f7); font-family: Arial, sans-serif;">Add Story <span style="margin-left: 15px;">+</span></button>
            </form>
        </div>

        <!-- Container for User Notes -->
        <h2 style="text-align: center; color: #2575fc; background-color: rgba(37, 117, 252, 0.1); padding: 10px; border-radius: 10px; border: 2px solid #2575fc;">Your Today's Notes</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; margin-bottom: 20px;">
            <?php
            $hasNotes = false;
            if ($result = $conn->query($usernames_sql_notes)) {
                while ($row = $result->fetch_assoc()) {
                    // Check if the current row's username matches the logged-in username
                    $isCurrentUser = ($row['username'] === $username);
                    if ($isCurrentUser) {
                        $hasNotes = true;
                        echo '<form method="GET" action="user_notes.php" style="margin: 10px;">';
                        echo '<input type="hidden" name="username" value="' . $username . '">';
                        echo '<button type="submit" class="user-icon" style="background-color: #ffffff !important;">';
                        echo '<img src="../Images/'. htmlspecialchars($imagePath) .'" alt="" style="width: 90px; height: 80px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); border: 2px dotted;">';
                        echo '</button>';
                        echo '</form>';
                    }
                }
            }

            // Show message if the current user has no notes
            if (!$hasNotes) {
                echo '<div class="no-stories-message" style="margin-top: 20px; color: #2575fc; font-weight: bold;">No notes available today!</div>';
            }
            ?>
            <!-- Icon for Adding Notes -->
            <form method="GET" action="../common/addnote.php" style="display: flex; align-items: center;">
                <button type="submit" style="font-size: 20px; color: #333; text-decoration: none; transition: color 0.3s ease; border: 2px solid #ccc; padding: 10px 20px; border-radius: 5px; display: inline-block; background: linear-gradient(45deg, #f7f7f7, #eaeaea, #f7f7f7); font-family: Arial, sans-serif;">Add Note <span style="margin-left: 15px;">+</span></button>
            </form>
        </div>
    </div>
    
</div>

<!-- Footer -->
<?php include('../common/footer.php'); ?>

<script>
    // Smooth transition on button click
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            document.body.style.transition = 'opacity 0.9s';
            document.body.style.opacity = '0.9';
            setTimeout(() => {
                window.location.href = this.form.action;
            }, 500);
        });
    });
</script>

</body>
</html>
