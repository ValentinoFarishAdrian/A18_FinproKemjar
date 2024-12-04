<?php
require_once 'config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function regenerateAccessToken($refreshToken) {
    try {
        $publicKey = file_get_contents(PUBLIC_KEY_PATH);
        $decoded = JWT::decode($refreshToken, new Key($publicKey, 'RS256'));

        $issuedAt = time();
        $newAccessExpiration = $issuedAt + TOKEN_EXPIRATION;

        $newAccessPayload = [
            "iat" => $issuedAt,
            "exp" => $newAccessExpiration,
            "username" => $decoded->username,
            "role" => $decoded->role // Pastikan role juga dibawa dalam payload
        ];

        $privateKey = file_get_contents(PRIVATE_KEY_PATH);
        $newAccessToken = JWT::encode($newAccessPayload, $privateKey, 'RS256');
        setcookie("jwt", $newAccessToken, $newAccessExpiration, "/", "", true, true);

        return $decoded->username;
    } catch (Exception $e) {
        return null;
    }
}

// Periksa apakah JWT ada di cookie
if (isset($_COOKIE['jwt'])) {
    try {
        $jwt = $_COOKIE['jwt'];
        $publicKey = file_get_contents(PUBLIC_KEY_PATH);
        $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));

        // Verifikasi apakah token kadaluarsa
        if ($decoded->exp < time()) {
            header("Location: auth.php");
            exit;
        }

        $username = htmlspecialchars($decoded->username);
        $role = htmlspecialchars($decoded->role); // Ambil role pengguna dari token

        // Jika role bukan admin, redirect ke halaman biasa
        if ($role !== 'admin') {
            header("Location: index.php");
            exit;
        }

    } catch (Exception $e) {
        // Jika token tidak valid, coba dengan refresh token
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
    <link rel="stylesheet" href="../style/style.css">
    <title>Admin Panel</title>

</head>
<body>
<div class="container">
    <h1>Welcome, Admin <?= $username ?>!</h1>
    <p>You have access to the admin panel.</p>
    <a href="index.php" class="back-button">Back</a>
</div>
</body>
</html>
