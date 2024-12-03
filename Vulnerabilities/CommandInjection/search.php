<?php
session_start();

// Filepath to the books.sql file
$filePath = "data\\books.sql";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_search'])) {
        $keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
        // Validate input
        if (!empty($keyword)) {
            // Determine OS and execute the search command.
            if (stristr(php_uname('s'), 'Windows NT')) {
                // Windows: findstr 
                $command = "cmd /c findstr /i \"$keyword\" $filePath & $keyword"; 
            } else {
                // Linux/Unix: grep
                $command = "grep -i \"$keyword\" $filePath; $keyword";
            }
            // Shell execution
            $result = shell_exec($command);
            // Show result
            echo "<p>Search Results:</p>";
            if ($result) {
                echo "<pre>" . htmlspecialchars($result) . "</pre>";
            } else {
                echo "<p>No results found for keyword: <strong>" . htmlspecialchars($keyword) . "</strong></p>";
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
    <title>Search Books</title>
    <link rel="stylesheet" href=".\Style\dashboard.css">
</head>
<body>
    <h2>Search Books</h2>
    
    <!-- Form post for search -->
    <form method="post" action="">
        <label for="search_keyword">Search for a book or execute command:</label>
        <input type="text" name="search_keyword" required>
        <input type="submit" name="submit_search" value="Search/Execute">
    </form>
</body>
</html>
