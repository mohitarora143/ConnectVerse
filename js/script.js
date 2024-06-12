document.addEventListener('DOMContentLoaded', function() {
    let clicking = document.querySelector('.add-task-btn');
    if (clicking) {
        clicking.addEventListener('click', function() {
            window.location.href = 'task.php';
        });
    } else {
        console.error('Add Task button not found.');
    }

    let complete = document.querySelector('.complete-btn');
    complete.addEventListener('click', function() {
        $.ajax({
            type: "POST",
            url: "../shorts/completed.php",
            data: { action: "completed" }, // Send any necessary data
            dataType: "json",
            success: function(response) {
                // Handle the response from PHP
                console.log("Response from PHP:", response);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("Error:", error);
            }
        });
    })
    let deletes = document.querySelector('.cancel-btn');
    deletes.addEventListener('click', function() {
        $.ajax({
            type: "POST",
            url: "../shorts/deleted.php",
            data: { action: "deleted" }, // Send any necessary data
            dataType: "json",
            success: function(response) {
                // Handle the response from PHP
                console.log("Response from PHP:", response);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("Error:", error);
            }
        });
    });


});



