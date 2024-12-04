<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Periksa apakah token JWT ada di cookie
if (isset($_COOKIE['jwt'])) {
    $jwt = $_COOKIE['jwt'];
    try {
        // Decode token JWT
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
        $username = htmlspecialchars($decoded->username);
        $role = htmlspecialchars($decoded->role);
    } catch (Exception $e) {
        // Jika token tidak valid, redirect ke auth.php
        header("Location: auth.php");
        exit;
    }
} else {
    // Jika token tidak ditemukan, redirect ke auth.php
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
    <p>You are logged in as <strong><?= $role ?></strong>.</p>
    
    <!-- Tombol untuk logout -->
    <a href="logout.php" class="button">|| Logout || </a>

    <!-- Tombol untuk masuk ke admin.php jika perannya admin -->
    <?php if ($role === 'admin'): ?>
        <a href="admin.php" class="button">|| Go to Admin Panel ||</a>
    <?php else: ?>
        <p style="color: red; font-weight: bold;">Anda bukan admin, akses ke halaman Admin tidak diizinkan.</p>
        <p><a href="exploit.php" class="button">|| Exploit ||</a></p> <!-- Link untuk eksploitasi -->
    <?php endif; ?>
</div>
</body>
</html>
