<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/car_queries.php";
    $carQueries = new CarQueries($pdo);
    
    $selected_car_id = isset($_GET['car_id']) ? filter_var($_GET['car_id'], FILTER_VALIDATE_INT) : null;
    
    if (!$selected_car_id) {
        $_SESSION['car_error'] = "Invalid car ID.";
        redirect("../public/cars.php");
    }
    
    $car = $carQueries->getCarById($selected_car_id);
    
    if (!$car) {
        $_SESSION['car_error'] = "Car not found.";
        redirect("../public/cars.php");
    }
    
    if ($car['status'] !== 'Available' && $car['status'] !== 'Rented') {
        $_SESSION['car_error'] = "This car is not available for booking.";
        redirect("../public/cars.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - Book a Car</title>
    
    <!-- Favicon -->
    <link href="../assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../assets/css/style.css" rel="stylesheet">

</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Session Messages -->
    <?php if (isset($_SESSION['booking_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($_SESSION['booking_error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['booking_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['booking_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['booking_success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php require_once '../includes/sidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto px-4 wow fadeInDown">
                <div class="container-fluid py-5">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mb-3 display-6 wow fadeInDown">Book: <?= htmlspecialchars($car['name']) ?></h1>
                            <p class="text-muted wow fadeInUp">Review your selected vehicle and complete your booking details.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Car Listing -->
                        <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="row g-4">
                                <div class="col wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="card h-100 border-0 shadow-sm car-card">
                                        <div class="card-body p-0">
                                            <!-- Car Image Section -->
                                            <div class="position-relative">
                                                <img src="../<?= htmlspecialchars($car['image_url']) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($car['name']) ?>" >
                                                <div class="position-absolute top-0 end-0 bg-primary text-white p-2 m-3 rounded-pill fs-6 fw-bold">
                                                    $<?= htmlspecialchars($car['daily_rate']) ?>/day
                                                </div>
                                                <div class="position-absolute bottom-0 start-0 bg-transparent bg-opacity-50 text-white px-3 py-2 m-3 fw-bold">
                                                    <span class="badge bg-<?= $car['status'] == 'Available' ? 'success' : ($car['status'] == 'Rented' ? 'warning' : 'danger') ?> text-white p-2">
                                                        <i class="fas <?= $car['status'] == 'Available' ? 'fa-check-circle' : ($car['status'] == 'Rented' ? 'fa-clock' : 'fa-ban') ?> me-2"></i>
                                                        <?= htmlspecialchars($car['status']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Car Details Section -->
                                            <div class="p-4">
                                                <!-- Car Title and Type -->
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h4 class="card-title mb-0 fw-bold"><?= htmlspecialchars($car['name']) ?></h4>
                                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($car['type']) ?></span>
                                                </div>
                                                
                                                <!-- Car Make, Model, Year -->
                                                <p class="text-muted mb-3">
                                                    <?= isset($car['make']) ? htmlspecialchars($car['make']) . ' ' : '' ?>
                                                    <?= isset($car['model']) ? htmlspecialchars($car['model']) . ' ' : '' ?>
                                                    <?= isset($car['year']) ? '(' . htmlspecialchars($car['year']) . ')' : '' ?>
                                                    <?= isset($car['color']) ? '- ' . htmlspecialchars($car['color']) : '' ?>
                                                </p>
                                                
                                                <!-- Car Features Grid -->
                                                <div class="row mb-3">
                                                    <div class="col-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-users fs-5 me-2 text-primary"></i>
                                                            <span><?= htmlspecialchars($car['seats']) ?> seats</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-gas-pump fs-5 me-2 text-primary"></i>
                                                            <span><?= htmlspecialchars($car['fuel_type'] ?? $car['fuel']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-car fs-5 me-2 text-primary"></i>
                                                            <span><?= htmlspecialchars($car['transmission'] ?? 'Automatic') ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-id-card fs-5 me-2 text-primary"></i>
                                                            <span><?= htmlspecialchars($car['license_plate'] ?? 'ABC123') ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Car Description -->
                                                <div class="mb-3">
                                                    <h6 class="fw-bold">Description</h6>
                                                    <p class="card-text">
                                                        <?= isset($car['description']) ? htmlspecialchars($car['description']) : 'Experience comfort and reliability with this excellent vehicle. Perfect for both city driving and longer trips.' ?>
                                                    </p>
                                                </div>
                                                
                                                <!-- Car Features Pills -->
                                                <?php if(isset($car['features']) && !empty($car['features'])): ?>
                                                <div class="mb-2">
                                                    <h6 class="fw-bold">Features</h6>
                                                    <div class="features-container">
                                                        <?php 
                                                            $features = explode(',', $car['features']);
                                                            foreach($features as $feature):
                                                        ?>
                                                            <span class="badge bg-light text-dark me-1 mb-1 p-2"><?= htmlspecialchars(trim($feature)) ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Form -->
                        <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="card border-0 shadow-sm sticky-lg-top" style="top: 20px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Booking Details</h4>
                                    <form id="bookingForm" action="book-car-handeler.php?car_id=<?= $selected_car_id ?>" method="POST">
                                        <div class="mb-3">
                                            <label for="pickup-date" class="form-label">Pickup Date</label>
                                            <input type="date" class="form-control" id="pickup-date" name="pickup_date" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="return-date" class="form-label">Return Date</label>
                                            <input type="date" class="form-control" id="return-date" name="return_date" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pickup-location" class="form-label">Pickup Location</label>
                                            <select class="form-select" id="pickup-location" name="pickup_location" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option value="Airport">Airport</option>
                                                <option value="Downtown Station">Downtown Station</option>
                                                <option value="Uptown Branch">Uptown Branch</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="return-location" class="form-label">Return Location</label>
                                            <select class="form-select" id="return-location" name="return_location" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option value="Airport">Airport</option>
                                                <option value="Downtown Station">Downtown Station</option>
                                                <option value="Uptown Branch">Uptown Branch</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 p-3 bg-light rounded">
                                            <input type="hidden" id="dailyRate" name="daily_rate" value="<?= htmlspecialchars($car['daily_rate']) ?>">
                                            <p class="mb-1"><strong>Daily Rate:</strong> $<span id="dailyRateDisplay"><?= htmlspecialchars(number_format($car['daily_rate'], 2)) ?></span></p>
                                            <input type="hidden" id="total_price" name="total_price">
                                            <h5 class="mb-0"><strong>Total Price:</strong> <span id="totalPriceDisplay">$0.00</span></h5>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100" id="reviewBookingBtn">Review & Book</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
    <div class="modal fade" id="paymentConfirmationModal" tabindex="-1" aria-labelledby="paymentConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentConfirmationModalLabel">Confirm Your Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please review your booking details below. This is a simulated payment process I will Add It Soon!</p>
                    <hr>
                    <h6>Booking Summary:</h6>
                    <p><strong>Car:</strong> <span id="modalCarName"></span></p>
                    <p><strong>Pickup Date:</strong> <span id="modalPickupDate"></span></p>
                    <p><strong>Return Date:</strong> <span id="modalReturnDate"></span></p>
                    <p><strong>Pickup Location:</strong> <span id="modalPickupLocation"></span></p>
                    <p><strong>Return Location:</strong> <span id="modalReturnLocation"></span></p>
                    <hr>
                    <h5><strong>Total Price:</strong> <span id="modalTotalPrice"></span></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="modalConfirmAndBookBtn">Confirm & Book (Simulated)</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Success Modal -->
    <?php if(isset($_SESSION['booking_success'])): ?>
    <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="bookingSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="bookingSuccessModalLabel">Booking Submitted!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                    <h4>Thank You!</h4>
                    <p>Your booking request has been sent and is awaiting admin approval.</p>
                    <p>You will be notified once it is confirmed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
            successModal.show();
        });
    </script>
    <?php unset($_SESSION['booking_success']); ?>
    <?php endif; ?>

    <!-- Bottom Navigation With The Scripts -->
    <?php require_once '../includes/bottom-nav.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hardcoded car details
        const carDetails = {
            name: "<?= htmlspecialchars($car['name'])?>",
            price: parseFloat(<?= $car['daily_rate'] ?>)
        };

        const pickupDateEl = document.getElementById('pickup-date');
        const returnDateEl = document.getElementById('return-date');
        const totalPriceDisplayEl = document.getElementById('totalPriceDisplay');
        const totalPriceInputEl = document.getElementById('total_price');
        
        const reviewBookingBtn = document.getElementById('reviewBookingBtn');
        const paymentModalEl = document.getElementById('paymentConfirmationModal');
        const paymentModal = new bootstrap.Modal(paymentModalEl);
        const modalConfirmAndBookBtn = document.getElementById('modalConfirmAndBookBtn');
        const bookingForm = document.getElementById('bookingForm');
        
        // Success Modal
        const successModalEl = document.getElementById('bookingSuccessModal');
        const successModal = successModalEl;

        // Function to calculate and update total price
        function calculateAndUpdatePrice() {
            if (!pickupDateEl || !returnDateEl || !totalPriceDisplayEl || !carDetails.price) {
                if (totalPriceDisplayEl) totalPriceDisplayEl.textContent = '$0.00';
                return 0;
            }

            const pickupDateStr = pickupDateEl.value;
            const returnDateStr = returnDateEl.value;

            if (pickupDateStr && returnDateStr) {
                const pickup = new Date(pickupDateStr);
                const ret = new Date(returnDateStr);

                if (ret >= pickup) {
                    let diffTime = ret.getTime() - pickup.getTime();
                    let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24));
                    
                    if (pickup.toDateString() === ret.toDateString()) { // Same day rental
                        diffDays = 1;
                    } else if (diffDays === 0 && ret > pickup) { // Handles cases less than 24h but across midnight
                        diffDays = 1;
                    }
                    if (diffDays < 1) diffDays = 1; // Minimum 1 day rental

                    const total = diffDays * carDetails.price;
                    totalPriceDisplayEl.textContent = '$' + total.toFixed(2);
                    if (totalPriceInputEl) totalPriceInputEl.value = total.toFixed(2);
                    return total;
                } else {
                    totalPriceDisplayEl.textContent = 'Invalid dates';
                }
            } else {
                totalPriceDisplayEl.textContent = '$0.00';
            }
            return 0;
        }

        // Set min dates
        const today = new Date();
        const todayString = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        
        if(pickupDateEl) {
            pickupDateEl.setAttribute('min', todayString);
            pickupDateEl.addEventListener('change', function() {
                if (pickupDateEl.value) {
                    returnDateEl.setAttribute('min', pickupDateEl.value);
                }
                calculateAndUpdatePrice();
            });
        }
        if(returnDateEl) {
            returnDateEl.setAttribute('min', todayString); // Initial min for return date
            returnDateEl.addEventListener('change', calculateAndUpdatePrice);
        }
        
        // Initial calculation in case dates are pre-filled
        calculateAndUpdatePrice();

        // Handle "Review & Book" button click
        if (reviewBookingBtn) {
            reviewBookingBtn.addEventListener('click', function() {
                // Basic client-side validation
                const pickupLocationEl = document.getElementById('pickup-location');
                const returnLocationEl = document.getElementById('return-location');

                if (!pickupDateEl.value || !returnDateEl.value || !pickupLocationEl.value || !returnLocationEl.value) {
                    alert('Please fill in all booking details.');
                    return;
                }
                const pickup = new Date(pickupDateEl.value);
                const ret = new Date(returnDateEl.value);
                if (ret < pickup) {
                    alert('Return date must be after or the same as the pickup date.');
                    return;
                }

                // Populate modal
                document.getElementById('modalCarName').textContent = carDetails.name;
                document.getElementById('modalPickupDate').textContent = pickupDateEl.value;
                document.getElementById('modalReturnDate').textContent = returnDateEl.value;
                document.getElementById('modalPickupLocation').textContent = pickupLocationEl.selectedOptions[0].text;
                document.getElementById('modalReturnLocation').textContent = returnLocationEl.selectedOptions[0].text;
                const finalPrice = calculateAndUpdatePrice(); // Recalculate to be sure
                document.getElementById('modalTotalPrice').textContent = '$' + finalPrice.toFixed(2);
                
                paymentModal.show();
            });
        }

        if (modalConfirmAndBookBtn) {
            modalConfirmAndBookBtn.addEventListener('click', function() {
                bookingForm.submit();
            });
        }
    });
    </script>

</body>
</html>