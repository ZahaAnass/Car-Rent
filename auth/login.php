<?php require_once '../includes/auth_header.php'; ?>

<!-- Login Page Start -->
<div class="container-fluid login-page py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="login-container">
                    <div class="login-header">
                        <h2>Login to <span class="text-primary">Zoomix</span></h2>
                        <p>Welcome back! Please enter your credentials.</p>
                    </div>
                    <form class="login-form" action="#" method="POST">
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control p-3" placeholder="Email Address" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" placeholder="Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group p-2 ps-1 d-flex justify-content-between mb-3 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-primary forgot-password">Forgot Password?</a>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.5s">
                            <button type="submit" class="btn btn-primary w-100 p-3">
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

<?php require_once '../includes/auth_footer.php'; ?>