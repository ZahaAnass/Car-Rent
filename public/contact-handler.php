<?php
require_once '../config/database.php';
require_once '../includes/queries/message_queries.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
start_session();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect("../auth/login.php");
}

try {
    $messageQuery = new MessageQueries($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validate and sanitize inputs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '';
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) ?? '';
        $inquiry_type = filter_input(INPUT_POST, 'inquiry_type', FILTER_SANITIZE_STRING) ?? '';
        $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) ?? '';
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) ?? '';

        // Input validation
        if (empty($name)) {
            throw new Exception('Name is required');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
        if (empty($inquiry_type)) {
            throw new Exception('Please select an inquiry type');
        }
        if (empty($subject)) {
            throw new Exception('Subject is required');
        }
        if (empty($message)) {
            throw new Exception('Message is required');
        }

        // Create message
        $messageQuery->createMessage($name, $email, $phone, $inquiry_type, $subject, $message);
        $_SESSION["success"] = "Message sent successfully";
        redirect("contact.php");
    }
} catch (Exception $e) {
    $_SESSION["error"] = $e->getMessage();
    redirect("contact.php");
}
?>
