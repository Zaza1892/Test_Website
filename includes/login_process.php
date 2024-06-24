<?php
session_start();
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        //fetch the user by email
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pwd'])) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to  dashboard
            echo "Log in Successful";
            header("Location: ../index.php");
           
            exit();
        } else {
            // Invalid email or password
            echo "Invalid email or password.";
            header("Location: ../login.html");
        }
    } catch (PDOException $e) {
        die("Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../login.html");
    exit();
}
?>
