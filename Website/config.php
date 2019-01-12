<?php

$servername = "localhost";
$username = "admin";
$password = "p@ssw0rd";
$db_name = 'challenge';

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
