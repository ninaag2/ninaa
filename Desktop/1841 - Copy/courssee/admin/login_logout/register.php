<?php
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseSession.php';

$title = 'Registration';

// session_start();
// if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_role']) !== 'admin') {
//     header('Location: login.php');
//     exit();
// }
if (isset($_POST['register'])) {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    $errors = [];
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    } else {
        $result = register($pdo, $username, $email, $password, $role);
        if (isset($result['success'])) {
            $success = $result['success'];
        } else {
            $errors[] = $result['error'];
        }
    }
}

ob_start();

$output = ob_get_clean();
include 'register.html.php'
?>