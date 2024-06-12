<?php
$sql = "SELECT * FROM `blog_posts` WHERE featured = 1";
$result = mysqli_query($conn, $sql);
?>
<style>
    @keyframes slideIn {
        0% {
            transform: translateX(-100%);
            opacity: 0;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }
        50% {
            transform: translateX(20%);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.5), 0 0 25px rgba(0, 0, 255, 0.5);
        }
        100% {
            transform: translateX(0);
            opacity: 1;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5), 0 0 20px rgba(0, 0, 255, 0.5), 0 0 30px rgba(0, 255, 0, 0.5), 0 0 40px rgba(255, 0, 0, 0.5);
        }
    }

    .animated-title {
        animation: slideIn 2s ease-in-out;
        font-size: 3em;
        font-weight: bold;
        text-align: center;
        color: #fff;
        transform-style: preserve-3d;
        perspective: 500px;
    }
</style>


<section class="featured-posts" style="display: flex; height: max-content; justify-content: center; align-items: center;margin-bottom: 70px; margin: 40px 0;">
    <div class="carousel-container" style="position: relative; width: 40%; height: 60%; overflow: hidden; background-color: #f0f0f0; padding: 20px; border: 5px double #333; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.9), inset 0 0 10px rgba(0, 0, 0, 0.9); background: linear-gradient(45deg, #00f, #0f0, #f0f, #ff0);">
    <h1 class="animated-title">Featured Blogs</h1> <br><br>
        <div class="carousel-slide" style="display: flex; transition: transform 0.3s ease-in-out;">
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
                if (!$stmt) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }
                
                // Bind parameters and execute query
                $stmt->bind_param("s", $row['username']);
                if (!$stmt->execute()) {
                    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
                }
                
                // Bind result variable
                $stmt->bind_result($imagePaths);
                
                // Fetch result
                $stmt->fetch();
                
                // Close statement
                $stmt->close();
            ?>
              <div class="featured-post" style="min-width: 100%; max-width: 100%; box-sizing: border-box; padding: 20px; background: #fff; border-radius: 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.9); margin: 0 10px; position: relative;">
                    <h2 style="display: flex; align-items: center; justify-content: flex-start;">
                        <img src="../Images/<?php echo htmlspecialchars($imagePaths); ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); margin-right: 10px; border: 2px dotted;">
                        @<?php echo htmlspecialchars($row['username']); ?> 
                    </h2>
                    <div style="position: relative;">
                        <img src="../Images/<?php echo htmlspecialchars($row['featured_image']); ?>" alt="Image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);">
                        <div class="post-title-overlay" style="position: absolute; bottom: 20px; left: 20px; color: #fff; background: rgba(0, 0, 0, 0.6); padding: 10px; border-radius: 5px; font-size: 1.2em; box-shadow: 0 13px 10px rgba(0, 0, 0, 0.9);">
                           Post Title :  <?php echo htmlspecialchars($row['title']); ?>
                        </div>
                    </div>
                    <p style="padding: 20px;"><?php echo htmlspecialchars($row['content']); ?></p>
                    <div class="posted-at-box" style="background-color: #f0f0f0; border-radius: 10px; padding: 5px 10px; margin-top: 10px; font-size: 1.2em; font-weight: bold; text-align: center;">
                        Posted at: <?php echo date("M j, Y, g:i a", strtotime($row['date_published'])); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="prev" onclick="prevFeaturedPost()" style="position: absolute; top: 50%; transform: translateY(-50%); background-color: #f0f0f0; border: none; padding: 10px; cursor: pointer; border-radius: 50%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); left: 10px;">←</button>
        <button class="next" onclick="nextFeaturedPost()" style="position: absolute; top: 50%; transform: translateY(-50%); background-color: #f0f0f0; border: none; padding: 10px; cursor: pointer; border-radius: 50%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); right: 10px;">→</button>
    </div>
</section>
<script>
    const featuredPosts = document.querySelectorAll('.featured-post');
    let currentFeaturedIndex = 0;

    function showFeaturedPost(index) {
        const slide = document.querySelector('.carousel-slide');
        slide.style.transform = `translateX(${-index * 100}%)`;
    }

    function nextFeaturedPost() {
        currentFeaturedIndex = (currentFeaturedIndex + 1) % featuredPosts.length;
        showFeaturedPost(currentFeaturedIndex);
    }

    function prevFeaturedPost() {
        currentFeaturedIndex = (currentFeaturedIndex - 1 + featuredPosts.length) % featuredPosts.length;
        showFeaturedPost(currentFeaturedIndex);
    }

    // Initialize the carousel
    showFeaturedPost(currentFeaturedIndex);
    setInterval(nextFeaturedPost, 10000);
</script>
