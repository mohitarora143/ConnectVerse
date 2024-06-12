<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');

// Fetch data from the database
$query = "SELECT * FROM post ";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000; /* Dark background color */
            overflow: hidden; /* Prevent scrolling */
            position: relative; /* Position relative for absolute positioning */
            color: #FFF; /* Text color */
        }

        .post-container {
            position: relative; /* Position relative for absolute positioning */
        }

        .dark-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000; /* Dark background color */
            z-index: -1; /* Behind other content */
        }

        .star {
    position: absolute;
    width: <?php echo rand(1, 5); ?>px; /* Random width */
    height: <?php echo rand(1, 5); ?>px; /* Random height */
    background-color: #FFF; /* Star color */
    animation: starAnimation <?php echo rand(10, 15); ?>s linear infinite; /* Random animation duration */
    border-radius: 50%; /* Make it round */
        }


        .moon {
            position: absolute;
            width: 100px; /* Moon size */
            height: 100px; /* Moon size */
            background-color: #FFF; /* Moon color */
            border-radius: 50%; /* Make it round */
            top: 3px; /* Position from top with margin of 3px */
            right: 3px; /* Position from right with margin of 3px */
            box-shadow: 0 0 30px #FFF; /* Glow effect */
        }

        .shooting-star {
            position: absolute;
            width: 2px; /* Star width */
            height: 2px; /* Star height */
            background-color: #FFF; /* Star color */
            animation: shootingStar <?php echo rand(5, 8); ?>s linear infinite; /* Random animation duration */
        }

        @keyframes shootingStar {
            0% {
                opacity: 0;
                transform: translateX(0) translateY(0); /* Initial position */
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateX(100vw) translateY(100vh); /* Move to the bottom right */
            }
        }

        @keyframes starAnimation {
            0% {
                opacity: 1;
                transform: translateY(0) rotate(<?php echo rand(0, 360); ?>deg); /* Random rotation */
            }
            10% {
                opacity: 1;
            }
            20% {
                opacity: 0.8;
            }
             
            15% {
                opacity: 0.7;
            }
            
            40% {
                opacity: 0.6;
            }
            
            60% {
                opacity: 0.5;
            }
            
            80% {
                opacity: 0.3;
            }
            100% {
                opacity: 1;
                transform: translateY(100vh) rotate(<?php echo rand(0, 360); ?>deg); /* Random rotation */
            }
        }

        .btn-close:hover {
            transform: scale(1.2); /* Scale up on hover */
            transition: transform 0.3s ease; /* Smooth transition */
        }
    </style>
</head>
<body>

<div class="dark-background">
    <!-- Stars -->
    <?php
    for ($i = 0; $i < 1000; $i++) {
        $left = rand(0, 100); // Random horizontal position
        $top = rand(0, 100); // Random vertical position
        ?>
        <div class="star" style="left: <?php echo $left; ?>%; top: <?php echo $top; ?>%;"></div>
    <?php } ?>

    <!-- Moon -->
    <div class="moon"></div>

    <!-- Shooting stars -->
    <?php
    for ($i = 0; $i < 100; $i++) {
        $left = rand(0, 100); // Random horizontal position
        $top = rand(0, 100); // Random vertical position
        ?>
        <div class="shooting-star" style="left: <?php echo $left; ?>%; top: <?php echo $top; ?>%;"></div>
    <?php } ?>
</div> <!-- Dark background -->

<div class="container d-flex justify-content-center align-items-center" style="height: 70%; margin-top:6px">
    <?php
        // SQL query to fetch posts with associated user profile picture
        $query = "SELECT post.*, registration.images, registration.username FROM post 
        INNER JOIN registration ON post.username = registration.username";
        $result = $conn->query($query);

    // Check if there are posts
    if ($result->num_rows > 0) {
        // Loop through each row of the result
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="post-container" style="display: <?php echo ($i == 0) ? 'block' : 'none'; ?>">
                <div class="card mb-3" style="animation: fadeInOut 8s infinite;">
                    <div class="card-body">
                        <!-- Close button -->
                        <button type="button" class="btn-close" aria-label="Close" onclick="prevPost()" style="position: absolute; top: 10px; right: 10px;"></button>
                        <!-- Profile Picture and Username -->
                        <div class="profile-info" style="display:flex; align-items:center; margin-bottom:7px">
                            <img src="../Images/<?php echo htmlspecialchars($row['images']); ?>" alt="User Profile Picture" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                            <p style="margin: 0;"><strong><?php echo htmlspecialchars($row['username']); ?></strong></p>
                        </div>
                        <!-- Post Title -->
                        <h5 class="card-title"><?php echo htmlspecialchars($row['post_title']); ?></h5>
                        <!-- Post Image -->
                        <img src="../Images/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" style="width: 100%; height: 500px; margin-bottom: 5px;">
                        <!-- Post Description -->
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <!-- Time of Post -->
                        <p class="card-text"><?php echo date('Y-m-d', strtotime($row['time_of_post'])); ?></p>
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

<script>
    // Automatically switch posts after 10 seconds
    let currentIndex = 0;
    const posts = document.querySelectorAll('.post-container');

    setInterval(() => {
        posts[currentIndex].style.animation = '';
        posts[currentIndex].style.display = 'none';
        currentIndex = (currentIndex + 1) % posts.length;
        posts[currentIndex].style.display = 'block';
    }, 10000); // Switch posts every 10 seconds
</script>

<style>
    @keyframes fadeInOut {
        0%, 100% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
    }
</style>

<!-- Navigation Buttons -->
<div class="container d-flex justify-content-center align-items-center" style="position: fixed; bottom: 20px; margin: 10px; padding: 10px; justify-content:center;align-items:center">
    <button class="btn btn-primary me-2" onclick="prevPost()">Previous</button>
    <button class="btn btn-primary" onclick="nextPost()">Next</button>
</div>


<script>
    function prevPost() {
        window.history.back();
    }

    function nextPost() {
        posts[currentIndex].style.animation = '';
        posts[currentIndex].style.display = 'none';
        currentIndex = (currentIndex + 1) % posts.length;
        posts[currentIndex].style.display = 'block';
        posts[currentIndex].style.animation = 'fadeInOut 2s infinite';
    }
</script>

</body>
</html>
