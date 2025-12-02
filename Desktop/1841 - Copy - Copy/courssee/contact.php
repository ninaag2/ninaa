<?php
 include 'includes/DatabaseConnection.php';
 include 'includes/DatabaseFunction.php';
 include 'includes/Databasesession.php';

$feedback = '';  //User feedback notification

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (isValidContactForm($name, $email, $subject, $message)) {
        $success = handleContactSubmission($pdo, $name, $email, $subject, $message);
        $feedback = $success 
            ? " Your message has been sent and saved!" 
            : " Failed to send email.";
    } else {
        $feedback = "Please fill in all required fields.";
    }
}

// Gửi ra giao diện
$title = "Contact Us";
ob_start();
include 'templates/contact.html.php';
$content = ob_get_clean();
include 'templates/layout.html.php';
?>
