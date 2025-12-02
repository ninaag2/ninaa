<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunction.php';

$questionId = $_GET['id'] ?? '';
if (empty($questionId)) {
    header('Location: questions.php');
    exit();
}

// Handle comment submission (only for logged in users)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        $errors[] = 'You must be logged in to comment';
    } else {
        // Use logged in user's info
        $name = $_SESSION['username'] ?? 'User';
        $email = $_SESSION['user_email'] ?? '';
        $message = trim($_POST['message'] ?? '');
        
        $errors = [];
        
        if (empty($message)) {
            $errors[] = 'Comment message is required';
        }
        
        if (empty($errors)) {
            try {
                addComment($pdo, $questionId, $name, $email, $message);
                $success = 'Your comment has been submitted and is pending approval!';
            } catch (Exception $e) {
                $errors[] = 'Error submitting comment: ' . $e->getMessage();
            }
        }
    }
}

// Get question details

$question = getQuestionDetail($pdo, $questionId);
if (!$question) {
    header('Location: questions.php');
    exit();
}

// Get approved comments
try {
    $comments = getCommentsByQuestion($pdo, $questionId)->fetchAll();
} catch (Exception $e) {
    $comments = [];
}

$title = 'Question Details';

ob_start();
include 'templates/single_question.html.php';
$output = ob_get_clean();

include 'templates/layout.html.php';
?>