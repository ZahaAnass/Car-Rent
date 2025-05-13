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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Our Cars</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white">Pages</li>
                    <li class="breadcrumb-item active text-primary">Categories</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <?php
        // Handle the "Book Now" POST and session setting
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_car_id'])) {
            $_SESSION['selected_car_id'] = (int)$_POST['selected_car_id'];
            header('Location: ../user/book-car.php');
            exit();
        }
        ?>

        <!-- Car categories Start -->
        <div class="container-fluid categories py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Vehicle <span class="text-primary">Categories</span></h1>
                    <p class="mb-0">Explore our diverse fleet of premium vehicles designed to meet your every need. From compact city cars to luxurious electric models, we have the perfect ride for your journey.</p>
                </div>

                <?php
                    require_once '../includes/queries/car_queries.php';
                    $carQueries = new CarQueries($pdo); 
                    $all_cars = $carQueries->getAvailableCars(); 

                    if (!isset($all_cars) || empty($all_cars)) {
                        echo '<p class="text-center">No cars available at the moment.</p>';
                    } else {
                        // Get all car types
                        $carTypesResult = $carQueries->getCarTypes();
                        $carTypes = [];
                        
                        // Extract the type values from the result
                        foreach ($carTypesResult as $typeRow) {
                            $carTypes[] = $typeRow['type'];
                        }
                        
                        // Group cars by their type
                        $carsByCategory = [];
                        foreach ($all_cars as $car) {
                            $type = $car['type'];
                            if (!isset($carsByCategory[$type])) {
                                $carsByCategory[$type] = [];
                            }
                            $carsByCategory[$type][] = $car;
                        }
                        
                        // Display each category
                        foreach ($carTypes as $category):
                            if (isset($carsByCategory[$category]) && !empty($carsByCategory[$category])):
                ?>
                <div class="category-section mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h2 class="text-primary text-capitalize mb-4 text-center"><?php echo htmlspecialchars($category); ?> Cars</h2>
                    <div class="categories-carousel owl-carousel">
                        <?php foreach ($carsByCategory[$category] as $car): ?>
                            <div class="categories-item p-4 h-100"> 
                                <div class="categories-item-inner d-flex flex-column h-100"> 
                                    <div class="categories-img rounded-top">
                                        <img src="<?php echo !empty($car['image_url']) ? htmlspecialchars($car['image_url']) : '../assets/img/default-car.webp'; ?>" class="img-fluid w-100 rounded-top" alt="<?php echo htmlspecialchars($car['name'] ?? 'Car image'); ?>" style="height: 200px; object-fit: cover;"> 
                                    </div>
                                    <div class="categories-content rounded-bottom p-4 d-flex flex-column flex-grow-1"> 
                                        <h4><?php echo htmlspecialchars($car['name'] ?? 'N/A'); ?></h4>
                                        
                                        <?php 
                                        $rating = $car['average_rating'] ?? 0; 
                                        $review_count = $car['review_count'] ?? 0; 
                                        ?>
                                        <div class="categories-review mb-4">
                                            <div class="me-3"><?php echo number_format($rating, 1); ?> Review (<?php echo $review_count; ?>)</div>
                                            <div class="d-flex justify-content-center text-secondary">
                                                <?php 
                                                $stars = round($rating); 
                                                for ($i = 1; $i <= 5; $i++): 
                                                    echo '<i class="fas fa-star' . ($i > $stars ? ' text-body' : '') . '"></i>';
                                                endfor; 
                                                ?>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$<?php echo htmlspecialchars(number_format($car['daily_rate'] ?? 0, 2)); ?>/Day</h4>
                                        </div>
                                        <div class="row gy-2 gx-0 text-center mb-4">
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-users text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($car['seats'] ?? 'N/A'); ?> Seat</span>
                                            </div>
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-calendar-alt text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($car['year'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2 mb-sm-0">
                                                <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($car['fuel_type'] ?? 'N/A'); ?></span>
                                            </div>
                                            <?php 
                                            $transmission = 'N/A';
                                            if (!empty($car['features'])) {
                                                if (stripos($car['features'], 'Automatic') !== false || stripos($car['features'], 'Auto') !== false) {
                                                    $transmission = 'Automatic';
                                                } elseif (stripos($car['features'], 'Manual') !== false) {
                                                    $transmission = 'Manual';
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-4 border-end border-white mt-2">
                                                <i class="fa fa-cogs text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($transmission); ?></span>
                                            </div>
                                            <div class="col-sm-4 border-end border-white mt-2">
                                                <i class="fa fa-palette text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($car['color'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="col-sm-4 mt-2">
                                                <i class="fa fa-car text-dark"></i> <span class="text-body ms-1"><?php echo htmlspecialchars($car['status'] ?? 'N/A'); ?></span>
                                            </div>

                                        </div>
                                        <div class="mt-auto"> 
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <input type="hidden" name="selected_car_id" value="<?php echo htmlspecialchars($car['car_id'] ?? ''); ?>">
                                                <button type="submit" class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100">Book Now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
                            endif; 
                        endforeach;
                    }
                ?>
            </div>
        </div>
        <!-- Car categories End -->

        <!-- Car Steps Start -->
        <div class="container-fluid steps py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize text-white mb-3">Zoomix<span class="text-primary"> Process</span></h1>
                    <p class="mb-0 text-white">Experience the simplicity of our car rental process. From initial contact to enjoying your drive, we ensure a smooth and stress-free journey.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Come In Contact</h4>
                            <p class="mb-0">Reach out to our friendly team. We're here to help you find the perfect vehicle for your needs.</p>
                            <div class="setps-number">01.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Choose A Car</h4>
                            <p class="mb-0">Find the perfect car for your needs and budget. Our diverse fleet offers options for every occasion.</p>
                            <div class="setps-number">02.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Enjoy Driving</h4>
                            <p class="mb-0">Quick pickup, seamless handover. Enjoy your journey with our full support.</p>
                            <div class="setps-number">03.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Car Steps End -->

        <!-- Banner Start -->
        <div class="container-fluid banner py-5 wow zoomInDown" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="banner-item rounded">
                    <img src="../assets/img/banner-1.jpg" class="img-fluid rounded w-100" alt="Car Rental Banner">
                    <div class="banner-content">
                        <h2 class="text-primary">Your Journey Starts Here</h2>
                        <h1 class="text-white">Ready to Hit the Road?</h1>
                        <p class="text-white">Discover the perfect vehicle for your next adventure. Quick, easy, and hassle-free rentals.</p>
                        <div class="banner-btn">
                            <a href="#" class="btn btn-secondary rounded-pill py-3 px-4 px-md-5 me-2">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                            <a href="contact.php" class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2">
                                <i class="fas fa-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->

<?php require_once '../includes/footer.php'; ?>
