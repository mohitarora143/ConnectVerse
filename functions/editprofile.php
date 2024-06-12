<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

include('../common/fetchingall.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newBio = $_POST['bio'];
    $newEmail = $_POST['email'];
    $newCountry = $_POST['location'];

    // Update user data in the registration table
    $updateQuery = "UPDATE registration SET username = ?, bio = ?, email = ?, country = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssss", $newUsername, $newBio, $newEmail, $newCountry, $username);

    if ($updateStmt->execute()) {
        // Update session variables
        $_SESSION['username'] = $newUsername;
        $_SESSION['email'] = $newEmail;

        // Update the current username variable
        $username = $newUsername;
        $email = $newEmail;
        $bio = $newBio;
        $country = $newCountry;

        // Provide feedback to the user
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }

    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Edit Profile</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
    <?php include('../common/topnavbar.php');?>

    <div class="mains" style="max-width: 1200px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 20px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); display: flex; flex-wrap: wrap; position: relative;">
        <!-- Cross button -->
        <div id="crossButton" style="position: absolute; top: 20px; right: 20px; cursor: pointer; font-size: 24px; color: #007bff;">✖</div>

        <div style="flex: 1; margin-right: 20px; text-align: center;">
            <div style="width: 200px; height: 200px; border-radius: 50%; margin-top:40%; margin-bottom: 20px; margin-left: 40px ; border: 4px solid #007bff; overflow: hidden; position: relative; background: linear-gradient(to bottom, #007bff, #1c8ef9);">
                <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <button style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(to bottom, #007bff, #1c8ef9);" class="edit-profile-btn">Change Profile Picture</button>
        </div>

        <div style="flex: 3;">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="padding: 20px; background-color: #f4f4f4; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(to right, #e6e6e6, #f4f4f4);" class="profile-form">
                <label style="font-weight: bold; color: #333;" for="username">Username:</label>
                <input style="width: calc(100% - 20px); padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; background-color: #fff;" type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                
                <label style="font-weight: bold; color: #333;" for="bio">Bio:</label>
                <textarea style="width: calc(100% - 20px); padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; height: 100px; background-color: #fff;" id="bio" name="bio"><?php echo htmlspecialchars($bio); ?></textarea>
                
                <label style="font-weight: bold; color: #333;" for="email">Email:</label>
                <input style="width: calc(100% - 20px); padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; background-color: #fff;" type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                
                <label style="font-weight: bold; color: #333;" for="location">Location:</label>
                <input style="width: calc(100% - 20px); padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; background-color: #fff;" type="text" id="location" name="location" value="<?php echo htmlspecialchars($country); ?>">
                
                <button style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(to bottom, #28a745, #218838);" class="save-btn">Save Changes</button>
            </form>
        </div>

    </div>
    <?php include('../common/footer.php'); ?>

    <script>
        document.getElementById('crossButton').addEventListener('click', function() {
            document.body.style.transition = 'opacity 0.5s';
            document.body.style.opacity = '0';
            setTimeout(function() {
                window.history.back();
            }, 500);
        });
    </script>
</body>
</html>
