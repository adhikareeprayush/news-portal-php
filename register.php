<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register | News Portal</title>
</head>
<body>
    <div class="login-div">
        <div class="form-div">
            <h3>Create an account!</h3>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $fullname = $_POST['fullname'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $password = $_POST['password'] ?? '';
                
                if (empty($fullname) || empty($email) || empty($phone) || empty($password)) {
                    echo '<p class="error">Please fill all fields</p>';
                } else {
                    try {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$fullname, $email, $phone, $hashed_password]);
                        
                        echo '<p class="success">Registration successful! <a href="index.php">Login here</a></p>';
                    } catch(PDOException $e) {
                        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                            echo '<p class="error">Email already registered</p>';
                        } else {
                            echo '<p class="error">Registration failed</p>';
                        }
                    }
                }
            }
            ?>
            <form method="POST">
                <div class="input-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <p class="auth-link">Already have an account? <a href="index.php">Login here</a></p>
        </div>
        <img class="login-img" src="https://images.unsplash.com/reserve/LJIZlzHgQ7WPSh5KVTCB_Typewriter.jpg?q=80&w=696&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Register Image">
    </div>
</body>
</html>