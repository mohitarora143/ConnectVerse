

<?php $username = $_SESSION['username']; ?>
<nav class="custom-navbar navbar navbar-expand-lg fixed-top" style="background-color: #ffffff; border-bottom: 1px solid #000000; padding: 20px;">
  <div class="container-fluid">
    <a class="custom-navbar-brand ms-3" href="#" style="color: #000 !important; text-decoration: none; font-size: 20px;">
      <div class="user-details" style="margin-left: 20px;">
        <p><strong><?php echo htmlspecialchars($username); ?></strong></p>
      </div>
    </a>
    <!-- Community Page Link -->
    <a class="custom-navbar-brand ms-3" href="community.php" style="color: #000 !important; text-decoration: none; font-size: 20px;">
      🌐
    </a>
    <!-- Post Image/Reel Link -->
    <a class="custom-navbar-brand ms-3" href="post.php" style="color: #000 !important; text-decoration: none; font-size: 20px;">
      📸
    </a>
    <!-- Settings -->
    <div class="ms-auto" style="margin-left: auto !important;">
      <a class="custom-navbar-brand" href="settings.php" style="color: #000 !important; text-decoration: none; font-size: 20px;">
        ⚙️
      </a>
    </div>
  </div>
</nav>
