<?php
// Mengecek apakah cookie 'jwt' ada
if (isset($_COOKIE['jwt'])) {
    // Menghapus cookie jwt dengan flag HttpOnly dan Secure
    setcookie("jwt", "", time() - 600, "/", "", true, true); // HttpOnly dan Secure diaktifkan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Logout</title>
    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = 'auth.php';
        }, 3000);
    </script>
</head>
<body>
<div class="container">
    <h1>You have been logged out!</h1>
    <p>Redirecting to login page in <span id="countdown">3</span> seconds...</p>
    <a href="auth.php">Click here if not redirected</a>
</div>
<script>
    let countdown = 3;
    const countdownElement = document.getElementById('countdown');
    setInterval(() => {
        countdown -= 1;
        countdownElement.textContent = countdown;
        if (countdown <= 0) window.location.href = 'auth.php';
    }, 1000);
</script>

</body>
</html>