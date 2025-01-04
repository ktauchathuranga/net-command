<?php
    require_once ".../database.php";

    header('Content-Type: application/json');

    function getToggleState($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM toggle_state WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function updateToggleState($conn, $id, $status) {
        $stmt = $conn->prepare("UPDATE toggle_state SET `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = ["status" => "error", "message" => "Invalid request"];

        if (isset($_POST["readstate"])) {
            $id = intval($_POST["readstate"]);
            $row = getToggleState($conn, $id);

            if ($row) {
                $response = ["status" => "success", "state" => $row["status"]];
            } else {
                $response = ["status" => "error", "message" => "ID not found"];
            }
        } elseif (isset($_POST["writestate"])) {
            $id = intval($_POST["writestate"]);
            $row = getToggleState($conn, $id);

            if ($row) {
                $newStatus = $row["status"] == 1 ? 0 : 1;
                if (updateToggleState($conn, $id, $newStatus)) {
                    $response = ["status" => "success", "new_state" => $newStatus];
                } else {
                    $response = ["status" => "error", "message" => "Update failed"];
                }
            } else {
                $response = ["status" => "error", "message" => "ID not found"];
            }
        }

        echo json_encode($response);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid HTTP method"]);
    }
?>
