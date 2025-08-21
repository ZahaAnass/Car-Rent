<?php require_once '../includes/header.php'; ?>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Our Testimonial</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white">Pages</li>
                    <li class="breadcrumb-item active text-primary">Testimonial</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Our Clients<span class="text-primary"> Reviews</span></h1>
                    <p class="mb-0">Hear directly from our satisfied customers who have experienced the Zoomix difference. Their stories showcase our commitment to exceptional service, reliability, and unforgettable travel experiences.</p>
                </div>
                
                <?php
                    require_once '../includes/queries/testimonial_queries.php';
                    $testimonialQueries = new TestimonialQueries($pdo);
                    
                    // Get only approved testimonials
                    $approvedTestimonials = $testimonialQueries->getAllTestimonialsWithFilter('Approved');
                    
                    if (!empty($approvedTestimonials)):
                ?>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <?php 
                        $imageCount = 3; // We have 3 testimonial images available
                        $imageIndex = 1;
                        
                        foreach ($approvedTestimonials as $testimonial): 
                            // Cycle through the available images
                            $imagePath = "../assets/img/testimonial-" . $imageIndex . ".jpg";
                            $imageIndex = ($imageIndex % $imageCount) + 1;
                    ?>
                    <div class="testimonial-item">
                        <div class="testimonial-quote"><i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="testimonial-inner p-4">
                            <img src="<?php echo $imagePath; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($testimonial['user_name_display']); ?>">
                            <div class="ms-4">
                                <h4><?php echo htmlspecialchars($testimonial['user_name_display']); ?></h4>
                                <p><?php echo !empty($testimonial['first_name']) ? htmlspecialchars($testimonial['first_name'] . ' ' . $testimonial['last_name']) : 'Customer'; ?></p>
                                <div class="d-flex text-primary">
                                    <?php 
                                        $rating = (int)$testimonial['rating'];
                                        // Show filled stars for the rating
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="fas fa-star text-body"></i>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="border-top rounded-bottom p-4">
                            <p class="mb-0">"<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>"</p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-comment-slash fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted">No testimonials available yet</h3>
                    <p class="text-muted">Be the first to share your experience with us!</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../user/submit-testimonial.php" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Submit a Testimonial
                    </a>
                    <?php else: ?>
                    <a href="../auth/login.php" class="btn btn-primary mt-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Submit a Testimonial
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Testimonial End -->

<?php require_once '../includes/footer.php'; ?>
