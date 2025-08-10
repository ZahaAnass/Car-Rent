<?php

    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/queries/user_queries.php";
    require_once "../includes/auth_user_check.php";
    
    // Initialize database connection
    $userQueries = new UserQueries($pdo);
    $userData = $userQueries->getUserById($_SESSION['user_id']);

    // Add current email to session for validation 
    $_SESSION['current_email'] = $userData['email'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - Settings</title>

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

    <style>
        /* Custom styles for settings page if needed */
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-section-description {
            font-size: 0.9rem;
            color: #6c757d; /* text-muted */
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto px-md-4 py-5 wow fadeInDown">
                <div class="container-fluid">
                    <!-- Hero Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h1 class="display-6 mb-2 wow fadeInDown">Settings</h1>
                            <p class="text-muted wow fadeInUp" data-wow-delay="0.1s">Manage your account settings and preferences.</p>
                        </div>
                    </div>

                    <!-- Settings Form Card -->
                    <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-header bg-light py-3">
                                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>User Profile</h5>
                                </div>
                        <div class="card-body p-4">
                            <form id="settingsForm" method="POST" action="settings-handler.php">
                                <!-- Personal Information Section -->
                                <h5 class="form-section-title">Personal Information</h5>
                                <p class="form-section-description">Update your personal details.</p>
                                <hr class="mb-4">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" value="<?= htmlspecialchars($userData['first_name']) ?>" name="first_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" value="<?= htmlspecialchars($userData['last_name']) ?>" name="last_name" required>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <input type="hidden" name="current_email" value="<?= htmlspecialchars($userData['email']) ?>" disable>
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($userData['email']) ?>" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" value="<?= htmlspecialchars($userData['phone_number']) ?>" name="phone_number">
                                    </div>
                                </div>
                                <!-- Save Button -->
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bottom Navigation With The Scripts -->
    <?php include '../includes/bottom-nav.php'; ?>

</body>
</html>