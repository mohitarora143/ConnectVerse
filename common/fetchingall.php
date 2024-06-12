<?php

$query = "SELECT bio, country ,states FROM registration WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($bio, $country,$state);
$stmt->fetch();
$stmt->close();

?>