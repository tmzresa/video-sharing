<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
    <a href="upload.php">Upload Video</a>
    <a href="logout.php">Logout</a>
</body>
</html>