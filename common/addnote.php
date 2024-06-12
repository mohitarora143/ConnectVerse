<?php
session_start();
include('../common/databaseconn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $note_title = $_POST['note_title'];
    $note_content = $_POST['notes'];

    // Check if a note with the same username, date, and title already exists
    $date = date('Y-m-d'); // Current date
    $check_sql = "SELECT * FROM `note` WHERE `username` = '$username' AND `note_title` = '$note_title' AND DATE(`note_date`) = '$date'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Note with the same username, title, and date exists
        echo "<script>
                alert('A note with the same title already exists for today!');
                setTimeout(function() {
                    window.location.href = '../functions/post.php';
                }, 2000);
              </script>";
    } else {
        // SQL query to insert the note into the database
        $sql = "INSERT INTO `note`(`username`, `note_title`, `email`, `notes`, `note_date`) VALUES ('$username', '$note_title', '$email', '$note_content', NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Note entered successfully!');
                    setTimeout(function() {
                        window.location.href = '../functions/post.php';
                    }, 2000);
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh;">

<div style="position: relative; width: 400px; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0px 10px 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 5px 15px rgba(0, 0, 0, 0.1)';">
<button class="close-btn" style="position: absolute; top: 10px; right: 10px; background-color: #ff5f5f; border: none; border-radius: 50%; color: #fff; width: 25px; height: 25px; cursor: pointer; font-size: 18px; line-height: 25px; text-align: center; transition: background-color 0.3s;" onclick="goBack()">&times;</button>
<h1 style="text-align: center; margin-bottom: 20px; color: #333; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">Add a Note</h1>
    <form action="./addnote.php" method="post">
        <input type="text" name="note_title" placeholder="Note Title" style="width: calc(100% - 40px); padding: 10px; margin-bottom: 10px; border: 2px solid #ccc; border-radius: 5px; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='#2196f3';" onblur="this.style.borderColor='#ccc';"required>
        <textarea name="notes" rows="6" placeholder="Note Content" style="width: calc(100% - 40px); padding: 10px; margin-bottom: 20px; border: 2px solid #ccc; border-radius: 5px; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='#2196f3';" onblur="this.style.borderColor='#ccc';"required></textarea>
        <button type="submit" style="padding: 10px 20px; background-color: #2196f3; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; margin-top: 10px;" onmouseover="this.style.backgroundColor='#0d8ae8';" onmouseout="this.style.backgroundColor='#2196f3';">Add Note</button>
    </form>
</div>
   <script>
function goBack() {
    document.body.style.transition = 'opacity 0.5s';
    document.body.style.opacity = '0';
    setTimeout(() => {
        window.history.back();
    }, 500);
}

</script>

</body>
</html>
