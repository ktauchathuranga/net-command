<?php
    $dbHost = "db"; // Service name in docker-compose
    $dbUser = "netuser";
    $dbPass = "netpassword";
    $dbName = "netcommand";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if (!$conn) {
        die("Database Connection Failed!");
    }
?>
