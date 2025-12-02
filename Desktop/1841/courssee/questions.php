<?php
try {
    include 'includes/DatabaseConnection.php';
    include 'includes/DatabaseFunction.php';
    
    $moduleId = isset($_GET['module']) ? (int)$_GET['module'] : 0;
    $userId = isset($_GET['user']) ? (int)$_GET['user'] : 0;


    if ($moduleId > 0) {
        $questions = getQuestionsByModule($pdo, $moduleId);
        $module = getModuleById($pdo, $moduleId);
        $title = 'Questions in Module: ' . htmlspecialchars($module['Modulename']);
    } elseif ($userId > 0) {
        $questions = getQuestionsByUser($pdo, $userId);
        $user = getUserById($pdo, $userId);
        $title = 'Questions by: ' . htmlspecialchars($user['username']);
    } else {
        $questions = getAllQuestions($pdo);
        $title = 'Question List';
    }
    
    // Get total questions count
    $totalQuestions = totalQuestions($pdo);
    
    // Get all modules and users for filter options
    $modules = getAllModules($pdo);
    $users = getAllUsers($pdo);

    ob_start();
    include 'templates/questions.html.php';
    $output = ob_get_clean();

} catch(PDOException $e) {
    $title = 'Database Error';
    $output = 'Database error: ' . htmlspecialchars($e->getMessage());
} catch(Exception $e) {
    $title = 'Error';
    $output = 'Error: ' . htmlspecialchars($e->getMessage());
}

include 'templates/layout.html.php';
?>
