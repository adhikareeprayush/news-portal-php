<?php require 'config.php';

$article = null;
if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $article = $stmt->fetch();
        
        if (!$article) {
            echo "Article not found";
            exit;
        }
    } catch(PDOException $e) {
        echo "Error fetching article";
        exit;
    }
}

$banner = !empty($article['banner_image']) ? $article['banner_image'] : 'https://images.unsplash.com/photo-1495433530039-eb00ed3ab57a?w=800&h=400&fit=crop';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($article['title']); ?> | News Portal</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">📰 News Portal</h1>
            <div class="nav-links">
                <a href="news.php" class="back-btn">Back to News</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo htmlspecialchars($_SESSION['user_role'] ?? 'user'); ?>)</span>
                    <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
                        <a href="addnews.php" class="back-btn">Add News</a>
                        <a href="editnews.php?id=<?php echo $article['id']; ?>" class="back-btn">Edit News</a>
                    <?php endif; ?>
                    <a href="logout.php" class="logout-btn">Logout</a>
                <?php else: ?>
                    <a href="index.php" class="back-btn">Login</a>
                    <a href="register.php" class="back-btn">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="article-container">
        <article class="article">
            <img src="<?php echo htmlspecialchars($banner); ?>" alt="Article Image" class="article-img">
            <div class="article-body">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <div class="article-meta">
                    <span class="author">By <?php echo htmlspecialchars($article['author']); ?></span>
                    <span class="date"><?php echo date('M d, Y H:i', strtotime($article['created_at'])); ?></span>
                </div>
                <p class="article-description"><strong><?php echo htmlspecialchars($article['description']); ?></strong></p>
                <div class="article-content">
                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>
            </div>
        </article>
    </div>

    <footer class="footer">
        <p>&copy; 2026 News Portal. All rights reserved.</p>
    </footer>
</body>
</html>
