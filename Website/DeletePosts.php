<?php
/**
 * Created by PhpStorm.
 * User: Yaniv
 * Date: 8/21/2018
 * Time: 3:14 PM
 */
$servername = "localhost";
$username = "root";
$password = "Bigf00t!@#";
$db_name = 'challenge';

// Create connection
$mysqli = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$sql = "DELETE FROM comments;";

$sql .= "INSERT INTO comments (username, comment, article_id) VALUES";
$sql .= "('User12', 'Wow!! Amazing Article!!', '1'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '2'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '3'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '4');";
if (!$mysqli->multi_query($sql)) {
    echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
