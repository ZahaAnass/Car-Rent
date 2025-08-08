<?php
// Start session and include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/user_queries.php';

// Start session and check if user is logged in
start_session();

// Initialize database and queries
$database = new Database();
$db = $database->getConnection();
$userQueries = new UserQueries($db);

// Initialize variables
$success_message = '';
$error_message = '';

// Get current user data
$userData = [];
if (isset($_SESSION['user_id'])) {
    $userData = $userQueries->getUserById($_SESSION['user_id']);
    if (!$userData) {
        // Handle case where user is not found
        header('Location: login.php');
        exit();
    }
} else {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $license_number = trim(filter_input(INPUT_POST, 'license_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $address_country = trim(filter_input(INPUT_POST, 'address_country', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $address_city = trim(filter_input(INPUT_POST, 'address_city', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    // Basic validation
    $is_valid = true;
    
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $error_message = 'Please fill in all required fields';
        $is_valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address';
        $is_valid = false;
    } elseif ($email !== $userData['email'] && $userQueries->emailExists($email)) {
        $error_message = 'This email is already registered';
        $is_valid = false;
    } elseif (!empty($license_number) && $license_number !== $userData['license_number'] && $userQueries->licenseExists($license_number)) {
        $error_message = 'This license number is already registered';
        $is_valid = false;
    }

    if ($is_valid) {
        // Update user data
        if ($userQueries->updateUserProfile(
            $_SESSION['user_id'],
            $first_name,
            $last_name,
            $email,
            $phone_number,
            $address_country,
            $address_city
        )) {
            // Update license number separately if changed
            if (!empty($license_number) && $license_number !== $userData['license_number']) {
                $stmt = $db->prepare("UPDATE users SET license_number = :license_number WHERE user_id = :user_id");
                $stmt->execute([
                    'license_number' => $license_number,
                    'user_id' => $_SESSION['user_id']
                ]);
            }
            
            // Refresh user data
            $userData = $userQueries->getUserById($_SESSION['user_id']);
            $success_message = 'Profile updated successfully!';
        } else {
            $error_message = 'Failed to update profile. Please try again.';
        }
    }
}

// Include the header after any potential redirects
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

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>Changes saved successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

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
                            <?php if ($error_message): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                            <?php endif; ?>
                            <?php if ($success_message): ?>
                                <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
                            <?php endif; ?>
                            <form id="settingsForm" method="POST" action="">
                                <!-- Personal Information Section -->
                                <h5 class="form-section-title">Personal Information</h5>
                                <p class="form-section-description">Update your personal details.</p>
                                <hr class="mb-4">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($userData['first_name'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($userData['last_name'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($userData['phone_number'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="address_country" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="address_country" name="address_country" value="<?= htmlspecialchars($userData['address_country'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address_city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="address_city" name="address_city" value="<?= htmlspecialchars($userData['address_city'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="license_number" class="form-label">Driver's License Number</label>
                                    <input type="text" class="form-control" id="license_number" name="license_number" value="<?= htmlspecialchars($userData['license_number'] ?? '') ?>">
                                    <small class="text-muted">Leave blank if you don't have a license number</small>
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