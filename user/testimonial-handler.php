<?php

    require_once '../includes/session.php';
    start_session();
    require_once '../config/database.php';
    require_once '../includes/queries/testimonial_queries.php';
    require_once '../includes/queries/user_queries.php';
    require_once '../includes/functions.php';

    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }

    $testimonialQueries = new TestimonialQueries($pdo);
    $user = new UserQueries($pdo);

    $userData = $user->getUserById($_SESSION['user_id']);

    $pageTitle = 'Add Testimonial';
    $displayName = $userData['first_name'] . ' ' . $userData['last_name'];
    $testimonialText = '';
    $rating = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $displayName = htmlspecialchars(trim($_POST['displayName']));
        $testimonialText = htmlspecialchars(trim($_POST['testimonialText']));
        $ratingInput = isset($_POST['rating']) && $_POST['rating'] !== '' ? intval($_POST['rating']) : null;

        if (empty($displayName) || empty($testimonialText)) {
            $_SESSION['errorMessage'] = 'Please fill in your name and testimonial text.';
            redirect('add-testimonial.php');
        } elseif ($ratingInput !== null && ($ratingInput < 1 || $ratingInput > 5)) {
            $_SESSION['errorMessage'] = 'Invalid rating selected. Please choose between 1 and 5, or leave it blank.';
            redirect('add-testimonial.php');
        } else {
            $_SESSION['successMessage'] = 'Thank you! Your testimonial has been submitted for review.';
            $displayName = $userData['first_name'] . ' ' . $userData['last_name'];
            $testimonialText = $_POST['testimonialText'];
            $rating = $_POST['rating'];

            $testimonialQueries->createTestimonial($userData['user_id'], $displayName, $testimonialText, $rating);
            redirect('add-testimonial.php');
        }
    }
?>
