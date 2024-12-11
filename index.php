<?php
session_start();

// Load uploaded videos
$videos = [];
if (file_exists('videos.txt')) {
    $videos = file('videos.txt', FILE_IGNORE_NEW_LINES);
}

// Handle delete request
if (isset($_GET['delete'])) {
    $videoToDelete = $_GET['delete'];
    $updatedVideos = [];

    // Read existing videos and filter out the one to delete
    foreach ($videos as $video) {
        list($username, $videoName) = explode(':', $video);
        if ($videoName !== $videoToDelete) {
            $updatedVideos[] = $video; // Keep the video
        } else {
            // Delete the video file from the server
            unlink("uploads/" . $videoToDelete);
        }
    }

    // Save the updated list back to videos.txt
    file_put_contents('videos.txt', implode("\n", $updatedVideos) . "\n");
    header('Location: index.php'); // Redirect to avoid resubmission
    exit();
}

function displayNavbar() {
    echo '<nav>';
    if (isset($_SESSION['username'])) {
        echo '<a href="profile.php">Profile</a>';
        echo '<a href="upload.php">Upload Video</a>';
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="signup.php">Signup</a>';
        echo '<a href="login.php">Login</a>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Uploads</title>
</head>
<body>
    <?php displayNavbar(); ?>

    <h2>Uploaded Videos</h2>
    <?php if (empty($videos)): ?>
        <p>No videos uploaded yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($videos as $video): ?>
                <?php list($username, $videoName) = explode(':', $video); ?>
                <li>
                    <?php echo htmlspecialchars($username) . " uploaded: " . htmlspecialchars($videoName); ?>
                    <br>
                    <video width="320" height="240" controls>
                        <source src="uploads/<?php echo htmlspecialchars($videoName); ?>" type="video/<?php echo pathinfo($videoName, PATHINFO_EXTENSION); ?>">
                        Your browser does not support the video tag.
                    </video>
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $username): ?>
                        <form method="POST" action="index.php" style="display:inline;">
                            <button type="submit" name="delete" value="<?php echo htmlspecialchars($videoName); ?>">Delete</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>