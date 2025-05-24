<?php require_once '../includes/header.php'; ?>

        <style>
            .categories-carousel .owl-stage {
                display: flex;
            }
                
            .categories-carousel .owl-item {
                display: flex;
                flex: 1 0 auto;
            }
                
            .categories-item {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
            }
                
            .categories-item-inner {
                display: flex;
                flex-direction: column;
                height: 100%;
            }
                
            .categories-content {
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }
            .categories-carousel .owl-stage-outer {
                padding-bottom: 15px;
            }
        </style>

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

        <!-- Car categories Start -->
        <div class="container-fluid categories py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Vehicle <span class="text-primary">Categories</span></h1>
                    <p class="mb-0">Explore our diverse fleet of premium vehicles designed to meet your every need. From compact city cars to luxurious electric models, we have the perfect ride for your journey.</p>
                </div>

                <div class="filter-button text-center mb-4">
                    <button class="btn btn-primary me-2 mb-2" onclick="filterCars('All')" data-wow-delay="0.1s"><i class="fas fa-car me-2"></i>All Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Luxury')" data-wow-delay="0.1s"><i class="fas fa-crown me-2"></i>Luxury Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Economy')" data-wow-delay="0.2s"><i class="fas fa-coins me-2"></i>Economy Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Electric')" data-wow-delay="0.3s"><i class="fas fa-bolt me-2"></i>Electric Cars</button>
                    <button class="btn btn-outline-primary mb-2" onclick="filterCars('SUV')" data-wow-delay="0.4s"><i class="fas fa-truck me-2"></i>SUV Cars</button>
                </div>

                <?php
                    require_once '../includes/queries/car_queries.php';
                    $carQueries = new CarQueries($pdo); 
                    $all_cars = $carQueries->getAllCars(); 

                    if (!isset($all_cars) || empty($all_cars)) {
                        echo '<p class="text-center">No cars available at the moment.</p>';
                    } else {
                        // Define car types based on ENUM values
                        $carTypes = ['Electric', 'SUV', 'Luxury', 'Economy'];
                        
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

                <div class="category-section mb-5 wow fadeInUp" data-wow-delay="0.1s" id="<?= htmlspecialchars($category); ?>" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2 class="text-primary text-capitalize mb-4 text-center" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);">
                        <i class="fas fa-car" style="margin-right: 10px;"></i>
                        <?= htmlspecialchars($category); ?> Cars
                    </h2>
                    <p class="text-center mb-4" style="font-size: 1.1rem; color: #6c757d;">Explore our selection of <?= strtolower(htmlspecialchars($category)); ?> cars, perfect for your next adventure!</p>
                    <div class="categories-carousel owl-carousel">
                        <?php foreach ($carsByCategory[$category] as $car): ?>
                            <div class="categories-item p-4"> 
                                <div class="categories-item-inner d-flex flex-column h-100 position-relative"> 
                                    <!-- Status Badge -->
                                    <?php 
                                        $status = $car['status'] ?? 'Available';
                                        $statusColor = 'success';
                                        $statusIcon = 'fa-check-circle';
                                                        
                                        if ($status == 'Rented') {
                                            $statusColor = 'warning';
                                            $statusIcon = 'fa-clock';
                                        } elseif ($status == 'Maintenance') {
                                            $statusColor = 'info';
                                            $statusIcon = 'fa-tools';
                                        } elseif ($status == 'Unavailable') {
                                            $statusColor = 'danger';
                                            $statusIcon = 'fa-ban';
                                        }
                                    ?>
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <span class="badge bg-<?= $statusColor ?> px-3 py-2 rounded-pill shadow">
                                            <i class="fas <?= $statusIcon ?> me-1"></i>
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="categories-img rounded-top">
                                        <img src="<?php echo !empty($car['image_url']) ? htmlspecialchars($car['image_url']) : '../assets/img/default-car.webp'; ?>" 
                                                class="img-fluid w-100 rounded-top" 
                                                alt="<?php echo htmlspecialchars($car['name']); ?>" 
                                                style="height: 200px; object-fit: cover;"> 
                                    </div>
                                    <div class="categories-content rounded-bottom p-4 d-flex flex-column flex-grow-1"> 
                                        <h4><?php echo htmlspecialchars($car['name']); ?></h4>
                                        <p class="text-muted mb-3"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></p>
                                        
                                        <div class="mb-4">
                                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$<?php echo htmlspecialchars(number_format($car['daily_rate'], 2)); ?>/Day</h4>
                                        </div>
                                        <div class="row gy-2 gx-0 text-center mb-4">
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-users text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['seats']); ?> Seats</span>
                                            </div>
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-calendar-alt text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['year']); ?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2 mb-sm-0">
                                                <i class="fa fa-gas-pump text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['fuel_type']); ?></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Description Snippet -->
                                        <?php if(!empty($car['description'])): ?>
                                        <div class="mb-3">
                                            <p class="text-muted small">
                                                <?php 
                                                    $desc = htmlspecialchars($car['description']);
                                                    echo (strlen($desc) > 80) ? substr($desc, 0, 80) . '...' : $desc;
                                                ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-auto"> 
                                            <?php $isBookable = ($status == 'Available' || $status == 'Rented'); ?>
                                            <form method="get" action="../user/book-car.php">
                                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['car_id']); ?>">
                                                <button type="submit" class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100 <?= !$isBookable ? 'disabled' : '' ?>" <?= !$isBookable ? 'disabled' : '' ?>>
                                                    <?php if($isBookable): ?>
                                                        <i class="fas fa-calendar-check me-2"></i>Book Now
                                                    <?php else: ?>
                                                        <i class="fas fa-ban me-2"></i>Not Available
                                                    <?php endif; ?>
                                                </button>
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
        </div>
        <!-- Banner End -->

<?php require_once '../includes/footer.php'; ?>

<script defer src="../assets/js/filterCars.js"></script>