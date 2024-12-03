<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Search Lab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Command Injection: Book Search System</h1>
    
    <!-- Links to access the insecure or secure search -->
    <div>
        <h2>Search Options</h2>
        <p>Select a method to search for books in the database:</p>
        
        <!-- Link to insecure search -->
        <a href="search.php">
            <button>Insecure Search (Command Injection)</button>
        </a>
        
        <!-- Link to secure search -->
        <a href="Secure/search.php">
            <button>Secure Search</button>
        </a>
    </div>
</body>
</html>
