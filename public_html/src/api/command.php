<?php
    require_once "../database.php";

    if (isset($_POST["readstate"])) {
        $readWhere = $_POST["readstate"];
        $sql = "SELECT * FROM toggle_state WHERE id = $readWhere";
        $results = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($results);

        if ($row["status"] == 1) {
            echo "#1";
        } elseif ($row["status"] == 0) {
            echo "#0";
        } else {
            echo "#error";
        }
    }

    if (isset($_POST["writestate"])) {
        $writeWhere = $_POST["writestate"];
        $sql = "SELECT * FROM toggle_state WHERE id = $writeWhere";
        $results = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($results);

        if ($row["status"] == 1) {
            $write = mysqli_query($conn, "UPDATE toggle_state SET `status` = 0 WHERE `id` = $writeWhere");
            echo "#0";
        } elseif ($row["status"] == 0) {
            $write = mysqli_query($conn, "UPDATE toggle_state SET `status` = 1 WHERE `id` = $writeWhere");
            echo "#1";
        } else {
            echo "#error";
        }
    }

?>