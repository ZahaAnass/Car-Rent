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

// Check if user came from forgot password step
if (!isset($_SESSION['reset_email'])) {
    redirect('../auth/forgot-password.php');
}

require_once '../includes/auth_header.php';

// Check for messages
$error_message = '';
if (isset($_SESSION['verify_error'])) {
    $error_message = $_SESSION['verify_error'];
    unset($_SESSION['verify_error']);
}
?>

<!-- Verify Code Page Start -->
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
                        <h2>Enter <span class="text-primary">Verification Code</span></h2>
                        <p>We've sent a 6-digit verification code to <strong><?= htmlspecialchars($_SESSION['reset_email']) ?></strong></p>
                        <p class="text-muted small">Code expires in 15 minutes</p>
                    </div>
                    
                    <form class="login-form" action="verify-code-handler.php" method="POST">
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="text" class="form-control p-3 text-center" name="code" placeholder="Enter 6-digit code" 
                                        maxlength="6" pattern="[0-9]{6}" style="font-size: 18px; letter-spacing: 3px;" required>
                            </div>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.3s">
                            <button type="submit" name="verify_code" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-check me-2"></i>Verify Code
                            </button>
                        </div>
                        
                        <div class="login-footer text-center mt-4 wow fadeInUp" data-wow-delay="0.4s">
                            <p>Didn't receive the code? 
                                <a href="send-code-again.php" class="text-primary">Send again</a>
                            </p>
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
<!-- Verify Code Page End -->

<script>
// Auto-format the code input and submit on 6 digits
document.querySelector('input[name="code"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    if (this.value.length === 6) {
        document.querySelector('button[name="verify_code"]').click();
    }
});
</script>

<?php require_once '../includes/auth_footer.php'; ?>
