<?php
require_once "dbh.inc.php";

try {
    // Verify the database connection
    echo "Database connected successfully.<br>";
    
    // Sample query to retrieve users
    $query = "SELECT * FROM users";
    $stmt = $pdo->query($query);

    // Fetch all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output users
    if ($users) {
        echo "Users in the database:<br>";
        foreach ($users as $user) {
            echo "ID: " . htmlspecialchars($user['id']) . "<br>";
            echo "Username: " . htmlspecialchars($user['username']) . "<br>";
            echo "Email: " . htmlspecialchars($user['email']) . "<br><br>";
        }
    } else {
        echo "No users found in the database.";
    }
} catch (PDOException $e) {
    die("Failed: " . htmlspecialchars($e->getMessage()));
}
?>