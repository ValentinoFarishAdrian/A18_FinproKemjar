<?php
// Memulai sesi jika diperlukan
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding</title>
    <link rel="stylesheet" href="style/style.css">
</head>
</head>
<body>

<div class="container">
    <h1>Welcome to JWT Authentication</h1>
    <p>Select a method</p>

    <!-- Form untuk memilih antara secure atau insecure -->
    <form method="post" action="">
        <input type="submit" name="secure" value="Secure JWT Authentication">
        <span class="or-divider">or</span>
        <input type="submit" name="insecure" value="Insecure JWT Authentication">
    </form>

    <?php
    // Jika tombol Secure JWT diklik, alihkan ke secure/auth.php
    if (isset($_POST['secure'])) {
        header('Location: secure/auth.php');
        exit;
    }
    
    // Jika tombol Insecure JWT diklik, alihkan ke auth.php
    if (isset($_POST['insecure'])) {
        header('Location: auth.php');
        exit;
    }
    ?>
</div>

</body>
</html>
