<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');

// Get the selected username from the URL
$selected_username = isset($_GET['username']) ? $_GET['username'] : '';
function time_left($created_at) {
    $current_time = new DateTime();
    $created_time = new DateTime($created_at);
    $interval = $current_time->diff($created_time);
    $hours_left = 24 - $interval->h - ($interval->days * 24);
    $minutes_left = 60 - $interval->i;
    $seconds_left = 60 - $interval->s;

    if ($hours_left <= 0 && $minutes_left <= 0 && $seconds_left <= 0) {
        return "Expired";
    }

    return $hours_left . " hours " . $minutes_left . " minutes " . $seconds_left . " seconds";
}

// Delete expired stories from the database
$delete_expired_sql = "DELETE FROM story WHERE TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24";
$conn->query($delete_expired_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selected_username) ?>'s Stories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            background-color: #f0f0f0;
            position: relative;
        }
        .stories-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 90%;
            max-width: 1000px;
            padding: 20px;
            text-align: center;
            border: 2px solid #000;
            border-radius: 10px;
            background: linear-gradient(135deg, #f3ec78, #af4261);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
            opacity: 0;
            transition: opacity 0.5s;
        }
        .stories-container.show {
            opacity: 1;
        }
        .story {
            margin: 10px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            min-width: 200px;
            max-width: 250px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
            transition: transform 0.5s, box-shadow 0.5s;
        }
        .story:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 1);
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff4444;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s, transform 0.3s;
        }
        .close-button:hover {
            background-color: #ff0000;
            transform: scale(1.1);
        }
        .story img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Close Button -->
    <button class="close-button" onclick="history.back();">&times;</button>

    <!-- Container for Stories -->
    <div class="stories-container">
        <h1 style="margin-bottom: 20px; color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);"><strong><?= htmlspecialchars($selected_username) ?>'s Stories</strong></h1>
        <div style="display: flex; flex-wrap: nowrap; overflow-x: auto; height:350px;">
            <?php
            $stories_sql = "SELECT * FROM story WHERE username = ? ORDER BY created_at DESC";
            if ($stmt = $conn->prepare($stories_sql)) {
                $stmt->bind_param("s", $selected_username);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $time_left = time_left($row['created_at']);
                        echo '<div class="story">';
                        echo '<div style="font-weight: bold; margin-bottom: 10px; color: #333;">' . htmlspecialchars($row['caption']) . '</div>';
                        echo '<img src="../Images/' . htmlspecialchars($row['addstory']) . '" alt="Story Image" style="max-width: 50%; height: auto; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">';
                        echo '<div style="color: #666; font-size: 12px;">Expires in: ' . $time_left . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "Error executing the statement: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../common/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.stories-container').classList.add('show');
        });
    </script>

</body>
</html>
