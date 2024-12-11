<?php
require 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>
</head>
<body>
    <h2>My Profile</h2>
    <p>Username: <?= htmlspecialchars($user['username']) ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
