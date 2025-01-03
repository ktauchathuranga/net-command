<?php

    $dbHost = "localhost";
    $dbUser = "id20929160_netcommand";
    $dbPass = "Netcommand@123";
    $dbName = "id20929160_netcommanddb";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if (!$conn) {
        die("Database Connection Failed!");
    }

?>