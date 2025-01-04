<?php
require_once "../database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Check if username already exists
        $sqlCheck = "SELECT * FROM users WHERE username = ?";
        $stmtCheck = mysqli_prepare($conn, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "s", $username);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            echo json_encode(["message" => "Username already taken"]);
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sqlInsert = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmtInsert = mysqli_prepare($conn, $sqlInsert);
            mysqli_stmt_bind_param($stmtInsert, "ss", $username, $hashedPassword);

            if (mysqli_stmt_execute($stmtInsert)) {
                echo json_encode(["message" => "User registered successfully"]);
            } else {
                echo json_encode(["message" => "Error registering user"]);
            }
        }
    } else {
        echo json_encode(["message" => "Username and password required"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
