<?php
include('../common/databaseconn.php');
session_start();
$username = $_SESSION['username'];

function completeTask($conn, $username, $taskId) {
    $sql = "UPDATE tasks SET complete = 1 WHERE username = ? AND task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $taskId);
    if ($stmt->execute()) {
        return json_encode(["success" => "Task completed successfully"]);
    } else {
        return json_encode(["error" => "Failed to update task"]);
    }
}

// Check if the request method is POST and action is completed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskId"])) {
    $taskId = $_POST["taskId"];
    $result = completeTask($conn, $username, $taskId);
    echo $result;
}
?>
