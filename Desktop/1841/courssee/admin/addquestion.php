<?php
// Include database connection and functions
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunction.php';

if(isset($_POST['questiontext'])){
    try{
        // Validate input data
        $errors = validateQuestion($_POST['questiontext'], $_POST['users_email'],$_POST['users_username'], $_POST['modules']);
        
        if (empty($errors)) {
            // Handle image upload using the new function
            $imagePath = null;
            if (!empty($_FILES['image'])) {
                try {
                    // Get the uploaded image and move it to the correct directory
                    $imagePath = handleImageUpload($_FILES['image']);
                    // Make sure the path is relative from the root directory
                    if ($imagePath && !str_starts_with($imagePath, '../')) {
                        // Image path is already relative to root, no need to change
                    }
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            
            // If no errors, add the question
            if (empty($errors)) {
                addQuestion($pdo, $_POST['questiontext'], $_POST['users'], $_POST['modules'], $imagePath);
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
            
            // Get users and categories for the form
            // $users = getAllUsers($pdo);
            $modules = getAllModules($pdo);
            
            ob_start();
            echo $errorOutput;
            include '../templates/addquestion.html.php';
            $output = ob_get_clean();
            include '../templates/admin_layout.html.php';
        }
        
    } catch(PDOException $e) {
        $title = 'Database Error';
        $output = 'Database error: ' . htmlspecialchars($e->getMessage());
        include '../templates/admin_layout.html.php';
    } catch(Exception $e) {
        $title = 'Error';
        $output = 'Error: ' . htmlspecialchars($e->getMessage());
        include '../templates/admin_layout.html.php';
    }
} else {
    // Display the add question form
    $title = 'Add a Question';
    
    try {
        // Get users and categories using new functions
        // $users = getAllUsers($pdo);
        $modules = getAllModules($pdo);
        
        ob_start();
        include '../templates/addquestion.html.php';
        $output = ob_get_clean();
        include '../templates/admin_layout.html.php';
        
    } catch(PDOException $e) {
        $title = 'Database Error';
        $output = 'Database error: ' . htmlspecialchars($e->getMessage());
        include '../templates/admin_layout.html.php';
    }
}
?>