<?php
require 'database.php'; // Include the database connection
session_start(); // Start session to manage user login state

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        echo "Username and password are required!";
        exit();
    }

    try {
        // Query the database to find the user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and the password matches
        if ($user && $user['password'] === $password) {
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            header('Location: index.php'); // Redirect to main page
            exit();
        } else {
            echo "Invalid username or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>
