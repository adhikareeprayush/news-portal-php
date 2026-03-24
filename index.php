<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login | News Portal</title>
</head>
<body>
    <div class="login-div">
        <img class="login-img" src="https://images.unsplash.com/reserve/LJIZlzHgQ7WPSh5KVTCB_Typewriter.jpg?q=80&w=696&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Login Image">
        <div class="form-div">
            <h3>👋 Welcome back!</h3>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                
                if (empty($email) || empty($password)) {
                    echo '<p class="error">Please fill all fields</p>';
                } else {
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                        $stmt->execute([$email]);
                        $user = $stmt->fetch();
                        
                        if ($user && password_verify($password, $user['password'])) {
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_name'] = $user['fullname'];
                            $_SESSION['user_role'] = $user['role'] ?? 'user';
                            header('Location: news.php');
                            exit;
                        } else {
                            echo '<p class="error">Invalid email or password</p>';
                        }
                    } catch(PDOException $e) {
                        echo '<p class="error">Database error</p>';
                    }
                }
            }
            ?>
            <form method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="auth-link">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>