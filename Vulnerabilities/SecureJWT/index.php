<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function regenerateAccessToken($refreshToken) {
    try {
        $publicKey = file_get_contents(PUBLIC_KEY_PATH);
        $decoded = JWT::decode($refreshToken, new Key($publicKey, 'RS256'));

        // Buat Access Token baru
        $issuedAt = time();
        $newAccessExpiration = $issuedAt + TOKEN_EXPIRATION;

        $newAccessPayload = [
            "iat" => $issuedAt,
            "exp" => $newAccessExpiration,
            "username" => $decoded->username
        ];

        $privateKey = file_get_contents(PRIVATE_KEY_PATH);
        $newAccessToken = JWT::encode($newAccessPayload, $privateKey, 'RS256');

        setcookie("jwt", $newAccessToken, $newAccessExpiration, "/", "", true, true);
        return $decoded->username;
    } catch (Exception $e) {
        return null;
    }
}

if (isset($_COOKIE['jwt'])) {
    $jwt = $_COOKIE['jwt'];
    try {
        $publicKey = file_get_contents(PUBLIC_KEY_PATH);
        $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));
        $username = htmlspecialchars($decoded->username);
    } catch (Exception $e) {
        if (isset($_COOKIE['refreshToken'])) {
            $username = regenerateAccessToken($_COOKIE['refreshToken']);
            if (!$username) {
                header("Location: auth.php");
                exit;
            }
        } else {
            header("Location: auth.php");
            exit;
        }
    }
} else {
    header("Location: auth.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <h1>Welcome, <?= $username ?>!</h1>
    <p>You are logged in.</p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
