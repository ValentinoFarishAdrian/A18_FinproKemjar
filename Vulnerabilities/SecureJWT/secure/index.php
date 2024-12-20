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
            "role" => $decoded->role // Menambahkan role admin
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

        // Verifikasi kedaluwarsa token
        if ($decoded->exp < time()) {
            header("Location: auth.php");
            exit;
        }

        $username = htmlspecialchars($decoded->username);
        $role = htmlspecialchars($decoded->role); // Mengambil role dari payload token

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
    <link rel="stylesheet" href="../style/style.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <h1>Welcome, <?= $username ?>!</h1>
    <p>You are logged in as <strong><?= $role ?></strong>.</p>

    <!-- Tombol untuk logout -->
    <a href="logout.php">Logout</a>

    <!-- Tombol untuk masuk ke admin.php jika perannya admin -->
    <?php if ($role === 'admin'): ?>
        <a href="admin.php">Go to Admin Panel</a>
    <?php else: ?>
        <p style="color: red; font-weight: bold;">You are not an admin, access to the Admin panel is restricted.</p>
    <?php endif; ?>
</div>
</body>
</html>
