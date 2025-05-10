<?php
    $company_name = "Zoomix";
    $current_year = date('Y');
    $contact_email = "info@zoomixrentals.com";
    $contact_phone = "+212 (522) 987-654";
    $address = "Boulevard Mohammed V, Casablanca 20250, Morocco";
?>

<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- About Us Section -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-primary mb-4">About <?php echo $company_name; ?></h4>
                    <p class="mb-3">Providing premium car rental services with comfort, convenience, and reliability. Your journey starts with us.</p>
                    
                    <!-- Newsletter Signup -->
                    <div class="position-relative mt-3">
                        <form id="newsletter-form" action="#" method="POST">
                            <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" 
                                    type="email" 
                                    name="newsletter_email" 
                                    placeholder="Enter your email" 
                                    required>
                            <button type="submit" 
                                    class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">
                                <i class="fas fa-paper-plane me-2"></i>Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4">Quick Links</h4>
                    <?php 
                    $links = [
                        '../public/about.php' => 'About',
                        '../public/cars.php' => 'Cars',
                        '../public/team.php' => 'Team',
                        '../public/contact.php' => 'Contact Us',
                        '../public/terms.php' => 'Terms & Conditions',
                        '../public/privacy.php' => 'Privacy Policy'
                    ];
                    
                    foreach ($links as $url => $title):
                    ?>
                        <a href="<?php echo $url; ?>">
                            <i class="fas fa-angle-right me-2"></i> <?php echo $title; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Business Hours -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4">Business Hours</h4>
                    <?php 
                    $hours = [
                        'Mon - Friday' => '09:00 AM to 07:00 PM',
                        'Saturday' => '10:00 AM to 05:00 PM',
                        'Sunday' => 'Closed'
                    ];
                    
                    foreach ($hours as $day => $time):
                    ?>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0"><?php echo $day; ?>:</h6>
                            <p class="text-white mb-0"><?php echo $time; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4">Contact Info</h4>
                    <a href="#"><i class="fa fa-map-marker-alt me-2"></i> <?php echo $address; ?></a>
                    <a href="mailto:<?php echo $contact_email; ?>"><i class="fas fa-envelope me-2"></i> <?php echo $contact_email; ?></a>
                    <a href="tel:<?php echo $contact_phone; ?>"><i class="fas fa-phone me-2"></i> <?php echo $contact_phone; ?></a>
                    
                    <div class="d-flex mt-3">
                        <?php 
                        $social_links = [
                            'https://facebook.com/zoomix' => 'fab fa-facebook-f',
                            'https://twitter.com/zoomix' => 'fab fa-twitter',
                            'https://instagram.com/zoomix' => 'fab fa-instagram',
                            'https://linkedin.com/company/zoomix' => 'fab fa-linkedin-in'
                        ];
                        
                        foreach ($social_links as $url => $icon):
                        ?>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href="<?php echo $url; ?>" target="_blank">
                                <i class="<?php echo $icon; ?> text-white"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-start mb-md-0">
                <span class="text-body">
                    <a href="#" class="border-bottom text-white">
                        <i class="fas fa-copyright text-light me-2"></i>
                        <?php echo $company_name; ?> <?php echo $current_year; ?>
                    </a>
                    , All rights reserved.
                </span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                Designed by <a href="#" class="text-white">Zaha Anass</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- Performance Optimization: Defer JavaScript Loading -->
<script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="../assets/lib/wow/wow.min.js"></script>
<script defer src="../assets/lib/easing/easing.min.js"></script>
<script defer src="../assets/lib/waypoints/waypoints.min.js"></script>
<script defer src="../assets/lib/counterup/counterup.min.js"></script>
<script defer src="../assets/lib/owlcarousel/owl.carousel.min.js"></script>
<script defer src="../assets/lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script defer src="../assets/js/main.js"></script>
</body>
</html>