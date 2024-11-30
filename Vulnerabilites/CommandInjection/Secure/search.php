<?php
session_start();

// Filepath to the books.sql file (relative to the Secure folder)
$filePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "books.sql";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_search'])) {
        $keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';

        // Validate input
        if (!empty($keyword)) {
            // Allow only alphanumeric characters and spaces
            if (preg_match('/^[a-zA-Z0-9\s]+$/', $keyword)) {
                // Determine OS and use appropriate search command
                if (stristr(php_uname('s'), 'Windows NT')) {
                    // Windows: findstr
                    $command = "cmd /c findstr /i " . escapeshellarg($keyword) . " " . escapeshellarg($filePath);
                } else {
                    // Unix/Linux: grep
                    $command = "grep -i " . escapeshellarg($keyword) . " " . escapeshellarg($filePath);
                }

                // Execute the search command securely
                $result = shell_exec($command);

                // Show results
                echo "<p>Search Results:</p>";
                if ($result) {
                    echo "<pre>" . htmlspecialchars($result) . "</pre>";
                } else {
                    echo "<p>No results found for keyword: <strong>" . htmlspecialchars($keyword) . "</strong></p>";
                }
            } else {
                echo "Invalid input. Only alphanumeric characters and spaces are allowed.";
            }
        } else {
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
    <title>Secure Search Books</title>
    <link rel="stylesheet" href="../Style/dashboard.css">
</head>
<body>
    <h2>Secure Search Books</h2>
    
    <!-- Form for secure search -->
    <form method="post" action="">
        <label for="search_keyword">Search for a book:</label>
        <input type="text" name="search_keyword" required>
        <input type="submit" name="submit_search" value="Search">
    </form>
</body>
</html>
