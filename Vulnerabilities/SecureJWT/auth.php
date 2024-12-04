<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi login sederhana
    if ($username == 'beres' && $password == 'kemjar123') {
        $issuedAt = time();
        $expirationTime = $issuedAt + TOKEN_EXPIRATION; // Contoh TOKEN_EXPIRATION di config.php
        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "username" => $username,
            "role" => "user" // Menambahkan role admin
        );

        // Membuat token JWT
        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256'); // SECRET_KEY dari config.php

        // Set cookie dengan token JWT
        setcookie("jwt", $jwt, $expirationTime, "/");
        header("Location: index.php"); // Redirect setelah login sukses
        exit;
    } else {
        $error = "Invalid credentials! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
    <style>
        .error {
            color: #ff4757;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #10ac84;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .back-button:hover {
            background-color: #0d8b6d;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <form method="post" action="auth.php">
        <input type="text" name="username" placeholder="Enter your username" required>
        
        <div class="password-container">
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <i class="fas fa-eye eye-icon" id="togglePassword"></i>
        </div>
        
        <input type="submit" value="Login">
    </form>

    <?php
    if (isset($error)) {
        echo "<div class='error'>$error</div>";
    }
    ?>

    <!-- Link to go back to onboarding.php -->
    <div class="back-link">
        <a href="onboarding.php">Back to Onboarding</a>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
