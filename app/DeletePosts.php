<?php

include("config.php");
$sql = "DELETE FROM comments;";

$sql .= "INSERT INTO comments (username, comment, article_id) VALUES";
$sql .= "('User12', 'Wow!! Amazing Article!!', '1'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '2'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '3'),";
$sql .= "('User12', 'Wow!! Amazing Article!!', '4');";

if (!$conn->multi_query($sql)) {
    echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
