<?php
require 'database.php';
session_start();

$stmt = $pdo->query("SELECT videos.*, users.username FROM videos JOIN users ON videos.user_id = users.id ORDER BY uploaded_at DESC");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Video Sharing Platform</title>
</head>
<body>
    <h1>Video Sharing Platform</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="profile.php">Profile</a> |
        <a href="upload.php">Upload Video</a> |
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> |
        <a href="signup.php">Signup</a>
    <?php endif; ?>

    <h2>Videos</h2>
    <?php foreach ($videos as $video): ?>
        <div>
            <h3><?= htmlspecialchars($video['title']) ?></h3>
            <p>By <?= htmlspecialchars($video['username']) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
