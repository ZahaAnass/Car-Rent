<?php
    require_once '../includes/session.php';
    start_session();

    require_once '../includes/functions.php';
    require_once '../includes/auth_header.php'; 

    if (is_logged_in() && is_admin()) {
        redirect('../admin/index.php');
    }elseif (is_logged_in() && !is_admin()) {
        redirect('../user/index.php');
    }

    $error = $_SESSION['login_error'] ?? '';
    unset($_SESSION['login_error']);

?>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Login Page Start -->
<div class="container-fluid login-page py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="login-container">
                    <div class="login-header">
                        <h2>Login to <span class="text-primary">Zoomix</span></h2>
                        <p>Welcome back! Please enter your credentials.</p>
                    </div>
                    <form class="login-form" action="login-handeler.php" method="POST">
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control p-3" name="email" placeholder="Email Address" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" name="password" placeholder="Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group p-2 ps-1 d-flex justify-content-between mb-3 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-primary forgot-password">Forgot Password?</a>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.5s">
                            <button type="submit" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                        
                        <div class="login-divider wow fadeInUp" data-wow-delay="0.6s">
                            <span>or</span>
                        </div>
                        
                        <div class="social-login wow fadeInUp" data-wow-delay="0.7s">
                            <button type="button" class="btn btn-google p-3">
                                <i class="fab fa-google me-2"></i>Login with Google
                            </button>
                            <button type="button" class="btn btn-facebook p-3">
                                <i class="fab fa-facebook me-2"></i>Login with Facebook
                            </button>
                        </div>
                        
                        <div class="login-footer text-center mt-4 wow fadeInUp" data-wow-delay="0.8s">
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
<!-- Login Page End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector(".login-form");
    const emailInput = document.querySelector("input[name='email']");
    const passwordInput = document.querySelector("input[name='password']");
    const togglePassword = document.querySelector('.toggle-password');

    // Enhanced Email Validation
    function validateEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }

    // Enhanced Password Validation
    function validatePassword(password) {
        // At least 8 characters, one uppercase, one lowercase, one number
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        return passwordRegex.test(password);
    }

    // Real-time validation
    emailInput.addEventListener('input', function() {
        if (!validateEmail(this.value)) {
            this.setCustomValidity("Please enter a valid email address");
        } else {
            this.setCustomValidity("");
        }
    });

    passwordInput.addEventListener('input', function() {
        if (!validatePassword(this.value)) {
            this.setCustomValidity("Password must be at least 8 characters, include uppercase, lowercase, and number");
        } else {
            this.setCustomValidity("");
        }
    });

    // Form submission validation
    loginForm.addEventListener("submit", function(e) {
        // Reset custom validities
        emailInput.setCustomValidity("");
        passwordInput.setCustomValidity("");

        // Validate email
        if (!validateEmail(emailInput.value)) {
            e.preventDefault();
            emailInput.setCustomValidity("Please enter a valid email address");
            emailInput.reportValidity();
            return false;
        }

        // Validate password
        if (!validatePassword(passwordInput.value)) {
            e.preventDefault();
            passwordInput.setCustomValidity("Password must be at least 8 characters, include uppercase, lowercase, and number");
            passwordInput.reportValidity();
            return false;
        }

        return true;
    });

    // Error message handling
    <?php if (!empty($error)): ?>
    (function() {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'alert alert-danger mt-3';
        errorContainer.textContent = "<?php echo htmlspecialchars($error); ?>";
        loginForm.insertBefore(errorContainer, loginForm.firstChild);
    })();
    <?php endif; ?>
});

</script>

<?php require_once '../includes/auth_footer.php'; ?>