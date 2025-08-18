<?php
require_once '../includes/session.php';
start_session();
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/message_queries.php';
require_once '../includes/auth_admin_check.php';

// Initialize MessageQueries
$messageQueries = new MessageQueries($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Handle Update Status Action
    if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $message_id = filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Validate inputs
        if (!$message_id || !$status) {
            $_SESSION['message_error'] = 'Invalid message ID or status.';
            redirect('../admin/manage-message.php');
        }
        
        // Validate status values
        if (!in_array($status, ['Unread', 'Read'])) {
            $_SESSION['message_error'] = 'Invalid status value.';
            redirect('../admin/manage-message.php');
        }
        
        try {
            $result = $messageQueries->updateMessageStatus($message_id, $status);
            
            if ($result) {
                $_SESSION['message_success'] = 'Message status updated successfully.';
            } else {
                $_SESSION['message_error'] = 'Failed to update message status.';
            }
        } catch (Exception $e) {
            $_SESSION['message_error'] = 'An error occurred: ' . $e->getMessage();
        }
        
        redirect('../admin/manage-message.php');
    }
    
    // Handle Delete Action
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $message_id = filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Validate input
        if (!$message_id) {
            $_SESSION['message_error'] = 'Invalid message ID.';
            redirect('../admin/manage-message.php');
        }
        
        try {
            $result = $messageQueries->deleteMessage($message_id);
            
            if ($result) {
                $_SESSION['message_success'] = 'Message deleted successfully.';
            } else {
                $_SESSION['message_error'] = 'Failed to delete message.';
            }
        } catch (Exception $e) {
            $_SESSION['message_error'] = 'An error occurred: ' . $e->getMessage();
        }
        
        redirect('../admin/manage-message.php');
    }
    
    // Handle Mark as Read/Replied Action
    elseif (isset($_POST['action']) && $_POST['action'] === 'mark_read') {
        $message_id = filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Validate input
        if (!$message_id) {
            $_SESSION['message_error'] = 'Invalid message ID.';
            redirect('../admin/manage-message.php');
        }
        
        try {
            $result = $messageQueries->updateMessageStatus($message_id, 'Read');
            
            if ($result) {
                $_SESSION['message_success'] = 'Message marked as read.';
            } else {
                $_SESSION['message_error'] = 'Failed to mark message as read.';
            }
        } catch (Exception $e) {
            $_SESSION['message_error'] = 'An error occurred: ' . $e->getMessage();
        }
        
        redirect('../admin/manage-message.php');
    }
    
    // Invalid action
    else {
        $_SESSION['message_error'] = 'Invalid action.';
        redirect('../admin/manage-message.php');
    }
    
} else {
    // Handle GET requests or invalid requests
    $_SESSION['message_error'] = 'Invalid request method.';
    redirect('../admin/manage-message.php');
}
?>