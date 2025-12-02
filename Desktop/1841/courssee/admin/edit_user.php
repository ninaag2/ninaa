<?php
session_start();

// // Check if user is logged in and has admin privileges
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: ../login.php');
//     exit();
// }

include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunction.php';

$title = 'Edit User';
$errors = [];
$success = '';

// Get user ID from URL
$userId = $_GET['id'] ?? '';
if (empty($userId)) {
    header('Location: manage_users.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'student';
    $password = trim($_POST['password'] ?? '');
    
    // Debug: Add a message when form is submitted
    error_log("Edit user form submitted for user ID: $userId, new username: $username");
    
    // Validation
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (!in_array($role, ['admin', 'user'])) {
        $errors[] = 'Invalid role selected';
    }
    
    // Check if username/email already exists (except current user)
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
            $stmt->execute([$username, $email, $userId]);
            if ($stmt->fetch()) {
                $errors[] = 'Username or email already exists';
            }
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
    
    // Update user if no errors
    if (empty($errors)) {
        try {
            if (!empty($password)) {
                // Update with new password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
                $stmt->execute([$username, $email, $hashedPassword, $role, $userId]);
            } else {
                // Update without password change
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
                $stmt->execute([$username, $email, $role, $userId]);
            }
            
            $success = 'User updated successfully!';
            
            // Refresh user data after update
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
        } catch (Exception $e) {
            $errors[] = 'Error updating user: ' . $e->getMessage();
        }
    }
}

// Get current user data (only if not already loaded during update)
if (!isset($user)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user) {
            header('Location: manage_users.php');
            exit();
        }
    } catch (Exception $e) {
        $error = 'Error fetching user: ' . $e->getMessage();
        $user = null;
    }
}

// Prepare data for template
$error = !empty($errors) ? implode('<br>', $errors) : '';

ob_start();
include '../templates/edit_user.html.php';
$output = ob_get_clean();

include '../templates/admin_layout.html.php';
?>