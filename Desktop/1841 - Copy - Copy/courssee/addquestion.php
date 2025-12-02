<?php

// Include database connection and functions
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunction.php';

if(isset($_POST['questiontext'])){
    try{
        // Validate input data

        $username = isset($_POST['users_username']) ? $_POST['users_username'] : '';
        $email = isset($_POST['users_email']) ? $_POST['users_email'] : '';
        $modules = isset($_POST['modules']) ? $_POST['modules'] : '';

        $errors = validateQuestion($_POST['questiontext'], $username, $email, $modules);
        
        if (empty($errors)) {
            // Handle image upload using the new function
            $imagePath = null;
            if (!empty($_FILES['image'])) {
                try {
                    $imagePath = handleImageUpload($_FILES['image']);
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            
            // If no errors, add the question
            if (empty($errors)) {
                // Find or create user
                $userId = CreateUser($pdo, $username, $email);
                $moduleid = $modules; // Ensure moduleid is set from form
                addQuestion($pdo, $_POST['questiontext'], $userId, $moduleid, $imagePath);
                header('Location: questions.php');
                exit();
            }
        }
        
        // If there are errors, display them
        if (!empty($errors)) {
            $title = 'Error Adding Question';
            $errorOutput = '<div class="errors"><ul>';
            foreach ($errors as $error) {
                $errorOutput .= '<li>' . htmlspecialchars($error) . '</li>';
            }
            $errorOutput .= '</ul></div>';
            
            // Get modules for the form
            $modules = getAllModules($pdo);
            
            ob_start();
            echo $errorOutput;
            include 'templates/addquestion.html.php';
            $output = ob_get_clean();
            include 'templates/layout.html.php';
        }
        
    } catch(PDOException $e) {
        $title = 'Database Error';
        $output = 'Database error: ' . htmlspecialchars($e->getMessage());
        include 'templates/layout.html.php';
    } catch(Exception $e) {
        $title = 'Error';
        $output = 'Error: ' . htmlspecialchars($e->getMessage());
        include 'templates/layout.html.php';
    }
} else {
    // Display the add question form
    $title = 'Add a Question';
    
    try {
        // Get modules using new functions
        $modules = getAllModules($pdo);
        
        ob_start();
        include 'templates/addquestion.html.php';
        $output = ob_get_clean();
        include 'templates/layout.html.php';
        
    } catch(PDOException $e) {
        $title = 'Database Error';
        $output = 'Database error: ' . htmlspecialchars($e->getMessage());
        include 'templates/layout.html.php';
    }
}
?>