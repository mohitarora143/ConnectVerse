
<?php
include('../common/databaseconn.php');
session_start();
$username = $_SESSION['username'];

function completed($conn, $username) {
    $sqls = "SELECT task_id FROM tasks WHERE username = '$username'";
    $results = mysqli_query($conn, $sqls);

    if ($results) {
        while ($row = mysqli_fetch_assoc($results)) {
            $tasks_id = $row['task_id'];
        }

        $sql = "UPDATE `tasks` SET `complete`='1' WHERE username ='$username' and task_id='$tasks_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            return json_encode(["success" => "Task completed successfully"]);
        } else {
            return json_encode(["error" => "Failed to update task"]);
        }
    } else {
        return json_encode(["error" => mysqli_error($conn)]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "completed") {
    $result = completed($conn, $username);
    echo $result;
}
?>
