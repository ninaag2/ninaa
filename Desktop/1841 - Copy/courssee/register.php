<?php
include 'includes/DatabaseConnection.php';

$title = 'User Registration';

if (isset($_POST['register'])) {
    try {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'student';
        
        $errors = [];
        
        if (empty($username)) $errors[] = "Username is required";
        if (empty($email)) $errors[] = "Email is required";
        if (empty($password)) $errors[] = "Password is required";
        if ($password !== $confirm_password) $errors[] = "Passwords do not match";
        
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already exists";
        }
        
        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$username, $email, $hashedPassword, $role]);
            
            $success = "Registration successful! You can now login.";
        }
        
    } catch (Exception $e) {
        $errors[] = "Registration failed: " . $e->getMessage();
    }
}

ob_start();
include 'templates/register.html.php';
$content = ob_get_clean();

include 'templates/layout.html.php';
?>