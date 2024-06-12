<?php
session_start();
include("../common/databaseconn.php");
include("../common/profileupload.php");

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Handle AJAX request to set session variable
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_session'])) {
    $_SESSION['clicked_username'] = $_POST['username'];
    echo 'success';
    exit;
}

// Handle search request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search = $_POST['search'];
    $loggedInUsername = $_SESSION['username']; // Ensure the logged-in username is stored in session
    $stmt = $conn->prepare("SELECT username FROM registration WHERE username LIKE CONCAT('%', ?, '%') AND username != ?");
    $stmt->bind_param("ss", $search, $loggedInUsername);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($foundUsername);
    
    $usernames = [];
    while ($stmt->fetch()) {
        $usernames[] = $foundUsername;
    }
    
    $stmt->close();
    $conn->close();
    
    if (!empty($usernames)) {
        foreach ($usernames as $username) {
            echo "<a href='javascript:void(0);' onclick='setSessionAndRedirect(\"$username\")' style='display: block; margin: 5px 0;'>$username</a>";
        }
    } else {
        echo "No matching username found.";
    }
    exit; // Ensure the script exits after handling the POST request
}

// Fetch posts from the logged-in user or their friends
$query = "
    SELECT post.*, registration.images, registration.username 
    FROM post 
    INNER JOIN registration ON post.username = registration.username 
    WHERE post.username = ? OR post.username IN (
        SELECT friends FROM following WHERE username = ?
    )";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Navbar with Search Bar</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        @keyframes fadeInOut {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        .post-container img {
            width: 60%;
            height: auto;
            max-height: 350px;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
            opacity: 0.9;
            transition: opacity 0.9s;
            border: 3px solid #2575fc;
            padding: 5px;
        }

        .post-container .card-title {
            text-align: center;
            font-weight: bold;
            font-family: 'Georgia', serif;
            font-size: 1.5em;
            color: #333;
            margin-bottom: 15px;
            animation: fadeInOut 4s infinite;
        }

        .card-body {
            position: relative;
        }

        .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .profile-info {
            display: flex;
            align-items: center;
            margin-bottom: 7px;
            justify-content: flex-start;
        }

        .profile-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #2575fc;
        }

        .profile-info p {
            margin: 0;
            font-weight: bold;
        }

        .card-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .card-text.date {
            color: #6c757d;
        }
    </style>
</head>
<body style="font-family: 'Arial', sans-serif; background-color: #f0f0f0; margin: 0; padding: 0;">

    <!-- Search Form -->
    <nav style="background: linear-gradient(45deg, #6a11cb, #2575fc); padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <form id="searchForm" method="POST" action="" style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 20px; border: 2px solid transparent; transition: all 0.3s ease;">
                <span style="margin-right: 10px; font-size: 1.2em; color: #6a11cb;">&#128269;</span>
                <input type="text" name="search" id="searchInput" placeholder="Search Usernames" style="width: 100%; border: none; font-size: 1em; outline: none; background: transparent;" onfocus="this.parentNode.style.borderColor='#6a11cb'; this.parentNode.style.background='#e0e0e0';" onblur="this.parentNode.style.borderColor='transparent'; this.parentNode.style.background='white';" autocomplete="off">
                <button type="submit" style="background: #6a11cb; color: white; border: none; padding: 10px 15px; border-radius: 20px; margin-left: 10px; cursor: pointer;">Search</button>
            </form>
            <div style="display: flex; align-items: center; margin-left: 20px;">
                <a href="../functions/recent.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 1em; transition: color 0.3s;" onmouseover="this.style.color='#ffdd57';" onmouseout="this.style.color='white';">Recent Activities</a>
                <a href="../functions/yourfollowers.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 1em; transition: color 0.3s;" onmouseover="this.style.color='#ffdd57';" onmouseout="this.style.color='white';">Your Followers' Activities</a>
            </div>
        </div>
    </nav>

    <div id="results" style="padding: 20px;"></div>

    <div style="display: flex; padding: 20px;">
        
        <div style="flex: 1; padding: 40px; width: 70%; margin: 0 40px;">
            <h2 class="headings" style="text-align: center; color: blueviolet;">YOUR ALL POSTS</h2>
            <div id="userPosts" style="padding: 20px; overflow-y: auto; max-height: 80vh;">
                <?php
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="post-container" style="display: <?php echo ($i == 0) ? 'block' : 'none'; ?>; animation: fadeInOut 8s infinite; overflow-y:hidden">
                            <div class="card mb-3" style="border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8); margin-bottom: 20px; overflow-y:hidden">
                                <div class="card-body">
                                    <button type="button" class="btn-close" aria-label="Close" onclick="prevPost()">&times;</button>
                                    <div class="profile-info">
                                        <img src="../Images/<?php echo htmlspecialchars($row['images']); ?>" alt="User Profile Picture">
                                        <p><?php echo htmlspecialchars($row['username']); ?></p>
                                    </div>
                                    <h5 class="card-title"><strong>Posted Title: <?php echo htmlspecialchars($row['post_title']); ?></strong></h5>
                                    <img src="../Images/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image">
                                    <p class="card-text" style="margin:5px"><?php echo htmlspecialchars($row['description']); ?></p>
                                    <p class="card-text date" style="margin:5px"><strong>Posted At: <?php echo date('Y-m-d', strtotime($row['time_of_post'])); ?></strong></p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                } else {
                    echo "No posts found.";
                }
                ?>
            </div>
        </div>
    </div>
    
    <?php include("../common/footer.php"); ?>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchInput = document.getElementById('searchInput').value;
            const resultsDiv = document.getElementById('results');

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'search': searchInput
                })
            })
            .then(response => response.text())
            .then(data => {
                resultsDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function setSessionAndRedirect(username) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'set_session': true,
                    'username': username
                })
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    window.location.href = 'profile.php';
                } else {
                    console.error('Failed to set session variable');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Automatically switch posts after 10 seconds
        let currentIndex = 0;
        const posts = document.querySelectorAll('.post-container');

        setInterval(() => {
            posts[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % posts.length;
            posts[currentIndex].style.display = 'block';
        }, 10000); // Switch posts every 10 seconds
    </script>
</body>
</html>
