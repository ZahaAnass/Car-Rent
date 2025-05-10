<?php require_once '../includes/auth_header.php'; ?>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Register Page Start -->
<div class="container-fluid register-page py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="register-container">
                    <div class="register-header">
                        <h2>Create <span class="text-primary">Zoomix</span> Account</h2>
                        <p>Join our community and start your journey!</p>
                    </div>
                    
                    <form class="register-form" action="#" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3 wow fadeInUp" data-wow-delay="0.2s">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control p-3" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control p-3" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control p-3" placeholder="Email Address" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control p-3" placeholder="Phone Number" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="license_number" id="license_number" class="form-control p-3" placeholder="License Number" required>
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

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                <select name="city" id="city" class="form-select p-3" required>
                                    <option value="" selected disabled>Select City</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.6s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" placeholder="Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 wow fadeInUp" data-wow-delay="0.7s">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control p-3" placeholder="Confirm Password" required>
                                <span class="input-group-text toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 p-2 ps-1 wow fadeInUp" data-wow-delay="0.8s">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-agree" required>
                                <label class="form-check-label" for="terms-agree">
                                    I agree to the <a href="../public/terms.php" class="text-primary">Terms & Conditions</a>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group wow fadeInUp" data-wow-delay="0.9s">
                            <button type="submit" class="btn btn-primary form-btn w-100 p-3">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                        </div>

                        <div class="login-divider wow fadeInUp" data-wow-delay="0.6s">
                            <span>or</span>
                        </div>
                        
                        <div class="social-login wow fadeInUp" data-wow-delay="0.7s">
                            <button type="button" class="btn btn-google p-3">
                                <i class="fab fa-google me-2"></i>Register with Google
                            </button>
                            <button type="button" class="btn btn-facebook p-3">
                                <i class="fab fa-facebook me-2"></i>Register with Facebook
                            </button>
                        </div>
                        
                        <div class="register-footer text-center mt-4 wow fadeInUp" data-wow-delay="1s">
                            <p>Already have an account? 
                                <a href="login.php" class="text-primary">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Page End -->

<script defer src="../assets/js/countries.js"></script>

<?php require_once '../includes/auth_footer.php'; ?>