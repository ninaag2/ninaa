<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunction.php';

    $questions = getAllQuestions($pdo);
    $title = 'Question List';
    $totalQuestions = totalQuestions($pdo);

    ob_start();
    include '../templates/admin_questions.html.php';
    $output = ob_get_clean();
} catch(PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}
include '../templates/admin_layout.html.php';
?>