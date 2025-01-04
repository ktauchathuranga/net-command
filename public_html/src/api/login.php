<?php
require_once "../database.php";
require_once "jwt_helper.php";

$secretKey = 'YOUR_SECRET_KEY'; // Change this to a secure, random string

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token valid for 1 hour
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'username' => $user['username']
        ];

        $jwt = encodeJWT($payload, $secretKey);

        echo json_encode(['jwt' => $jwt]);
    } else {
        echo json_encode(['message' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['message' => 'Username and password required']);
}
?>
