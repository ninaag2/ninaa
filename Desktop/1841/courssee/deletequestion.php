<?php
try {
    include 'includes/DatabaseConnection.php';
    include 'includes/DatabaseFunction.php';
    
    // Check if ID is provided
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = (int)$_POST['id'];

        // DEBUG: log incoming id for troubleshooting (remove this in production)
       

        // Validate that the question exists before deleting
        $question = getQuestionById($pdo, $id);
        // DEBUG: log query result
       
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
    include 'templates/layout.html.php';
} catch(Exception $e) {
    $title = 'Error';
    $output = 'Unable to delete question. Error: ' . htmlspecialchars($e->getMessage());
    include 'templates/layout.html.php';
}
?>