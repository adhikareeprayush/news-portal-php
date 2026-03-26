<?php
require 'config.php';

try {
    $news_data = [
        [
            'title' => 'Breaking News: Technology Advances',
            'description' => 'Latest updates in tech industry',
            'content' => 'The technology sector is experiencing unprecedented growth. New innovations are being released every day that are changing how we live and work. Artificial Intelligence, blockchain, and quantum computing are at the forefront of this revolution.',
            'author' => 'Admin',
            'banner_image' => 'https://images.unsplash.com/photo-1773332585754-f1436987743b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ],
        [
            'title' => 'Sports: Championship Finals',
            'description' => 'Exciting games and record-breaking performances',
            'content' => 'The championship finals brought excitement and thrills to millions of fans worldwide. Athletes displayed remarkable skill and determination. The final match was a complete success with unprecedented viewership.',
            'author' => 'Sports Desk',
            'banner_image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=1607&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ],
        [
            'title' => 'Business: Market Update',
            'description' => 'Stock markets show positive growth',
            'content' => 'Global markets are showing strong performance with major indices reaching new highs. Investors are optimistic about economic recovery and future growth prospects. Trading volumes have increased significantly.',
            'author' => 'Finance Team',
            'banner_image' => 'https://images.unsplash.com/photo-1556740772-1a741367b93e?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ],
        [
            'title' => 'Health: New Medical Breakthrough',
            'description' => 'Scientists discover new treatment methods',
            'content' => 'Recent research has led to groundbreaking discoveries in medical science. New treatment protocols are showing high success rates in clinical trials. Medical professionals are excited about the potential to save more lives.',
            'author' => 'Health Correspondent',
            'banner_image' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ],
        [
            'title' => 'Environment: Climate Action Steps',
            'description' => 'World takes initiative for climate change',
            'content' => 'Nations worldwide are taking concrete steps to combat climate change. Renewable energy adoption is accelerating at unprecedented rates. Green initiatives are creating thousands of new jobs.',
            'author' => 'Environment Reporter',
            'banner_image' => 'https://images.unsplash.com/photo-1472313420546-a46e561861d8?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ],
        [
            'title' => 'Education: Online Learning Revolution',
            'description' => 'Digital education transforming the sector',
            'content' => 'Online education platforms are revolutionizing how people learn and acquire new skills. Universities are adapting to hybrid models. Students have more flexibility and access to world-class education.',
            'author' => 'Education Desk',
            'banner_image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ]
    ];

    $pdo->exec("TRUNCATE TABLE news");
    
    $stmt = $pdo->prepare("INSERT INTO news (title, description, content, author, banner_image) VALUES (?, ?, ?, ?, ?)");
    foreach($news_data as $news) {
        $stmt->execute([
            $news['title'],
            $news['description'],
            $news['content'],
            $news['author'],
            $news['banner_image']
        ]);
    }
    
    echo "Database setup completed successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
