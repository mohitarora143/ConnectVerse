<?php  
$username =$_SESSION['username']; ?>

<header style="display: flex; justify-content: space-between; align-items: center; background-color: #1a1a1a; color: #fff; padding: 10px 20px;">
    <div class="logo" style="font-size: 1.5em; color: #00f;">
        <p style="margin-right: 15px; margin-left:40px"><strong>@<?php echo htmlspecialchars($username); ?></strong></p>
    </div>
    <nav class="navbar" style="display: flex;">
        <a href="./mainpage.php" style="margin: 0 10px; color: #fff; text-decoration:none">Home</a>
        <a href="./blogmain.php" style="margin: 0 10px; color: #fff; text-decoration:none">Blogs</a>
        <a href="./community_main.php" style="margin: 0 10px; color: #fff;text-decoration:none">Community</a>
        <a href="./taskmanager.php" style="margin: 0 10px; color: #fff;text-decoration:none">Task Scheduler</a>
        <a href="../functions/addfriends.php" style="margin: 0 10px; color: #fff;text-decoration:none">Search Friends</a>
        <a href="../functions/dashboard.php" style="margin: 0 10px; color: #fff;text-decoration:none">Dashboard</a>
    </nav>
    <div class="user-info" id="userInfo">
          <div class="user-dp" id="images1" onclick="toggleOptions()">
            <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.9);">
          </div>
          <div id="options" style="display: none; position: absolute; top: 120px; right: 10px; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); padding: 10px;">
    <p style="margin: 5px 0; color:#F44336"><strong>@<?php echo htmlspecialchars($username); ?></strong></p>
    <a href="../functions/editprofile.php" style="display: block; padding: 8px 0; color: #4CAF50; text-decoration: none;">Edit Profile</a>
    <a href="../logout.php" style="display: block; padding: 8px 0; color: #F44336; text-decoration: none;">Logout</a>
</div>

        </div>
</header>
<script>
    function toggleOptions() {
        const options = document.getElementById('options');
        options.style.display = options.style.display === 'none' ? 'block' : 'none';
    }
</script>
