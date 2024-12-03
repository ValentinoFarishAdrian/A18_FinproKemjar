<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if (isset($_COOKIE['jwt'])) {
    $jwt = $_COOKIE['jwt'];
    try {
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
        $username = htmlspecialchars($decoded->username);
    } catch (Exception $e) {
        header("Location: auth.php");
        exit;
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
