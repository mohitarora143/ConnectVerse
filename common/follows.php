<?php

include 'databaseconn.php'; // Include the database connection

$username = $_SESSION['username'];
$searchedusername=$_SESSION['clicked_username'];
$a = 1;
$stmt = $conn->prepare("
    SELECT COUNT(*) as friend_count 
    FROM following 
    WHERE (username = ? OR friends = ?) AND aceepted = ?
");
$stmt->bind_param("ssi", $searchedusername, $searchedusername, $a);
$stmt->execute();
$stmt->bind_result($friend_count);
$stmt->fetch();
$stmt->close();


$stmts = $conn->prepare("
    SELECT COUNT(*) as friend_count 
    FROM following 
    WHERE (username = ? OR friends = ?) AND aceepted = ?
");
$stmts->bind_param("ssi", $username, $username, $a);
$stmts->execute();
$stmts->bind_result($friend_counts);
$stmts->fetch();
$stmts->close();

$stmts = $conn->prepare("
    SELECT COUNT(*) as friend_count 
    FROM following 
    WHERE (username = ? OR friends = ?) AND aceepted = ? AND follow_back =?
");
$stmts->bind_param("ssii", $username, $username, $a,$a);
$stmts->execute();
$stmts->bind_result($friend_countss);
$stmts->fetch();
$stmts->close();

$stmts = $conn->prepare("
    SELECT COUNT(*) as close_friends 
    FROM following 
    WHERE (username = ? OR friends = ?) AND aceepted = ? AND follow_back =?     AND close_friend =?
");
$stmts->bind_param("ssiii", $username, $username, $a,$a,$a);
$stmts->execute();
$stmts->bind_result($closefriends);
$stmts->fetch();
$stmts->close();


$stmts = $conn->prepare("
    SELECT COUNT(*) as blog_posts 
    FROM blog_posts 
    WHERE username = ? 
");
$stmts->bind_param("s", $username);
$stmts->execute();
$stmts->bind_result($blogposts);
$stmts->fetch();
$stmts->close();
?>
