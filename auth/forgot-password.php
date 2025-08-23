<?php
require_once '../includes/session.php';
start_session();

require_once '../includes/functions.php';

if (is_logged_in()) {
    if (is_admin()) {
        redirect('../admin/dashboard.php');
    } else {
        redirect('../user/dashboard.php');
    }
}

require_once '../includes/auth_header.php';

// Check for messages
$error_message = '';
$success_message = '';
if (isset($_SESSION['forgot_error'])) {
    $error_message = $_SESSION['forgot_error'];
    unset($_SESSION['forgot_error']);
}
if (isset($_SESSION['forgot_success'])) {
    $success_message = $_SESSION['forgot_success'];
    unset($_SESSION['forgot_success']);
}
?>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Forgot Password Page Start -->
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
                
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($success_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="login-container">
                    <div class="login-header">
                        <h2>Reset <span class="text-primary">Password</span></h2>
                        <p>Enter your email address and we'll send you a verification code to reset your password.</p>
                    </div>
                    
                    <form class="login-form" action="forgot-password-handler.php" method="POST">
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control p-3" name="email" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.3s">
                            <button type="submit" name="forgot_password" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-paper-plane me-2"></i>Send Verification Code
                            </button>
                        </div>
                        
                        <div class="login-footer text-center mt-4 wow fadeInUp" data-wow-delay="0.4s">
                            <p>Remember your password? 
                                <a href="login.php" class="text-primary">Login here</a>
                            </p>
                            <p>Don't have an account? 
                                <a href="register.php" class="text-primary">Register here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Page End -->

<?php require_once '../includes/auth_footer.php'; ?>
