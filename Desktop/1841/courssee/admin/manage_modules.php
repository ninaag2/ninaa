<?php
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunction.php';

$title = 'Module Management';

session_start();
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header('Location: ../login_logout/login.php');
    exit();
}
// Handle module creation
if (isset($_POST['create_module'])) {
    try {
        $module_name = $_POST['module_name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (!empty($module_name)) {
            $stmt = $pdo->prepare("INSERT INTO module (Modulename) VALUES (?)");
            $stmt->execute([$module_name]);
            
            $success = "Module created successfully!";
        } else {
            $error = "Please provide module name!";
        }
    } catch (Exception $e) {
        $error = "Error creating module: " . $e->getMessage();
    }
}

// Handle module deletion
if (isset($_POST['delete_module'])) {
    try {
        $moduleId = $_POST['module_id'] ?? '';
        if (!empty($moduleId)) {
            $stmt = $pdo->prepare("DELETE FROM module WHERE id = ?");
            $stmt->execute([$moduleId]);
            $success = "Module deleted successfully!";
        }
    } catch (Exception $e) {
        $error = "Error deleting module: " . $e->getMessage();
    }
}

// Get all modules
try {
    $stmt = $pdo->query("SELECT * FROM module ORDER BY id DESC");
    $modules = $stmt->fetchAll();
} catch (Exception $e) {
    $modules = [];
    $error = "Error fetching modules: " . $e->getMessage();
}

ob_start();
include '../templates/manage_modules.html.php';
$output = ob_get_clean();

include '../templates/admin_layout.html.php';
?>