<?php

$dsn ="mysql:host=localhost;port=4306;dbname=website";
$dbusername ="root";
$dbpassword ="";



try {
    $pdo = new PDO($dsn,$dbusername,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " .$e->getMessage();
    
}
?>
