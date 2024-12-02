<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'beres' && $password == 'kemjar123') {
        $issuedAt = time();
        $expirationTime = $issuedAt + TOKEN_EXPIRATION;  
        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "username" => $username
        );

        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        setcookie("jwt", $jwt, $expirationTime, "/");
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
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <form method="post" action="auth.php">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="submit" value="Login">
    </form>
    <?php
    if (isset($error)) {
        echo "<div class='error'>$error</div>";
    }
    ?>
</div>
</body>
</html>
