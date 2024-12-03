<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi username dan password dari database
    if ($username == 'beres' && $password == 'kemjar123') {
        $issuedAt = time();
        $expirationTime = $issuedAt + TOKEN_EXPIRATION;
        $payload = [
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "username" => $username
        ];

        $privateKey = file_get_contents(PRIVATE_KEY_PATH);
        $jwt = JWT::encode($payload, $privateKey, 'RS256');
        
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
        /* Tambahan CSS untuk eye icon */
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
    </style>
</head>

<body>
<div class="container">
    <h1>Login</h1>
    <form method="post" action="auth.php">
        <input type="text" name="username" placeholder="Enter your username" required>
        
        <!-- Password Input with Eye Icon -->
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
</div>

<script>
    // Get the password field and the eye icon
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        // Toggle the password visibility
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        
        // Toggle the eye icon (open/close)
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
