<?php
session_start();

// Check if user is logged in (simplified check)
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunction.php';

$title = 'Edit Module';
$errors = [];
$success = '';

// Get module ID from URL
$moduleId = $_GET['id'] ?? '';
if (empty($moduleId)) {
    header('Location: admin/manage_modules.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moduleName = trim($_POST['moduleName'] ?? '');
    
    // Debug: Add a message when form is submitted
    error_log("Edit module form submitted for module ID: $moduleId, new name: $moduleName");
    
    // Validation
    if (empty($moduleName)) {
        $errors[] = 'Module name is required';
    }
    
    // Check if module name already exists (except current module)
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM module WHERE Modulename = ? AND id != ?");
            $stmt->execute([$moduleName, $moduleId]);
            if ($stmt->fetch()) {
                $errors[] = 'Module name already exists';
            }
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
    
    // Update module if no errors
    if (empty($errors)) {
        try {
            updateModule($pdo, $moduleId, $moduleName);
            $success = 'Module updated successfully!';
            
            // Refresh module data after update
            $module = getModuleById($pdo, $moduleId);
            
        } catch (Exception $e) {
            $errors[] = 'Error updating module: ' . $e->getMessage();
        }
    }
}

// Get current module data (only if not already loaded during update)
if (!isset($module)) {
    try {
        $module = getModuleById($pdo, $moduleId);
        
        if (!$module) {
            header('Location: admin/manage_modules.php');
            exit();
        }
    } catch (Exception $e) {
        $error = 'Error fetching module: ' . $e->getMessage();
        $module = null;
    }
}

// Prepare data for template
$error = !empty($errors) ? implode('<br>', $errors) : '';

ob_start();
include 'templates/editmodule.html.php';
$output = ob_get_clean();

include 'templates/layout.html.php';
?>