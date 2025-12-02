<?php
try {
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunction.php';
    
    // Accept id from POST['id'], POST['questionid'] or fallback to GET['id']
    $incomingId = null;
    if (isset($_POST['id'])) {
        $incomingId = $_POST['id'];
    } elseif (isset($_POST['questionid'])) {
        $incomingId = $_POST['questionid'];
    } elseif (isset($_GET['id'])) {
        $incomingId = $_GET['id'];
    }

    // DEBUG: log incoming id for troubleshooting (remove this in production)
    
    if ($incomingId !== null && is_numeric($incomingId)) {
        $id = (int)$incomingId;
        if ($id <= 0) {
            throw new Exception('Invalid question ID.');
        }

        // Validate that the question exists before deleting
        $question = getQuestionById($pdo, $id);
        if (!$question) {
            throw new Exception('Question not found.');
        }

        // Delete the question (this also handles image file deletion)
        deleteQuestion($pdo, $id);

        // Redirect back to questions list
        header('Location: questions.php');
        exit();
    } else {
        throw new Exception('Invalid question ID.');
    }
    
} catch(PDOException $e) {
    $title = 'Database Error';
    $output = 'Unable to delete question. Database error: ' . htmlspecialchars($e->getMessage());
    include '../templates/layout.html.php';
} catch(Exception $e) {
    $title = 'Error';
    $output = 'Unable to delete question. Error: ' . htmlspecialchars($e->getMessage());
    include '../templates/layout.html.php';
}
?>