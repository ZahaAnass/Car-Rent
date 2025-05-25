<?php
// Include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/booking_queries.php';
require_once '../includes/queries/car_queries.php';

// Start session
start_session();

// Initialize error variable
$error = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["update_status"])) {
        // Sanitize inputs
        $booking_id = trim(filter_input(INPUT_POST, 'booking_id', FILTER_SANITIZE_NUMBER_INT));
        $new_status = trim(filter_input(INPUT_POST, 'update_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Validate inputs
        if (!validate_booking_id($booking_id)) {
            $error = 'Invalid booking ID.';
        } elseif (!in_array($new_status, ['Confirmed', 'Cancelled', 'Completed'])) {
            $error = 'Invalid status update.';
        } else {
            try {
                // Update booking status
                $bookingQueries = new BookingQueries($pdo);
                $carQueries = new CarQueries($pdo);
                $result = $bookingQueries->updateBookingStatus($booking_id, $new_status);
                $car_id = $bookingQueries->getBookingById($booking_id)['car_id'];
                if($result){
                    switch($new_status){
                        case 'Confirmed':
                            $carQueries->updateCarStatus($car_id, 'Rented');
                            $bookingQueries->updateBookingStatus($booking_id, 'Confirmed');
                            break;
                        case 'Cancelled':
                            $carQueries->updateCarStatus($car_id, 'Available');
                            $bookingQueries->updateBookingStatus($booking_id, 'Cancelled');
                            break;
                        case 'Completed':
                            $carQueries->updateCarStatus($car_id, 'Available');
                            $bookingQueries->updateBookingStatus($booking_id, 'Completed');
                            break;
                    }
                } else {
                    $error = 'Failed to update booking status.';
                }
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
                error_log("Database error in manage-reservation-handeler.php: " . $e->getMessage());
            }
        }
    }
}

// Redirect back to manage bookings page
header('Location: manage-reservations.php' . (isset($_GET['status']) ? '?status=' . $_GET['status'] : ''));
exit;
?>