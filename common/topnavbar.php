<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3D Dropdown Menu</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg" style="background-color: #f9f9f9; border-bottom: 3px solid #ccc; font-family: Arial, sans-serif; color: #333;">
    <div class="container-fluid">
      <!-- Username with down arrow -->
      <div class="user-details navbar-brand ms-3" style="display: flex; align-items: center;">
        <p style="margin-right: 15px; margin-left:40px; font-weight: bold;"><strong>@<?php echo htmlspecialchars($username); ?></strong></p>
        <span style="font-size: 14px;">
          <a href="#" id="accountToggle" style="text-decoration: none; color: #333;">▼</a>
        </span>
      </div>

      <!-- Community Page Link -->
      <a class="navbar-brand ms-auto" href="#" id="mainToggle" style="color: #333;">
        🌐
      </a>

      <!-- Post Image/Reel Link -->
      <a class="navbar-brand" href="#" id="photoToggle" style="color: #333; position: relative; font-weight: bold;">
        📸
      </a>

      <!-- Settings -->
      <a class="navbar-brand" href="#" id="settingsToggle" style="color: #333; position: relative; font-weight: bold;">
        ⚙️
      </a>
    </div>
  </nav>

  <!-- Account Options Menu -->
  <div id="accountMenu" style="display: none; position: absolute; top: 60px; left: 50px; background-color: rgba(249, 249, 249, 0.95); border: 1px solid #666; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); opacity: 0; transition: opacity 0.5s, transform 0.5s; transform: translateY(-20px); padding: 10px;">
    <a href="../login.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Add Account</a>
  </div>

  <!-- Photo Options Menu -->
  <div id="photoMenu" style="display: none; position: absolute; top: 60px; right: 10px; background-color: rgba(249, 249, 249, 0.95); border: 1px solid #666; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); opacity: 0; transition: opacity 0.5s, transform 0.5s; transform: translateY(-20px); padding: 10px;">
    <a href="../functions/addpost.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Add Post</a>
    <a href="../functions/addvideos.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Add Video</a>
    <a href="../functions/addstory.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Add Story</a>
    <a href="../common/addnote.php" style="display: block; padding: 10px; color: darkgreen; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Add Note</a>
  </div>

  <!-- Settings Menu -->
  <div id="settingsMenu" style="display: none; position: absolute; top: 60px; right: 10px; background-color: rgba(249, 249, 249, 0.95); border: 1px solid #666; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); opacity: 0; transition: opacity 0.5s, transform 0.5s; transform: translateY(-20px); padding: 10px;">
    <a href="../functions/editprofile.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Edit Profile</a>
    <a href="../functions/mainpage.php" style="display: block; padding: 10px; color: darkgreen; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Home</a>
    <a href="../logout.php" style="display: block; padding: 10px; color: chartreuse; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Logout</a>
  </div>

  <!-- Main Menu -->
  <div id="mainMenu" style="display: none; position: absolute; top: 60px; right: 10px; background-color: rgba(249, 249, 249, 0.95); border: 1px solid #666; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); opacity: 0; transition: opacity 0.5s, transform 0.5s; transform: translateY(-20px); padding: 10px;">
    <a href="../functions/blogmain.php" style="display: block; padding: 10px; color: #333; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">View Blogs</a>
    <a href="../functions/community_main.php" style="display: block; padding: 10px; color: darkgreen; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">View Community</a>
    <a href="../functions/addfriends.php" style="display: block; padding: 10px; color: blue; text-decoration: none; font-weight: bold; transition: background-color 0.3s, color 0.3s;">Search Friends</a>
  </div>

  <script>
    document.getElementById('accountToggle').addEventListener('click', function(event) {
      event.preventDefault();
      var accountMenu = document.getElementById('accountMenu');
      if (accountMenu.style.display === 'none' || accountMenu.style.display === '') {
        accountMenu.style.display = 'block';
        setTimeout(function() {
          accountMenu.style.opacity = '1';
          accountMenu.style.transform = 'translateY(0)';
        }, 10);
      } else {
        accountMenu.style.opacity = '0';
        accountMenu.style.transform = 'translateY(-20px)';
        setTimeout(function() {
          accountMenu.style.display = 'none';
        }, 500);
      }
    });

    document.getElementById('photoToggle').addEventListener('click', function(event) {
      event.preventDefault();
      var photoMenu = document.getElementById('photoMenu');
      if (photoMenu.style.display === 'none' || photoMenu.style.display === '') {
        photoMenu.style.display = 'block';
        setTimeout(function() {
          photoMenu.style.opacity = '1';
          photoMenu.style.transform = 'translateY(0)';
        }, 10);
      } else {
        photoMenu.style.opacity = '0';
        photoMenu.style.transform = 'translateY(-20px)';
        setTimeout(function() {
          photoMenu.style.display = 'none';
        }, 500);
      }
    });

    document.getElementById('settingsToggle').addEventListener('click', function(event) {
      event.preventDefault();
      var settingsMenu = document.getElementById('settingsMenu');
      if (settingsMenu.style.display === 'none' || settingsMenu.style.display === '') {
        settingsMenu.style.display = 'block';
        setTimeout(function() {
          settingsMenu.style.opacity = '1';
          settingsMenu.style.transform = 'translateY(0)';
        }, 10);
      } else {
        settingsMenu.style.opacity = '0';
        settingsMenu.style.transform = 'translateY(-20px)';
        setTimeout(function() {
          settingsMenu.style.display = 'none';
        }, 500);
      }
    });

    document.getElementById('mainToggle').addEventListener('click', function(event) {
      event.preventDefault();
      var mainMenu = document.getElementById('mainMenu');
      if (mainMenu.style.display === 'none' || mainMenu.style.display === '') {
        mainMenu.style.display = 'block';
        setTimeout(function() {
          mainMenu.style.opacity = '1';
          mainMenu.style.transform = 'translateY(0)';
        }, 10);
      } else {
        mainMenu.style.opacity = '0';
        mainMenu.style.transform = 'translateY(-20px)';
        setTimeout(function() {
          mainMenu.style.display = 'none';
        }, 500);
      }
    });
  </script>
</body>
</html>
