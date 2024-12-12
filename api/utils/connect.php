<?php

include_once "variables.php";

    $hostname = "localhost";
    $server_user = "root";
    $server_password = "";

    $conn = new mysqli($hostname, $server_user, $server_password, $database_name);

?>