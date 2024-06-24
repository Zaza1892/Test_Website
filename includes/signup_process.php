<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email, password_hash($pwd, PASSWORD_DEFAULT)]);

        $pdo = null;
        $stmt = null;
        header("Location: ../login.html");
        die();
    } catch (PDOException $e) {
        die("Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../login.html");
}
?>
</body>
</html>