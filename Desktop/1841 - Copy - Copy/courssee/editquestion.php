<?php
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunction.php';
try {
    if (isset($_POST['questiontext'])) {
        $errors = validateQuestion($_POST['questiontext'], $_POST['authors_name'],$_POST['authors_email'], $_POST['modules']);
        
        if (empty($errors)) {
            $imagePath = null;
            if (!empty($_FILES['image'])) {
                try {
                    $imagePath = handleImageUpload($_FILES['image']);
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            
            if (empty($errors)) {
                updateQuestion($pdo, $_POST['questionid'], $_POST['questiontext'], $_POST['users_username'], $_POST['users_email'], $_POST['modules'], $imagePath);
                header('Location: questions.php');
                exit();
            }
        }
        
        if (!empty($errors)) {
            $question = getQuestionById($pdo, $_POST['questionid']);
            // $users = getAllUsers($pdo);
            $modules = getAllModules($pdo);
            $title = 'Error Editing Question';
            $errorOutput = '<div class="errors"><ul>';
            foreach ($errors as $error) {
                $errorOutput .= '<li>' . htmlspecialchars($error) . '</li>';
            }
            $errorOutput .= '</ul></div>';
        }
    } else {
        $question = getQuestionById($pdo, $_GET['id']);
        // $users = getAllUsers($pdo);
        $modules = getAllModules($pdo);
        $title = 'Edit question';
    }

    ob_start();
    include 'templates/editquestion.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Error editing question: ' . $e->getMessage();
}

include 'templates/layout.html.php';