<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');

// Get the currently logged-in username
$username = $_SESSION['username'];

// Prepare the SQL statement to fetch friends' names
$friends_sql = "SELECT CASE
                      WHEN f.username = '$username' THEN f.friends
                      ELSE f.username
                 END AS friend_name
                FROM following f
               WHERE (f.username = '$username' OR f.friends = '$username')
                 AND f.aceepted = 1";

// Execute the query
$friends_result = $conn->query($friends_sql);

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
        <h2 style="text-align: center; color: #6a11cb; background-color: rgba(106, 17, 203, 0.1); padding: 10px; border-radius: 10px; border: 2px solid #6a11cb;">Your Friend's Today's Stories</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; margin-bottom: 20px;">
          
        <?php
// Check if there are any friends
if ($friends_result->num_rows > 0) {
    // Array to store friend names
    $friend_names = array();
    // Output data of each row
    while ($row = $friends_result->fetch_assoc()) {
        $friend_names[] = $row['friend_name'];
    }

    // Prepare the SQL statement to fetch stories for friends only, excluding the current user
    $usernames_sql_stories = "SELECT username FROM story WHERE username IN ('" . implode("','", $friend_names) . "') AND username != '$username'";

    // Execute the query
    $stories_result = $conn->query($usernames_sql_stories);

    // Check if there are any stories
    if ($stories_result->num_rows > 0) {
        // Output data of each row
        while ($row = $stories_result->fetch_assoc()) {
            $friend_username = $row['username'];
            $stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            // Bind parameters and execute query
            $stmt->bind_param("s", $friend_username);
            if (!$stmt->execute()) {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            // Bind result variable
            $stmt->bind_result($imagePathss);

            // Fetch result
            $stmt->fetch();

            // Display stories for each friend
            echo '<form method="GET" action="../common/show_other.php" style="margin: 10px;">';
            $session['username']= $friend_username;
            echo '<input type="hidden" name="username" value="' . $friend_username . '">';
            echo '<button type="submit" class="user-icon" style="background-color: #ffffff !important;">';
            echo '<img src="../Images/' . htmlspecialchars($imagePathss) . '" alt="" style="width: 90px; height: 80px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8); border: 2px dotted;">';
            echo '</button>';
            echo '</form>';
        }
    } else {
        // Show message if there are no stories for any friend
        echo '<div class="no-stories-message" style="margin-top: 20px; color: #6a11cb; font-weight: bold;">No stories uploaded today!</div>';
    }
}

// Close the connection
$conn->close();
?>

        </div>

        <!-- Container for User Notes -->
        <h2 style="text-align: center; color: #2575fc; background-color: rgba(37, 117, 252, 0.1); padding: 10px; border-radius: 10px; border: 2px solid #2575fc;">Your Friend's Today's Notes</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; margin-bottom: 20px;">
          
            <!-- Icon for Adding Notes -->
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
