<?php
session_start();
include('../common/databaseconn.php');

include('../common/profileupload.php');
$tasks = array();

if (!empty($username)) {
    // SQL query to select all tasks for the specific username and sort them by due date and priority
    $sql = "SELECT description, title, due_date, priority FROM tasks WHERE username = '$username' ORDER BY due_date, priority";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch all rows as associative array
        while ($row = mysqli_fetch_assoc($result)) {
            // Add each task to the $tasks array
            $tasks[] = $row;
        }
    } else {
        // Handle error if the query fails
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../css/main.css">
    
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <header class="welcome-section">
                <div class="welcome-text">
                    <h1>Welcome to Connect Verse</h1>
                    <p>Explore, Create, and Connect Like Never Before</p>
                </div>
                <div class="user-info">
                    <div class="user-details">
                        <!--<p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>-->
                    </div>
                    <div class="user-dp" id="images1">
                        <img src="../Images/<?php echo htmlspecialchars($imagePath); ?>" alt="User Profile Picture">
                    </div>
                </div>
            </header>
        </div>
    </div>
</nav>

<div class="task-manager" style="max-width: 800px; margin: 150px auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); border: 4px solid rgba(204, 204, 204, 0.5); border-image: linear-gradient(to right, #ffcccc, #ccffcc, #ccccff); border-image-slice: 1; position: relative;">
    <header class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 24px; color: #333;">Task Scheduler</h1>
        <button class="add-task-btn" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);">Add Task</button>
    </header>
    
    <section class="task-list" id="taskList" style="border: 1px solid rgba(204, 204, 204, 0.9); border-radius: 5px; padding: 20px; background-color: #fff;">
        <!-- Loop through tasks and display each task item -->
        <?php foreach ($tasks as $task): ?>
            <div class="task-item" style="margin-bottom: 10px; padding: 20px; border: 2px groove black; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="task-details">
                    <h3 style="margin: 0; font-size: 18px;"><strong><?php echo $task['title']; ?></strong></h3>
                    <p style="margin: 4px ;"><strong><?php echo $task['description']; ?></strong></p>
                    <p style="margin: 5px 0;"><strong><?php $due_date= $task['due_date'];
                     $timestamp = $due_date;
                     $date_parts = explode(" ", $timestamp); // Split timestamp into date and time parts
                     $datess = $date_parts[0]; // Extract the date part
                     echo $datess; ?></strong></p>
                </div>
                <div class="task-actions" style="display:flex;">
                    <!-- Complete Button -->
                    <button class="complete-btn" style="padding: 8px 16px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px;">Complete</button>
                    <!-- Cancel Button -->
                    <button class="cancel-btn" style="padding: 8px 16px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px;">Cancel</button>
                    <!-- Edit Button -->
                    <button class="edit-btn" style="padding: 8px 16px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Edit</button>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../js/script.js">
// JavaScript code to handle task completion and removal
document.addEventListener('DOMContentLoaded', function () {
    const taskList = document.getElementById('taskList');

    // Add event listener to the task list
    taskList.addEventListener('click', function (event) {
        const target = event.target;
        // Check if the clicked element is a task checkbox
        if (target.classList.contains('task-checkbox')) {
            const taskId = target.getAttribute('data-task-id');
            // Send an AJAX request to mark the task as complete
            fetch('complete_task.php', {
                method: 'POST',
                body: JSON.stringify({ taskId: taskId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the task from the DOM
                    target.closest('.task-item').remove();
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>
</body>
</html>
<?php include('../common/footer.php'); ?>
