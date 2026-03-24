<?php require 'config.php';

if (!isset($_SESSION['user_id']) || (($_SESSION['user_role'] ?? 'user') !== 'admin')) {
    header('Location: index.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: news.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if (!$article) {
        echo 'Article not found';
        exit;
    }
} catch (PDOException $e) {
    echo 'Error loading article';
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
            $update = $pdo->prepare("UPDATE news SET title = ?, description = ?, content = ?, banner_image = ?, author = ? WHERE id = ?");
            $update->execute([$title, $description, $content, $banner_image, $author, $id]);
            header('Location: newspage.php?id=' . $id);
            exit;
        } catch (PDOException $e) {
            $error = 'Failed to update news.';
        }
    }

    $article['title'] = $title;
    $article['description'] = $description;
    $article['content'] = $content;
    $article['banner_image'] = $banner_image;
    $article['author'] = $author;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit News | News Portal</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">📰 News Portal</h1>
            <div class="nav-links">
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (admin)</span>
                <a href="newspage.php?id=<?php echo $id; ?>" class="back-btn">Back to Article</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="news-container">
        <h2>Edit News</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <div class="form-div" style="padding: 0; max-width: 600px;">
            <form method="POST">
                <div class="input-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($article['description'] ?? ''); ?>">
                </div>
                <div class="input-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($article['author'] ?? ''); ?>">
                </div>
                <div class="input-group">
                    <label for="banner_image">Banner Image URL (optional)</label>
                    <input type="url" id="banner_image" name="banner_image" value="<?php echo htmlspecialchars($article['banner_image'] ?? ''); ?>" placeholder="https://example.com/banner.jpg">
                </div>
                <div class="input-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($article['content']); ?></textarea>
                </div>
                <button type="submit">Update News</button>
            </form>
        </div>
    </div>
</body>
</html>
