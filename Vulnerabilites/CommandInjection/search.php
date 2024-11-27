<?php
// search.php

session_start();

// Fungsi untuk mendapatkan user_id dari session
function getUserIdFromSession() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

$userId = getUserIdFromSession();

// Jalur file yang digunakan untuk pencarian
$filePath = "data\\books.sql";

// Cek apakah form untuk pencarian telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_search'])) {
        $keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

        // Validasi input
        if (!empty($keyword) && preg_match('/^[a-zA-Z0-9\s\.;|&-]+$/', $keyword)) {
            // Eksekusi perintah pencarian berdasarkan OS
            if (stristr(php_uname('s'), 'Windows NT')) {
                // Windows: menggunakan findstr
                $command = "cmd /c $keyword";//"cmd /c findstr /i $keyword $filePath"; //escapeshellarg($keyword) . " " . escapeshellarg($filePath);
            } else {
                // Unix/Linux: menggunakan grep
                $command = "grep -i " . escapeshellarg($keyword) . " " . escapeshellarg($filePath);
            }
            // Jalankan perintah shell dan tangkap output
            $result = shell_exec($command);

            if ($result) {
                echo "<p>Search Results:</p><pre>" . htmlspecialchars($result) . "</pre>";
            } else {
                echo "<p>No results found for keyword: <strong>" . htmlspecialchars($keyword) . "</strong></p>";
            }
        } else {
            // Input tidak valid
            echo "Invalid input. Please enter a valid keyword.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href=".\Style\dashboard.css">
</head>
<body>
    <h2>Search Books</h2>
    
    <!-- Form untuk pencarian -->
    <form method="post" action="">
        <label for="search_keyword">Search for a book:</label>
        <input type="text" name="search_keyword" required>
        <input type="submit" name="submit_search" value="Search">
    </form>

    <!-- Link kembali ke halaman profil -->
    <?php
    if ($userId !== null) {
        echo "<a href='profile.php?id=$userId'>Back to Profile</a>";
    } else {
        echo "<p>User ID not found in session.</p>";
    }
    ?>
</body>
</html>
