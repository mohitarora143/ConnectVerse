<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');
include('../common/fetchingall.php'); // Include fetchingall.php to fetch the user's location
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cutting-edge Social Media App</title>
</head>
<body style="height: 100%; margin: 0; padding: 0; font-family: Arial, sans-serif; overflow-x:hidden">

<!-- Header -->
<?php include('../common/mainpageheader.php')?>

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(45deg, #00f, #0f0, #f0f, #ff0); color: #fff; text-align: center; padding: 50px 20px;">
    <h1 style="margin: 0; font-size: 3em;">Welcome to the Future of Social Media</h1>
    <p style="font-size: 1.2em;">Engage in immersive VR stories, collaborate anonymously, and connect with content that matches your mood.</p>
    <button style="padding: 10px 20px; font-size: 1em; color: #fff; background-color: #00f; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">Get Started</button>
</section>

<div style="display: flex; justify-content: space-between;">
    <!-- User Posts Section -->
  <!-- User Posts Section -->
  <div style="width: 55%; display: flex; flex-direction: column; gap: 10px;">
    <section class="user-posts" style="position: relative; width: 100%; overflow: hidden;">
        <?php
        // Fetch user posts
        $following_sql = "SELECT * FROM following WHERE (username = ? OR friends = ?) AND aceepted = 1";
        $following_users = [];
        if ($stmt = $conn->prepare($following_sql)) {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $following_users[] = $row['username'];
                $following_users[] = $row['friends'];
            }
            $stmt->close();
        } else {
            echo "Error: Unable to prepare SQL statement.";
        }
        
        // Fetch posts for the current user and following users
        $posts_sql = "SELECT * FROM post WHERE username = ? ";
        foreach ($following_users as $user) {
            $posts_sql .= "OR username = '$user' ";
        }
        $posts_sql .= "ORDER BY time_of_post DESC";
        
        $posts = [];
        if ($stmt = $conn->prepare($posts_sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            $stmt->close();
        } else {
            echo "Error: Unable to prepare SQL statement.";
        }
        
        ?>

        <div id="slideshow" style="display: flex;">
            <?php foreach ($posts as $post) : ?>
                <?php
                // Fetch user profile image path
                $imagepath_sql = "SELECT images FROM registration WHERE username = ?";
                $imagepath = '';
                if ($stmt = $conn->prepare($imagepath_sql)) {
                    $stmt->bind_param("s", $post['username']);
                    $stmt->execute();
                    $stmt->bind_result($imagepath);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    echo "Error: Unable to prepare SQL statement.";
                }
                ?>
                <div class="post-card" style="background-color: #f0f0f0; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.6); flex: 0 0 auto; width:100%">
                    <div class="user-profile" style="display: flex; align-items: center;">
                        <img src="../Images/<?php echo $imagepath; ?>" alt="User" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <span class="username" style="font-weight: bold;"><?php echo htmlspecialchars($post['username']); ?></span>
                    </div>
                    <div class="post-content" style="margin-top: 10px;">
                        <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
                        <img src="../Images/<?php echo htmlspecialchars($post['image']); ?>" alt="" style="width: 90%; height: 400px;">
                        <p style="margin: 0;"><?php echo htmlspecialchars($post['description']); ?></p>
                        <div class="post-actions" style="margin-top: 10px; display: flex; align-items: center;">
                            <span class="like-count" style="margin-right: 20px;">100 Likes</span>
                            <a href="#" style="margin-right: 20px;">Like</a>
                            <a href="#" style="margin-right: 20px;">Comment</a>
                            <a href="#">Share</a>
                        </div>
                        <span class="post-time" style="display: block; margin-top: 10px; color: #666;">Posted on <?php echo date('Y-m-d', strtotime($post['time_of_post'])); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>




    <!-- Sidebar Section -->
    <div style="width: 40%; display: flex; flex-direction: column; gap: 10px;">
        <!-- Weather Information -->
        <section class="sidebar">
            <div class="weather-container" style="display: flex; gap: 10px;">
                <!-- Weather Details Section -->
                <div class="weather-details" style="flex: 1; height: 170px;">
                    <div class="weather-info" style="background-color: #f0f0f0; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.6); transition: transform 0.3s ease;">
                        <h2 style="font-size: 1.5em; color: #00f; margin-bottom: 10px; text-align: center; align-items: center;">Today's Weather</h2>
                        <p id="location" style="margin: 0; text-align: center; align-items: center;"></p>
                        <p id="temperature" style="margin: 0; text-align: center; align-items: center;"></p>
                        <p id="condition" style="margin: 0; text-align: center; align-items: center;"></p>
                    </div>
                </div>
                <!-- Weather Emojis Section -->
                <div class="weather-emojis" style="flex: 1; height: 100px;">
                    <div class="emoji-info" style="background-color: #f0f0f0; height: 110px; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.6); transition: transform 0.3s ease;">
                        <h2 style="font-size: 1.5em; color: #00f; margin-bottom: 10px; text-align: center; align-items: center;" id="show"></h2>
                        <div id="weather-emoji" style="font-size: 3em; text-align: center; align-items: center;"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Task Manager Section -->
        <section class="sidebar" style="text-align: center;">
            <div class="task-manager" style="background-color: #f0f0f0; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.6);">
                <h2 style="font-size: 1.5em; color: #00f; margin-bottom: 10px;"><strong><b>Important Schedule Tasks</b></strong></h2>
                <ul id="task-list" style="padding-left: 20px;">
                    <?php
                    $stories_sql = "SELECT * FROM `tasks` WHERE username = ? ORDER BY created_at DESC";
                    if ($stmt = $conn->prepare($stories_sql)) {
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $taskCount = 0;
                        while ($row = $result->fetch_assoc()) {
                            $created_at = new DateTime($row['due_date']);
                            $expiration_date = clone $created_at;
                            $expiration_date->modify('0 days');
                            $current_date = new DateTime();
                            $interval = $current_date->diff($expiration_date);
                            $hours_left = ($interval->days * 24) + $interval->h;

                            echo '<div class="story" style="padding: 10px; margin-bottom: 10px; opacity: 0.9; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">';
                            echo '<div style="font-weight: bold; margin-bottom: 5px; color: #333;">' . htmlspecialchars($row['title']) . '</div>';
                            echo '<div style="margin-bottom: 5px; color: #555;">' . htmlspecialchars($row['description']) . '</div>';
                            echo '<div style="margin-bottom: 5px; color: #999;">Expires in: ' . ($hours_left > 0 ? $hours_left . ' hours' : 'Expired') . '</div>';
                            echo '</div>';

                            $taskCount++;
                        }

                        // After displaying all tasks, check if there are more than 2 tasks
                        if ($taskCount > 2) {
                            echo '<div id="see-more" style="text-align: center; color: #00f; cursor: pointer;">See More</div>';
                        }

                        $stmt->close();
                    } else {
                        echo "Error: Unable to prepare SQL statement.";
                    }
                    ?>
                </ul>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="./taskmanager.php" style="text-decoration: none; color: #00f; font-weight: bold;">
                        View All Tasks <span style="font-size: 1.2em; vertical-align: middle;">▶️</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
<?php include('../common/featured.php'); ?>

<script>
    let currentIndex = 0;
    const slides = document.querySelectorAll('.post-card');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach((slide, idx) => {
            slide.style.display = idx === index ? 'block' : 'none';
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    }

    function previousSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        showSlide(currentIndex);
    }

    // Show the first slide initially
    showSlide(currentIndex);

    // Auto transition to next slide every 10 seconds
    setInterval(nextSlide, 10000);
    function api() {
        fetch("http://api.weatherapi.com/v1/current.json?key=c35affcddc29435da8195420240506&q=<?php echo $state; ?>")
            .then(res => res.json())
            .then(data => {
                const locationElement = document.getElementById('location');
                const temperatureElement = document.getElementById('temperature');
                const conditionElement = document.getElementById('condition');
                const showForecast = document.getElementById('show');

                locationElement.textContent = "Location: " + data.location.name;
                temperatureElement.textContent = "Temperature: " + data.current.temp_c + "°C";
                conditionElement.textContent = "Condition: " + data.current.condition.text;
                showForecast.textContent = data.current.condition.text;

                updateWeatherEmojis(data.current.condition.text);
            })
            .catch(error => console.error('Error fetching weather data:', error));
    }
    api();

    function updateWeatherEmojis(condition) {
        const weatherEmojiElement = document.getElementById('weather-emoji');
        let emoji;

        switch (condition.toLowerCase()) {
            case 'rain':
                emoji = '🌧️'; // Rain emoji
                break;
            case 'cloudy':
                emoji = '☁️'; // Cloudy emoji
                break;
            case 'partly cloudy':
                emoji = '⛅'; // Partly cloudy emoji
                break;
            case 'mist':
                emoji = '🌫️'; // Mist emoji
                break;
            case 'patchy rain nearby':
                emoji = '🌦️'; // Patchy rain nearby emoji
                break;
            default:
                emoji = '☀️'; // Default to sun emoji
        }

        weatherEmojiElement.textContent = emoji;
    }
</script>

<!-- Emoji Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../JS/weather.js"></script>
<script src="../JS/location.js"></script>
<script src="../JS/moodemoji.js"></script>
<script src="../JS/postnavigation.js"></script>
</body>
</html>
<?php  include('../common/footers.php') ?>