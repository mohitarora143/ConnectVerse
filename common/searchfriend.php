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