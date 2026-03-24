<?php require 'config.php';

if (!isset($_SESSION['user_id']) || (($_SESSION['user_role'] ?? 'user') !== 'admin')) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $banner_image = trim($_POST['banner_image'] ?? '');

    if ($author === '') {
        $author = $_SESSION['user_name'] ?? 'Admin';
    }

    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO news (title, description, content, banner_image, author) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $content, $banner_image, $author]);
            header('Location: news.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Failed to add news.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add News | News Portal</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">📰 News Portal</h1>
            <div class="nav-links">
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (admin)</span>
                <a href="news.php" class="back-btn">Back to News</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="news-container">
        <h2>Add News</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <div class="form-div" style="padding: 0; max-width: 600px;">
            <form method="POST">
                <div class="input-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description">
                </div>
                <div class="input-group">
                    <label for="author">Author (optional)</label>
                    <input type="text" id="author" name="author" placeholder="Defaults to your name">
                </div>
                <div class="input-group">
                    <label for="banner_image">Banner Image URL (optional)</label>
                    <input type="url" id="banner_image" name="banner_image" placeholder="https://example.com/banner.jpg">
                </div>
                <div class="input-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                </div>
                <button type="submit">Publish News</button>
            </form>
        </div>
    </div>
</body>
</html>
