<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunction.php';

$title = 'User Management';

session_start();
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header('Location: ../login_logout/login.php');
    exit();
}
// Handle user creation
if (isset($_POST['create_user'])) {
    try {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';
        
        if (!empty($username) && !empty($email) && !empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$username, $email, $hashedPassword, $role]);
            
            $success = "User created successfully!";
        } else {
            $error = "Please fill in all fields!";
        }
    } catch (Exception $e) {
        $error = "Error creating user: " . $e->getMessage();
    }
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    try {
        $userId = $_POST['user_id'] ?? '';
        if (!empty($userId)) {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $success = "User deleted successfully!";
        }
    } catch (Exception $e) {
        $error = "Error deleting user: " . $e->getMessage();
    }
}

// Get all users
try {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    $users = [];
    $error = "Error fetching users: " . $e->getMessage();
}

ob_start();
include '../templates/manage_users.html.php';
$output = ob_get_clean();

include '../templates/admin_layout.html.php';
?>