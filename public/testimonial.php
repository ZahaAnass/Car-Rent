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
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item">
                        <div class="testimonial-quote"><i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="testimonial-inner p-4">
                            <img src="../assets/img/testimonial-1.jpg" class="img-fluid" alt="David Martinez, Business Traveler">
                            <div class="ms-4">
                                <h4>David Martinez</h4>
                                <p>Business Consultant</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top rounded-bottom p-4">
                            <p class="mb-0">"As a frequent business traveler, I've tried numerous car rental services. Zoomix stands out with their impeccable fleet, seamless booking process, and exceptional customer support. They've made my business trips significantly smoother."</p>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-quote"><i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="testimonial-inner p-4">
                            <img src="../assets/img/testimonial-2.jpg" class="img-fluid" alt="Emily Chen, Travel Enthusiast">
                            <div class="ms-4">
                                <h4>Emily Chen</h4>
                                <p>Travel Blogger</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-body"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top rounded-bottom p-4">
                            <p class="mb-0">"Zoomix has been my trusted companion for road trips across the country. Their diverse vehicle selection, competitive pricing, and user-friendly service make every journey an adventure. Highly recommended for fellow travelers!"</p>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-quote"><i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="testimonial-inner p-4">
                            <img src="../assets/img/testimonial-3.jpg" class="img-fluid" alt="Michael Rodriguez, Family Traveler">
                            <div class="ms-4">
                                <h4>Michael Rodriguez</h4>
                                <p>Family Vacationer</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-body"></i>
                                    <i class="fas fa-star text-body"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top rounded-bottom p-4">
                            <p class="mb-0">"Family road trips can be challenging, but Zoomix made our vacation planning effortless. They helped us find the perfect SUV for our needs, with excellent customer service and transparent pricing. We'll definitely use them again!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

<?php require_once '../includes/footer.php'; ?>
