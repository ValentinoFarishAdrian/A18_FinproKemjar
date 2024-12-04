<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Periksa apakah JWT ada di cookie
if (isset($_COOKIE['jwt'])) {
    try {
        $jwt = $_COOKIE['jwt'];
        // Decode dan verifikasi token
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));

        // Tampilkan halaman admin
        $username = htmlspecialchars($decoded->username);
    } catch (Exception $e) {
        // Jika token tidak valid, redirect ke halaman login
        header("Location: auth.php");
        exit;
    }
} else {
    // Jika token tidak ditemukan, redirect ke halaman login
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
    <title>Admin Panel</title>
    <style>
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .back-button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome, Admin <?= $username ?>!</h1>
    <p>You have access to the admin panel.</p>
    <a href="index.php" class="back-button">Back</a>
</div>
</body>
</html>
