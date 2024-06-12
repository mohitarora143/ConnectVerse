<?php
session_start();
include '../common/databaseconn.php'; // Include the database connection

// Fetch the username stored in the session
$searchusername = isset($_SESSION['clicked_username']) ? $_SESSION['clicked_username'] : 'No username set';
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Fetch the profile image path
$stmt = $conn->prepare("SELECT images FROM registration WHERE username = ?");
$stmt->bind_param("s", $searchusername);
$stmt->execute();
$stmt->bind_result($imagePath);
$stmt->fetch();
$stmt->close();

$total_posts = 0;

if (!empty($username)) {
    // SQL query to count total number of posts for the specific username
    $sql = "SELECT COUNT(post_id) AS total_posts FROM post WHERE username = '$searchusername'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_posts = $row['total_posts'];
    } else {
        // Handle error if the query fails
        echo "Error: " . mysqli_error($conn);
    }
}
include '../common/videouploading.php';

// Check if the user is friends and accepted
$a = 1;
$stmts = $conn->prepare("SELECT username, friends, aceepted FROM following WHERE username = ? AND friends = ?  AND aceepted = ? ");
$stmts->bind_param("sss", $username, $searchusername, $a);
$stmts->execute();
$stmts->store_result();
$isFriend = $stmts->num_rows > 0;
$stmts->close();

$a = 1;
$stmts = $conn->prepare("SELECT username, friends, aceepted FROM following WHERE username = ? AND friends = ?  AND aceepted = ? ");
$stmts->bind_param("sss", $searchusername, $username, $a);
$stmts->execute();
$stmts->store_result();
$isFriends = $stmts->num_rows > 0;
$stmts->close();



// Check if a friend request has been sent
$a = 0;
$stmts = $conn->prepare("SELECT username, friends, aceepted FROM following WHERE username = ? AND friends = ?  AND aceepted = ? ");
$stmts->bind_param("sss", $username, $searchusername, $a);
$stmts->execute();
$stmts->store_result();
$request = $stmts->num_rows > 0;
$stmts->close();

$a = 0;
$stmts = $conn->prepare("SELECT username, friends, aceepted FROM following WHERE username = ? AND friends = ?  AND aceepted = ? ");
$stmts->bind_param("sss", $searchusername, $username, $a);
$stmts->execute();
$stmts->store_result();
$requested = $stmts->num_rows > 0;
$stmts->close();
// Close the database connection
mysqli_close($conn);


include('../common/follows.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnectVerse - Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body style="font-family: 'Arial', sans-serif; background: linear-gradient(to right, #ffecd2, #fcb69f); margin: 0; padding: 0;">

    <?php include '../common/topnavbar.php'; ?>

    <div class="profile-container" style="display: flex; justify-content: center; align-items: center; margin-top: 50px;">
        <div class="profile-item" style="display: flex; align-items: center; background: rgba(255, 255, 255, 0.8); padding: 20px;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 800px; width: 100%; margin-bottom: 20px; border: 2px solid #ccc; border-image: linear-gradient(45deg, #6a11cb, #2575fc) 1; border-width: 4px; border-style: solid; border-radius: 12px">
            <div class="profile-image" style="flex: 1; text-align: center;">
                <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px; outline: 5px dotted #f4c7ab; box-shadow: 0 0 0 5px #c1c8e4;">
                <div class="profile-username">
                    <p style="font-size: 1.5em; color: #333;"><strong>@<?php echo htmlspecialchars($searchusername); ?></strong></p>
                </div>
            </div>
            <div class="profile-details" style="flex: 2; display: flex; flex-wrap: wrap; justify-content: flex-start; align-items: center;">
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #c1c8e4; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Total Posts 📝</strong></p>
                    <p style="font-size: 1.2em; color: #333;"><?php echo $total_posts; ?></p>
                </div>
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #f4c7ab; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Connected 👥</strong></p>
                    <p style="font-size: 1.2em; color: #333;"><?php echo $friend_count; ?></p>
                </div>
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #c1c8e4; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Mutual Friends 👯‍♂️</strong></p>
                    <p style="font-size: 1.5em; color: #333;">0</p>
                </div>
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #f4c7ab; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Community Joined 🌐</strong></p>
                </div>
                <?php if ($isFriend || $isFriends): ?>
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #c1c8e4; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Recent Posts 🕒</strong></p>
                </div>
                <div class="profile-stat" style="text-align: center; padding: 10px; background: #f4c7ab; border-radius: 15px; margin: 10px; min-width: 150px; box-shadow: inset 0 0 10px #fff; flex: 1;">
                    <p style="font-size: 1.2em; color: #333;"><strong>Message ✉️</strong></p>
                </div>
                <?php else: ?>
                <?php if ($requested || $request): ?>
                    <p style="font-size: 1.2em; color: #333;"><strong>Friend Request Sent 👋</strong></p>
                    <button id="friendRequestSent" class="btn btn-primary" style="background-color: gray; cursor: not-allowed; flex: 1;" disabled>Friend Request Sent</button>
                <?php else: ?>
                    <button id="sendFriendRequest" class="btn btn-primary" style="flex: 1;">Send Friend Request</button>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../common/footer.php'; ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    let sendFriendRequestBtn = document.querySelector('#sendFriendRequest');
    let friendRequestSentBtn = document.querySelector('#friendRequestSent');

    if (sendFriendRequestBtn) {
        sendFriendRequestBtn.addEventListener('click', function() {
            console.log("Send Friend Request button clicked"); // Debug log

            fetch('../shorts/sentfriendrequest.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: "sentfriendrequest" })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response received: ", data); // Debug log
                if (data.success) {
                    console.log("Friend request sent successfully."); // Debug log
                    // Disable the button and change text if request sent successfully
                    sendFriendRequestBtn.innerText = 'Friend Request Sent';
                    sendFriendRequestBtn.style.backgroundColor = 'gray';
                    sendFriendRequestBtn.disabled = true;
                } else {
                    console.error("Error:", data.error);
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
        });
    }
});

    </script>
</body>
</html>
