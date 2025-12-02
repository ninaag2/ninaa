<?php
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login_logout/login.php');
    exit();
}

include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunction.php';

$title = 'Comment Management';

// Handle comment actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'] ?? '';
    $action = $_POST['action'] ?? '';
    
    if (!empty($commentId)) {
        try {
            switch ($action) {
                case 'approve':
                    approveComment($pdo, $commentId);
                    $success = 'Comment approved successfully!';
                    break;
                    
                case 'reject':
                    rejectComment($pdo, $commentId);
                    $success = 'Comment rejected successfully!';
                    break;
                    
                case 'delete':
                    deleteComment($pdo, $commentId);
                    $success = 'Comment deleted successfully!';
                    break;
                    
                case 'reply':
                    $replyMessage = trim($_POST['reply_message'] ?? '');
                    $comment = getCommentById($pdo, $commentId);
                    
                    if (!empty($replyMessage) && $comment) {
                        $questions_ID = $comment['questions_ID'];
                        
                        // Get admin info
                        $adminName = $_SESSION['username'] ?? 'Admin';
                        $adminEmail = $_SESSION['user_email'] ?? 'admin@example.com';
                        
                        // Add admin reply
                        addComment($pdo, $questions_ID, $adminName, $adminEmail, $replyMessage, 1, $commentId);
                        
                        // Auto-approve the original comment if it's pending
                        $comment = getCommentById($pdo, $commentId);
                        if ($comment && $comment['status'] === 'pending') {
                            approveComment($pdo, $commentId);
                        }
                        
                        $success = 'Reply posted successfully!';
                    } else {
                        $error = 'Reply message is required!';
                    }
                    break;
            }
        } catch (Exception $e) {
            $error = 'Error processing action: ' . $e->getMessage();
        }
    }
}

// Get pending comments
try {
    $pendingComments = getAllPendingComments($pdo)->fetchAll();
} catch (Exception $e) {
    $pendingComments = [];
    $error = 'Error fetching comments: ' . $e->getMessage();
}

// Get all approved comments for management
try {
    $approvedComments = getAllApprovedComments($pdo)->fetchAll();
} catch (Exception $e) {
    $approvedComments = [];
    $error = 'Error fetching approved comments: ' . $e->getMessage();
}

ob_start();
include '../templates/manage_comments.html.php';
$output = ob_get_clean();

include '../templates/admin_layout.html.php';
?>