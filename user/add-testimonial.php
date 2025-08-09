<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - Add Testimonial</title>
    
    <!-- Favicon -->
    <link href="../assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../assets/css/style.css" rel="stylesheet">

</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <?php 
        require_once '../config/database.php';
        require_once '../includes/queries/user_queries.php';
        require_once '../includes/functions.php';
        require_once '../includes/session.php';
        require_once '../includes/auth_user_check.php';
        start_session();

        $user = new UserQueries($pdo);
        $userData = $user->getUserById($_SESSION['user_id']);

        $pageTitle = "Add Testimonial";
        $displayName = $userData['first_name'] . ' ' . $userData['last_name'];
    ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto px-4 wow fadeInDown" style="min-height: 100vh;">
                <div class="container-fluid py-5">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mb-3 display-6 wow fadeInDown">Submit Your Testimonial</h1>
                            <p class="text-muted wow fadeInUp">Share your experience with us. Your feedback helps us improve!</p>
                        </div>
                    </div>

                    <?php if (!empty($_SESSION['successMessage'])): ?>
                        <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay="0.2s" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['successMessage']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['successMessage']); ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['errorMessage'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show wow fadeInUp" data-wow-delay="0.2s" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $_SESSION['errorMessage']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['errorMessage']); ?>
                    <?php endif; ?>

                    <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.3s">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0"><i class="fas fa-pencil-alt me-2"></i>Write Your Testimonial</h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="testimonialForm" method="POST" action="testimonial-handler.php">
                                <div class="mb-3">
                                    <label for="displayName" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="displayName" name="displayName" value="<?php echo $displayName; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select class="form-select" id="rating" name="rating">
                                        <option value="" <?php if ($rating === '') echo 'selected'; ?>>Select a rating</option>
                                        <option value="5" <?php if ($rating === '5' || $rating === 5) echo 'selected'; ?>>★★★★★ (Excellent)</option>
                                        <option value="4" <?php if ($rating === '4' || $rating === 4) echo 'selected'; ?>>★★★★☆ (Great)</option>
                                        <option value="3" <?php if ($rating === '3' || $rating === 3) echo 'selected'; ?>>★★★☆☆ (Good)</option>
                                        <option value="2" <?php if ($rating === '2' || $rating === 2) echo 'selected'; ?>>★★☆☆☆ (Fair)</option>
                                        <option value="1" <?php if ($rating === '1' || $rating === 1) echo 'selected'; ?>>★☆☆☆☆ (Poor)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="testimonialText" class="form-label">Your Testimonial</label>
                                    <textarea class="form-control" id="testimonialText" name="testimonialText" rows="5" required><?php echo $testimonialText; ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane me-2"></i>Submit Testimonial</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/bottom-nav.php'; // General scripts and closing tags ?>

</body>
</html>