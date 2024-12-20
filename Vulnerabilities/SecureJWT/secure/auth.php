<?php
require_once 'config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi kredensial pengguna
    if ($username == 'beres' && $password == 'kemjar123') {
        $issuedAt = time();
        $accessTokenExpiration = $issuedAt + TOKEN_EXPIRATION;
        $refreshTokenExpiration = $issuedAt + (TOKEN_EXPIRATION * 5); // Refresh token valid lebih lama

        // Payload Access Token
        $accessPayload = [
            "iat" => $issuedAt,
            "exp" => $accessTokenExpiration,
            "username" => $username,
            "role" => "user" // Menambahkan role admin
        ];

        // Payload Refresh Token
        $refreshPayload = [
            "iat" => $issuedAt,
            "exp" => $refreshTokenExpiration,
            "username" => $username,
            "role" => "user" // Menambahkan role admin
        ];

        $privateKey = file_get_contents(PRIVATE_KEY_PATH);

        // Generate Access Token
        $accessToken = JWT::encode($accessPayload, $privateKey, 'RS256');

        // Generate Refresh Token
        $refreshToken = JWT::encode($refreshPayload, $privateKey, 'RS256');

        // Set cookies
        setcookie("jwt", $accessToken, $accessTokenExpiration, "/", "", true, true);
        setcookie("refreshToken", $refreshToken, $refreshTokenExpiration, "/", "", true, true);

        // Redirect after successful login
        header("Location: index.php");
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
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        .error {
            color: #ff4757;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .password-container {
            position: relative;
            width: 100%;
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .back-link {
            margin-top: 20px;
            display: block;
            text-align: center;
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
        <a href="../onboarding.php">Back to Onboarding</a>
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
