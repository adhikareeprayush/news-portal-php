<?php require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

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
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="news-container">
        <h2>Latest News</h2>
        <div class="news-grid">
            <?php foreach($news_list as $article): ?>
                <article class="news-card" onclick="location.href='newspage.php?id=<?php echo $article['id']; ?>';" style="cursor: pointer;">
                    <img src="https://images.unsplash.com/photo-1495433530039-eb00ed3ab57a?w=400&h=250&fit=crop" alt="News Image">
                    <div class="news-content">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p class="description"><?php echo htmlspecialchars(substr($article['description'], 0, 100)) . '...'; ?></p>
                        <div class="news-meta">
                            <span class="author">By <?php echo htmlspecialchars($article['author']); ?></span>
                            <span class="date"><?php echo date('M d, Y', strtotime($article['created_at'])); ?></span>
                        </div>
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
