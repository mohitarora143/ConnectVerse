<?php
session_start();
include('databaseconn.php');
include('topnavbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="task-manager">
        <header class="header">
            <h1>Task Manager</h1>
            <button class="add-task-btn">Add Task</button>
        </header>
        
        <section class="task-list" id="taskList">
            <!-- Task items will be loaded here by JavaScript -->
        </section>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
<?php include('footer.php'); ?>