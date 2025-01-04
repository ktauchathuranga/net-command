<?php
require_once "../database.php";
require_once "jwt_helper.php"; // Include JWT helper functions

header('Content-Type: application/json');

$secretKey = 'YOUR_SECRET_KEY'; // Replace with your actual secret key

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

// Function to get the Authorization token from headers
function getAuthorizationHeader() {
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { // For Apache server
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

// Function to validate JWT token
function validateToken($jwt, $secretKey) {
    $decoded = decodeJWT($jwt, $secretKey);
    if ($decoded) {
        return $decoded;
    }
    return null;
}

$authHeader = getAuthorizationHeader();
if ($authHeader) {
    list($type, $jwt) = explode(" ", $authHeader, 2);

    if ($type === "Bearer" && $jwt) {
        $userPayload = validateToken($jwt, $secretKey);

        if ($userPayload) {
            // Proceed with the API logic
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
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid or expired token"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Authorization header"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Authorization header missing"]);
}
?>
