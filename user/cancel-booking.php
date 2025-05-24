<?php
    require_once "../includes/queries/booking_queries.php";
    require_once "../includes/session.php";
    require_once "../includes/functions.php";
    require_once "../config/database.php";
    
    start_session();
    
    if(isset($_POST['booking_id'])) {
        $booking_id = $_POST['booking_id'];
        $user_id = $_SESSION['user_id'];

        $bookingQueries = new BookingQueries($pdo);
        $booking = $bookingQueries->getBookingById($booking_id);
        
        if($booking && $booking['user_id'] == $user_id) {
            $result = $bookingQueries->cancelBooking($booking_id);
            if($result) {
                $_SESSION['success'] = "Booking cancelled successfully.";
                redirect("my-reservations.php");
            } else {
                $_SESSION['error'] = "Failed to cancel booking.";
                redirect("my-reservations.php");
            }
        } else {
            $_SESSION['error'] = "You are not authorized to cancel this booking.";
            redirect("my-reservations.php");
        }
    }