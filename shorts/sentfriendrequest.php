<?php
include('../common/databaseconn.php');
session_start();

$username = $_SESSION['username'];
$searchedusername = $_SESSION['clicked_username'];

function sentfriendrequest($conn, $username, $searchedusername) {
    // Check if the combination of usernames already exists
    $sql_check = "SELECT * FROM following WHERE username = ? AND friends = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $searchedusername);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    // If the combination already exists, return an error message
    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        return json_encode(["error" => "Friend request already sent or pending"]);
    } else {
        $stmt_check->close();
        // If the combination doesn't exist, proceed to send the friend request
        $sql_insert = "INSERT INTO `following`(`username`, `friends`, `aceepted`) VALUES (?, ?, 0)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $username, $searchedusername);
        if ($stmt_insert->execute()) {
            $stmt_insert->close();
            return json_encode(["success" => "Friend request sent successfully"]);
        } else {
            $stmt_insert->close();
            return json_encode(["error" => "Failed to send friend request"]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    if (isset($input["action"]) && $input["action"] == "sentfriendrequest") {
        $result = sentfriendrequest($conn, $username, $searchedusername);
        echo $result;
    }
}
?>
