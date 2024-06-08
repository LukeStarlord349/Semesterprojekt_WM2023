<?php
require_once ('config.php'); //to retrieve connection details


$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);
echo "<pre>" . print_r($result->fetch_array(), true) . "</pre>";