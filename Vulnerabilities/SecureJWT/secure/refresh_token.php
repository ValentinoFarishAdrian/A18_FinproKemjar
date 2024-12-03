<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_COOKIE['refreshToken'])) {
        $refreshToken = $_COOKIE['refreshToken'];

        try {
            $publicKey = file_get_contents(PUBLIC_KEY_PATH);
            $decoded = JWT::decode($refreshToken, new Key($publicKey, 'RS256'));

            // Generate Access Token baru
            $issuedAt = time();
            $newAccessExpiration = $issuedAt + TOKEN_EXPIRATION;

            $newAccessPayload = [
                "iat" => $issuedAt,
                "exp" => $newAccessExpiration,
                "username" => $decoded->username
            ];

            $privateKey = file_get_contents(PRIVATE_KEY_PATH);
            $newAccessToken = JWT::encode($newAccessPayload, $privateKey, 'RS256');

            // Set Access Token baru di cookie
            setcookie("jwt", $newAccessToken, $newAccessExpiration, "/", "", true, true);

            echo json_encode([
                "success" => true,
                "message" => "Access token refreshed successfully.",
                "accessToken" => $newAccessToken
            ]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Invalid refresh token."
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Refresh token not found."
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed."
    ]);
}
?>
