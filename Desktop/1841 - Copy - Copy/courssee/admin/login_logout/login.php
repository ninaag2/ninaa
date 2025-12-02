<?php
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseSession.php';
session_start();

$title = 'Login';
if (isset($_POST['login'])) {
    $result = login($pdo, $_POST['email'] ?? '', $_POST['password'] ?? '');
    if (isset($result['success'])) {
        $user = $result['user'];
        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: ../questions.php');
            exit();
        } else {
            header('Location: ../../index.php');
            exit();
        }
    } else {
        $error = $result['error'];
    }
}

ob_start();
$content = ob_get_clean();
include 'login.html.php';
?>