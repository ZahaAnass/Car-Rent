<?php
// Include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/testimonial_queries.php';
require_once '../includes/auth_admin_check.php';

// Start session
start_session();

// Initialize TestimonialQueries
$testimonialQueries = new TestimonialQueries($pdo);

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $testimonial_id = isset($_POST['testimonial_id']) ? (int)$_POST['testimonial_id'] : 0;
    
    try {
        switch ($action) {
            case 'approve':
                if ($testimonial_id > 0) {
                    if ($testimonialQueries->updateTestimonialStatus($testimonial_id, 'Approved')) {
                        $_SESSION['success'] = 'Testimonial approved successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to approve testimonial. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid testimonial ID.';
                }
                break;
                
            case 'reject':
                if ($testimonial_id > 0) {
                    if ($testimonialQueries->updateTestimonialStatus($testimonial_id, 'Rejected')) {
                        $_SESSION['success'] = 'Testimonial rejected successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to reject testimonial. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid testimonial ID.';
                }
                break;
                
            case 'pending':
                if ($testimonial_id > 0) {
                    if ($testimonialQueries->updateTestimonialStatus($testimonial_id, 'Pending')) {
                        $_SESSION['success'] = 'Testimonial status set to pending!';
                    } else {
                        $_SESSION['error'] = 'Failed to update testimonial status. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid testimonial ID.';
                }
                break;
                
            case 'delete':
                if ($testimonial_id > 0) {
                    if ($testimonialQueries->deleteTestimonial($testimonial_id)) {
                        $_SESSION['success'] = 'Testimonial deleted successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to delete testimonial. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid testimonial ID.';
                }
                break;
                
            default:
                $_SESSION['error'] = 'Invalid action specified.';
                break;
        }
    } catch (Exception $e) {
        error_log('Testimonial action failed: ' . $e->getMessage());
        $_SESSION['error'] = 'An error occurred while processing your request. Please try again.';
    }
}

$query_params = [];
if (isset($_GET['page']) && (int)$_GET['page'] > 0) $query_params['page'] = (int)$_GET['page'];
if (isset($_GET['status']) && !empty($_GET['status'])) $query_params['status'] = $_GET['status'];
if (isset($_GET['search']) && !empty($_GET['search'])) $query_params['search'] = $_GET['search'];

$redirect_url = 'manage-testimonials.php';
if (!empty($query_params)) {
    $redirect_url .= '?' . http_build_query($query_params);
}
header('Location: ' . $redirect_url);
exit;
?>