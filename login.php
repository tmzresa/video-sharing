<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Load user data from the file
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    $validUser  = false;

    foreach ($users as $user) {
        list($storedUsername, $storedHashedPassword) = explode(':', $user);
        if ($username === $storedUsername && password_verify($password, $storedHashedPassword)) {
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        }
    }

    echo "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>