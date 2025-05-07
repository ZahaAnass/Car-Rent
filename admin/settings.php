<?php
// Add session start and authentication check if needed
// session_start();
// include '../includes/session.php'; // Assuming you have session handling
// if (!is_admin()) { header('Location: ../login.php'); exit; } 

// --- PHP Logic for settings ---
// Fetch current settings (e.g., site name, admin email) from DB or config file
$current_settings = [
    'admin_first_name' => 'Admin', // Fetch from session or user table
    'admin_last_name' => 'User',    // Fetch from session or user table
    'admin_email' => 'admin@zoomix.com', // Fetch from session or user table
    'admin_phone' => '+1234567890'  // Fetch from session or user table
];

// Handle form submissions (update settings, change password)
$update_message = '';
$error_message = '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoomix Admin - Settings</title>
    
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

    <div class="container-fluid">
        <div class="row">
            
            <!-- Admin Sidebar -->
            <?php require_once '../includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto min-vh-100 px-md-4 py-5">
                <div class="container-fluid">
                    <!-- Page Title -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col">
                            <h1 class="display-6 mb-2">Settings</h1>
                            <p class="text-muted mb-0">Manage site configuration and admin profile.</p>
                        </div>
                    </div>

                    <!-- Display Success/Error Messages -->
                    <?php if ($update_message): ?>
                        <div class="alert alert-success alert-dismissible fade show wow fadeInUp" role="alert">
                            <?= htmlspecialchars($update_message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show wow fadeInUp" role="alert">
                            <?= htmlspecialchars($error_message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Settings Sections -->
                    <div class="row g-4">

                        <!-- Admin Profile Card -->
                        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-light py-3">
                                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Admin Profile</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label for="admin_first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="admin_first_name" name="admin_first_name" value="<?= htmlspecialchars($current_settings['admin_first_name']) ?>" required>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="admin_last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="admin_last_name" name="admin_last_name" value="<?= htmlspecialchars($current_settings['admin_last_name']) ?>" required>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <label for="admin_email" class="form-label">Your Email</label>
                                            <input type="text" class="form-control" id="admin_email" name="admin_email" value="<?= htmlspecialchars($current_settings['admin_email']) ?>" required>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <label for="admin_phone" class="form-label">Your Phone</label>
                                            <input type="text" class="form-control" id="admin_phone" name="admin_phone" value="<?= htmlspecialchars($current_settings['admin_phone']) ?>" required>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        </div>
                                    </form>
                                    <hr>
                                    <h6 class="mt-4 mb-3">Change Password</h6>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End row -->
                </div>
            </main>

        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <?php require_once '../includes/bottom-nav.php'; ?>

</body>
</html>