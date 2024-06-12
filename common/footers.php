<body>
  <?php 
  include('../common/profileupload.php');
  ?>


<div class="bottom-nav" style=" bottom: 0; left: 0; width: 100%; display: flex; justify-content: space-around; align-items: center; background-color: #f0f0f0; padding: 10px 0; box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.8);">
    <a href="../functions/mainpage.php" class="nav-item" style="text-decoration: none; color: #666; font-size: 1.5em; transition: transform 0.3s;">🏠</a>
    <a href="addfriends.php" class="nav-item" style="text-decoration: none; color: #666; font-size: 1.5em; transition: transform 0.3s;">🔍</a>
    <a href="post.php" class="nav-item" style="text-decoration: none; color: #666; font-size: 1.5em; transition: transform 0.3s;">➕</a>
    <a href="community_main.php" class="nav-item" style="text-decoration: none; color: #666; font-size: 1.5em; transition: transform 0.3s;">🔮</a>
    <a href="dashboard.php" class="nav-item" id="images1" style="text-decoration: none; color: #666; font-size: 1.5em; transition: transform 0.3s;">
        <div class="user-dpp" style="width: 40px; height: 40px; overflow: hidden; border-radius: 50%; box-shadow: 0 0 5px rgba(0, 0, 0, 0.7); margin-left:80px">
            <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
        </div>
    </a>
</div>

</body>