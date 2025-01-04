<?php

function encodeJWT($payload, $secretKey) {
    $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
    $payload = json_encode($payload);

    $base64UrlHeader = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
    $base64UrlPayload = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');

    $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secretKey, true);
    $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

    return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
}

function decodeJWT($jwt, $secretKey) {
    list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $jwt);

    $header = json_decode(base64_decode(strtr($base64UrlHeader, '-_', '+/')), true);
    $payload = json_decode(base64_decode(strtr($base64UrlPayload, '-_', '+/')), true);

    $recreatedSignature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secretKey, true);
    $recreatedBase64UrlSignature = rtrim(strtr(base64_encode($recreatedSignature), '+/', '-_'), '=');

    if ($recreatedBase64UrlSignature !== $base64UrlSignature) {
        return null; // Invalid signature
    }

    if (isset($payload['exp']) && $payload['exp'] < time()) {
        return null; // Token expired
    }

    return $payload;
}
?>
