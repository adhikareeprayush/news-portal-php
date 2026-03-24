<?php require 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
    $news_list = $stmt->fetchAll();
} catch(PDOException $e) {
    $news_list = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>News Portal | Latest News</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">📰 News Portal</h1>
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo htmlspecialchars($_SESSION['user_role'] ?? 'user'); ?>)</span>
                    <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
                        <a href="addnews.php" class="back-btn">Add News</a>
                    <?php endif; ?>
                    <a href="logout.php" class="logout-btn">Logout</a>
                <?php else: ?>
                    <a href="index.php" class="back-btn">Login</a>
                    <a href="register.php" class="back-btn">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="news-container">
        <h2>Latest News</h2>
        <div class="news-grid">
            <?php foreach($news_list as $article): ?>
                <?php $banner = !empty($article['banner_image']) ? $article['banner_image'] : 'https://images.unsplash.com/photo-1495433530039-eb00ed3ab57a?w=400&h=250&fit=crop'; ?>
                <article class="news-card" onclick="location.href='newspage.php?id=<?php echo $article['id']; ?>';" style="cursor: pointer;">
                    <img src="<?php echo htmlspecialchars($banner); ?>" alt="News Image">
                    <div class="news-content">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p class="description"><?php echo htmlspecialchars(substr($article['description'], 0, 100)) . '...'; ?></p>
                        <div class="news-meta">
                            <span class="author">By <?php echo htmlspecialchars($article['author']); ?></span>
                            <span class="date"><?php echo date('M d, Y', strtotime($article['created_at'])); ?></span>
                        </div>
                        <?php if (isset($_SESSION['user_id']) && (($_SESSION['user_role'] ?? 'user') === 'admin')): ?>
                            <div style="margin-top: 12px;">
                                <a href="editnews.php?id=<?php echo $article['id']; ?>" class="back-btn" onclick="event.stopPropagation();">Edit</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 News Portal. All rights reserved.</p>
    </footer>
</body>
</html>
