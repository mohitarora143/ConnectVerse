<?php
session_start();
include('../common/databaseconn.php');

// Enable detailed error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get session variables
    if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
        $username = $_SESSION['username']; 
        $email = $_SESSION['email'];
    } else {
        die("Session variables not set.");
    }

    // Debugging: Output session variables
    echo "Username: $username, Email: $email<br>";
    
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    // Debugging: Output the form data
    echo "Title: $title, Description: $description, Due Date: $due_date, Priority: $priority<br>";

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tasks (username, email, title, description, due_date, priority) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $username, $email, $title, $description, $due_date, $priority);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully.<br>";
        // Redirect or display success message
        header("Location: taskmanager.php");
        exit();
    } else {
        echo "Execute failed: " . $stmt->error . "<br>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

    <div class="modal" id="addTaskModal" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
        <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); position: relative; max-width: 500px; width: 100%;">
            <span class="close" onclick="window.location.href='taskmanager.php';" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;">&times;</span>
            <h2 style="margin-bottom: 20px;">Add Task</h2>
            <form id="taskForm" action="task.php" method="POST" style="display: flex; flex-direction: column;">
                <label for="taskTitle" style="margin-bottom: 10px;">Title:</label>
                <input type="text" id="taskTitle" name="title" required style="margin-bottom: 10px; padding: 10px;">
                
                <label for="taskDesc" style="margin-bottom: 10px;">Description:</label>
                <textarea id="taskDesc" name="description" required style="margin-bottom: 10px; padding: 10px;"></textarea>
                
                <label for="taskDate" style="margin-bottom: 10px;">Due Date:</label>
                <input type="date" id="taskDate" name="due_date" required style="margin-bottom: 10px; padding: 10px;">
                
                <label for="taskPriority" style="margin-bottom: 10px;">Priority:</label>
                <select id="taskPriority" name="priority" style="margin-bottom: 20px; padding: 10px;">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                
                <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add Task</button>
            </form>
        </div>
    </div>
    <script src="../js/script.js'></script>
</body>
</html>
