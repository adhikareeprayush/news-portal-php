<?php
// Run this file once to set up the database and insert sample data
require 'config.php';

try {
    // Insert sample news
    $news_data = [
        [
            'title' => 'Breaking News: Technology Advances',
            'description' => 'Latest updates in tech industry',
            'content' => 'The technology sector is experiencing unprecedented growth. New innovations are being released every day that are changing how we live and work. Artificial Intelligence, blockchain, and quantum computing are at the forefront of this revolution.',
            'author' => 'Admin'
        ],
        [
            'title' => 'Sports: Championship Finals',
            'description' => 'Exciting games and record-breaking performances',
            'content' => 'The championship finals brought excitement and thrills to millions of fans worldwide. Athletes displayed remarkable skill and determination. The final match was a complete success with unprecedented viewership.',
            'author' => 'Sports Desk'
        ],
        [
            'title' => 'Business: Market Update',
            'description' => 'Stock markets show positive growth',
            'content' => 'Global markets are showing strong performance with major indices reaching new highs. Investors are optimistic about economic recovery and future growth prospects. Trading volumes have increased significantly.',
            'author' => 'Finance Team'
        ],
        [
            'title' => 'Health: New Medical Breakthrough',
            'description' => 'Scientists discover new treatment methods',
            'content' => 'Recent research has led to groundbreaking discoveries in medical science. New treatment protocols are showing high success rates in clinical trials. Medical professionals are excited about the potential to save more lives.',
            'author' => 'Health Correspondent'
        ],
        [
            'title' => 'Environment: Climate Action Steps',
            'description' => 'World takes initiative for climate change',
            'content' => 'Nations worldwide are taking concrete steps to combat climate change. Renewable energy adoption is accelerating at unprecedented rates. Green initiatives are creating thousands of new jobs.',
            'author' => 'Environment Reporter'
        ],
        [
            'title' => 'Education: Online Learning Revolution',
            'description' => 'Digital education transforming the sector',
            'content' => 'Online education platforms are revolutionizing how people learn and acquire new skills. Universities are adapting to hybrid models. Students have more flexibility and access to world-class education.',
            'author' => 'Education Desk'
        ]
    ];

    // Clear existing news
    $pdo->exec("TRUNCATE TABLE news");
    
    // Insert news
    $stmt = $pdo->prepare("INSERT INTO news (title, description, content, author) VALUES (?, ?, ?, ?)");
    foreach($news_data as $news) {
        $stmt->execute([
            $news['title'],
            $news['description'],
            $news['content'],
            $news['author']
        ]);
    }
    
    echo "Database setup completed successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
