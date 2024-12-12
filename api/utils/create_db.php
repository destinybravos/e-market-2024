<?php

include_once "variables.php";

$hostname = "localhost";
$server_user = "root";
$server_password = "";

$conn = new mysqli($hostname, $server_user, $server_password);

$sqlStatement = "CREATE DATABASE IF NOT EXISTS $database_name";

$createDb = $conn->query($sqlStatement);

echo "Database Created Successfully <br>";
