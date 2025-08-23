<?php
require_once '../includes/session.php';
start_session();

require_once '../includes/functions.php';
require_once '../config/database.php';
require_once '../includes/queries/user_queries.php';

if (is_logged_in()) {
    if (is_admin()) {
        redirect('../admin/dashboard.php');
    } else {
        redirect('../user/dashboard.php');
    }
}

// Check if user is trying to access reset password page without a valid session
if (!isset($_SESSION['reset_token']) || !isset($_SESSION['reset_email'])) {
    redirect('../auth/forgot-password.php');
}

$token = $_SESSION['reset_token'];
$email = $_SESSION['reset_email'];

// Get user info for display
try {
    $userQueries = new UserQueries($pdo);
    $userData = $userQueries->verifyToken($token);
    
    if (!$userData) {
        $_SESSION['login_error'] = 'Invalid session. Please start the password reset process again.';
        unset($_SESSION['reset_token'], $_SESSION['reset_email']);
        redirect('../auth/forgot-password.php');
    }

    $userQueries = new UserQueries($pdo);
    $userData = $userQueries->getUserFromToken($token, $email);
    
    if (!$userData) {
        $_SESSION['login_error'] = 'Invalid session. Please start the password reset process again.';
        unset($_SESSION['reset_token'], $_SESSION['reset_email']);
        redirect('../auth/forgot-password.php');
    }
} catch (Exception $e) {
    error_log("Reset password validation error: " . $e->getMessage());
    redirect('../auth/forgot-password.php');
}

require_once '../includes/auth_header.php';

// Check for messages
$error_message = '';
if (isset($_SESSION['reset_error'])) {
    $error_message = $_SESSION['reset_error'];
    unset($_SESSION['reset_error']);
}
?>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Reset Password Page Start -->
<div class="container-fluid login-page py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="login-container">
                    <div class="login-header">
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                        </div>
                        <h2>Create New <span class="text-primary">Password</span></h2>
                        <p>Hello <?= htmlspecialchars($userData['first_name']) ?>! Please enter your new password.</p>
                    </div>
                    
                    <form class="login-form" action="reset-password-handler.php" method="POST">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" name="password" placeholder="New Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                            <small class="text-muted">Password must be at least 8 characters with uppercase, lowercase, and number</small>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" name="confirm_password" placeholder="Confirm New Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.4s">
                            <button type="submit" name="reset_password" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-key me-2"></i>Update Password
                            </button>
                        </div>
                        
                        <div class="login-footer text-center mt-4 wow fadeInUp" data-wow-delay="0.5s">
                            <p>Remember your password? 
                                <a href="login.php" class="text-primary">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password Page End -->

<script defer src="../assets/js/login-validation.js"></script>

<?php require_once '../includes/auth_footer.php'; ?>
