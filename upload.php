<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["video"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size (limit to 50MB)
    if ($_FILES["video"]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($videoFileType, ['mp4', 'avi', 'mov', 'wmv'])) {
        echo "Sorry, only MP4, AVI, MOV & WMV files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
            // Save video info to videos.txt
            $username = $_SESSION['username'];
            file_put_contents('videos.txt', "$username:" . htmlspecialchars(basename($_FILES["video"]["name"])) . "\n", FILE_APPEND);
            echo "The file " . htmlspecialchars(basename($_FILES["video"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
</head>
<body>
    <h2>Upload Video</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="video" required>
        <button type="submit">Upload Video</button>
    </form>
</body>
</html>