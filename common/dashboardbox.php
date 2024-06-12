<!-- Main Content Container -->
<div style="flex: 1; display: flex; justify-content: center; align-items: center; margin: 20px; padding: 20px;">
    <div class="animated" style="display: flex; align-items: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); max-width: 1200px; width: 80%; margin: auto;">
        <!-- Profile Picture and Username -->
        <div style="margin-right: 20px; display: flex; align-items: center; justify-content: center;">
            <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); margin-left: 30px;">
            <div style="text-align: center;">
                <p style="font-size: 20px; margin-top: 10px;"><strong>@<?php echo htmlspecialchars($username); ?></strong></p>
                <p style="font-size: 16px; margin-top: 5px;"><strong><?php echo $bio ?></strong></p>
            </div>
        </div>

        <!-- Right side items -->
        <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
            <!-- First row: 3 items -->
            <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 20px;">
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Total Posts </p>
                    <p style="font-size: 16px;"><strong><?php echo $total_posts; ?></strong></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Today's Scheduled Tasks </p>
                    <p style="font-size: 16px;"><strong><?php echo $total_posts; ?></strong></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Total Blogs </p>
                    <p style="font-size: 16px;"><strong><?php echo $blogposts; ?></strong></p>
                </div>
            </div>
            <!-- Second row: 2 items centered -->
            <div style="display: flex; justify-content: center; width: 100%; margin-bottom: 20px;">
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 40%; margin-right: 20px; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Connected Ones </p>
                    <p style="font-size: 16px;"><strong><?php echo $friend_counts; ?></strong></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 40%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Close Friends </p>
                    <p style="font-size: 16px;"><strong><?php echo $closefriends; ?></strong></p>
                </div>
            </div>
            <!-- Third row: 3 items -->
            <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 20px;">
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Edit Profile <a href="editprofile.php" style="text-decoration: none;">✏️</a></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Task Manager <a href="taskmanager.php"style="text-decoration: none;">📋</a></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10
px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 30%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">All Posts<a href="../functions/addfriends.php"style="text-decoration: none;">🖼️</a></p>
                </div>
            </div>
            <!-- Fourth row: 2 items centered -->
            <div style="display: flex; justify-content: center; width: 100%;">
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 40%; margin-right: 20px; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Total Post Videos<a href=""style="text-decoration: none;">🎥</a></p>
                </div>
                <div class="hover-effect" style="text-align: center; padding: 20px; background: linear-gradient(45deg, #c0c0c0, #f5f5f5); border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); flex-basis: 40%; transition: box-shadow 0.3s;">
                    <p style="font-size: 16px; font-weight: bold;">Total Post Images<a href=""style="text-decoration: none;">🖼️</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
