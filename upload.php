<?php
require 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $videoPath = 'uploads/' . basename($_FILES['video']['name']);
    move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);

    $stmt = $pdo->prepare("INSERT INTO videos (user_id, video_path, title) VALUES (:user_id, :video_path, :title)");
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':video_path' => $videoPath,
        ':title' => $_POST['title']
    ]);

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Video</title>
</head>
<body>
    <h2>Upload Video</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Video Title" required><br>
        <input type="file" name="video" required><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
