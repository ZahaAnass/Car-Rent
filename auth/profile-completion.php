<?php 
require_once '../includes/session.php';
start_session();

require_once '../includes/functions.php';
require_once '../config/database.php';
require_once '../includes/queries/user_queries.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('../auth/login.php');
}

$userQueries = new UserQueries($pdo);
$user = $userQueries->getUserById($_SESSION['user_id']);

// Check if profile is already complete
if ($userQueries->isProfileComplete($_SESSION['user_id'])) {
    redirect('../user/dashboard.php');
}

require_once '../includes/auth_header.php'; 

// Handle form submission
$error_message = '';
if (isset($_SESSION['profile_error'])) {
    $error_message = $_SESSION['profile_error'];
    unset($_SESSION['profile_error']);
}
?>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Complete Profile Page Start -->
<div class="container-fluid register-page py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="register-container">
                    <div class="register-header">
                        <h2>Complete Your <span class="text-primary">Zoomix</span> Profile</h2>
                        <p>Welcome <?= htmlspecialchars($user['first_name']) ?>! Please complete your profile to continue.</p>
                    </div>
                    
                    <form class="register-form" action="profile-completion-handler.php" method="POST">
                        <?php if (!empty($error_message)): ?>
                        <div class="col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error_message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control p-3" placeholder="Phone Number (e.g., 0612345678)" name="phone" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" id="license_number" name="license_number" class="form-control p-3" placeholder="License Number" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <select name="country" id="country" class="form-select p-3" required>
                                    <option value="" selected disabled>Select Country</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.6s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                <select name="city" id="city" class="form-select p-3" required>
                                    <option value="" selected disabled>Select City</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.7s">
                            <button type="submit" name="complete_profile" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-check me-2"></i>Complete Profile
                            </button>
                        </div>
                        
                        <div class="register-footer text-center mt-4 wow fadeInUp" data-wow-delay="0.8s">
                            <p class="text-muted small">
                                All fields are required to use our car rental services.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Complete Profile Page End -->

<script defer src="../assets/js/countries.js"></script>

<?php require_once '../includes/auth_footer.php'; ?>