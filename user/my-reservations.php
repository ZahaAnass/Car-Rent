<?php
    require_once "../includes/session.php";
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/booking_queries.php";
    require_once "../includes/queries/car_queries.php";
    require_once "../includes/auth_user_check.php";
    
    start_session();
    
    $bookingQueries = new BookingQueries($pdo);
    $carQueries = new CarQueries($pdo);
    
    // Update booking status based on date
    $bookingQueries->updateBookingStatusBasedOnDate();

    // Get all bookings for the current user
    $bookings = $bookingQueries->getBookingByUserId($_SESSION['user_id']);
    
    // Convert booking status to user-friendly format
    $status_map = [
        'Pending' => ['label' => 'Upcoming', 'badge' => 'bg-primary'],
        'Confirmed' => ['label' => 'Upcoming', 'badge' => 'bg-primary'],
        'Active' => ['label' => 'Active', 'badge' => 'bg-success'],
        'Completed' => ['label' => 'Completed', 'badge' => 'bg-secondary'],
        'Cancelled' => ['label' => 'Cancelled', 'badge' => 'bg-danger']
    ];
    
    // Filter bookings by status
    // Pending', 'Confirmed', 'Cancelled', 'Completed', 'Active
    $upcoming = array_filter($bookings, function($b) {
        return $b['status'] === "Pending";
    });

    $confirmed = array_filter($bookings, function($b) {
        return $b['status'] === "Confirmed";
    });
    
    $active = array_filter($bookings, function($b) {
        return $b['status'] === "Active";
    });
    
    $past = array_filter($bookings, function($b) {
        return in_array($b['status'], ['Completed', 'Cancelled']);
    });
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - My Reservations</title>
    
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto min-vh-100 px-4 wow fadeInDown">
                <div class="container-fluid py-5">
                    <!-- Hero Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h1 class="display-6 mb-2 wow fadeInDown">My Reservations</h1>
                            <p class="text-muted wow fadeInUp">View and manage your rental reservations.</p>
                        </div>
                    </div>

                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= $_SESSION['success'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Tabs -->
                    <div class="row wow fadeInUp" data-wow-delay="0.5s">
                        <div class="col-12">
                            <ul class="nav nav-tabs nav-fill mb-4" id="reservationsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">
                                        Upcoming <span class="badge bg-primary rounded-pill"><?= count($upcoming) ?></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button" role="tab" aria-controls="confirmed" aria-selected="false">
                                        Confirmed <span class="badge bg-primary rounded-pill"><?= count($confirmed) ?></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="false">
                                        Active <span class="badge bg-success rounded-pill"><?= count($active) ?></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab" aria-controls="past" aria-selected="false">
                                        Past <span class="badge bg-secondary rounded-pill"><?= count($past) ?></span>
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="reservationsTabContent">
                                <!-- Upcoming Tab -->
                                <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                    <?php if (empty($upcoming)): ?>
                                        <div class="alert alert-info text-center wow fadeInUp">You have no upcoming reservations. <a href="book-car.php">Book a car now!</a></div>
                                    <?php else: ?>
                                        <div class="row g-4">
                                            <?php 
                                            $delay = 0.1; 
                                            foreach ($upcoming as $booking): 
                                                $car = $carQueries->getCarById($booking['car_id']);
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="../<?= $car['image_url'] ?? '../assets/img/car-placeholder.png' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($car['name'] ?? 'Car') ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= htmlspecialchars($car['name'] ?? 'Unknown Car') ?></h5>
                                                                    <span class="badge <?= $status_map[$booking['status']]['badge'] ?> ms-2"><?= $status_map[$booking['status']]['label'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>Pickup:</strong> <?= date("M d, Y", strtotime($booking['pickup_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-check fa-fw text-primary me-1"></i> 
                                                                        <strong>Return:</strong> <?= date("M d, Y", strtotime($booking['return_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>From:</strong> <?= htmlspecialchars($booking['pickup_location']) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-pin fa-fw text-primary me-1"></i> 
                                                                        <strong>To:</strong> <?= htmlspecialchars($booking['return_location']) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($booking['total_price'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <form action="cancel-booking.php" method="POST" class="d-inline">
                                                                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 w-sm-auto mb-2 mb-sm-0 me-sm-2" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                                Cancel
                                                                            </button>
                                                                        </form>
                                                                        <button class="btn btn-sm btn-primary w-100 mt-md-2 w-sm-auto" data-bs-toggle="modal" data-bs-target="#viewBookingModal<?= $booking['booking_id'] ?>">
                                                                            View Details
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $delay += 0.1; endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Confirmed Tab -->
                                <div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                                    <?php if (empty($confirmed)): ?>
                                        <div class="alert alert-info text-center wow fadeInUp">You have no confirmed reservations.</div>
                                    <?php else: ?>
                                        <div class="row g-4">
                                            <?php 
                                            $delay = 0.1;
                                            foreach ($confirmed as $booking): 
                                                $car = $carQueries->getCarById($booking['car_id']);
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="../<?= $car['image_url'] ?? '../assets/img/car-placeholder.png' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($car['name'] ?? 'Car') ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= htmlspecialchars($car['name'] ?? 'Unknown Car') ?></h5>
                                                                    <span class="badge <?= $status_map[$booking['status']]['badge'] ?> ms-2"><?= $status_map[$booking['status']]['label'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>Pickup:</strong> <?= date("M d, Y", strtotime($booking['pickup_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-check fa-fw text-primary me-1"></i> 
                                                                        <strong>Return:</strong> <?= date("M d, Y", strtotime($booking['return_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>From:</strong> <?= htmlspecialchars($booking['pickup_location']) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-pin fa-fw text-primary me-1"></i> 
                                                                        <strong>To:</strong> <?= htmlspecialchars($booking['return_location']) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($booking['total_price'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <form action="cancel-booking.php" method="POST" class="d-inline">
                                                                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 w-sm-auto mb-2 mb-sm-0 me-sm-2" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                                Cancel
                                                                            </button>
                                                                        </form>
                                                                        <button class="btn btn-sm btn-primary w-100 mt-md-2 w-sm-auto" data-bs-toggle="modal" data-bs-target="#viewBookingModal<?= $booking['booking_id'] ?>">
                                                                            View Details
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $delay += 0.1; endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Active Tab -->
                                <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="active-tab">
                                    <?php if (empty($active)): ?>
                                        <div class="alert alert-info text-center wow fadeInUp">You have no active rentals right now.</div>
                                    <?php else: ?>
                                        <div class="row g-4">
                                            <?php 
                                            $delay = 0.1;
                                            foreach ($active as $booking): 
                                                $car = $carQueries->getCarById($booking['car_id']);
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="../<?= $car['image_url'] ?? '../assets/img/car-placeholder.png' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($car['name'] ?? 'Car') ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= htmlspecialchars($car['name'] ?? 'Unknown Car') ?></h5>
                                                                    <span class="badge <?= $status_map[$booking['status']]['badge'] ?> ms-2"><?= $status_map[$booking['status']]['label'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> <strong>Pickup:</strong> <?= date("M d, Y", strtotime($booking['pickup_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-check fa-fw text-primary me-1"></i> <strong>Return:</strong> <?= date("M d, Y", strtotime($booking['return_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> <strong>From:</strong> <?= htmlspecialchars($booking['pickup_location']) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-pin fa-fw text-primary me-1"></i> <strong>To:</strong> <?= htmlspecialchars($booking['return_location']) ?></div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($booking['total_price'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <button class="btn btn-sm btn-outline-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#viewBookingModal<?= $booking['booking_id'] ?>">
                                                                            View Details
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $delay += 0.1; endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Past Tab -->
                                <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                                    <?php if (empty($past)): ?>
                                        <div class="alert alert-info text-center wow fadeInUp">You have no past reservations.</div>
                                    <?php else: ?>
                                        <div class="row g-4">
                                            <?php 
                                            $delay = 0.1;
                                            foreach ($past as $booking): 
                                                $car = $carQueries->getCarById($booking['car_id']);
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="../<?= $car['image_url'] ?? '../assets/img/car-placeholder.png' ?>" class="img-fluid rounded <?= $booking['status'] === 'Cancelled' ? 'opacity-50' : '' ?>" alt="<?= htmlspecialchars($car['name'] ?? 'Car') ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= htmlspecialchars($car['name'] ?? 'Unknown Car') ?></h5>
                                                                    <span class="badge <?= $status_map[$booking['status']]['badge'] ?> ms-2"><?= $status_map[$booking['status']]['label'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> <strong>Pickup:</strong> <?= date("M d, Y", strtotime($booking['pickup_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-check fa-fw text-primary me-1"></i> <strong>Return:</strong> <?= date("M d, Y", strtotime($booking['return_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> <strong>From:</strong> <?= htmlspecialchars($booking['pickup_location']) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-pin fa-fw text-primary me-1"></i> <strong>To:</strong> <?= htmlspecialchars($booking['return_location']) ?></div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($booking['total_price'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <button class="btn btn-sm btn-outline-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#viewBookingModal<?= $booking['booking_id'] ?>">
                                                                            View Details
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $delay += 0.1; endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- View Booking Modal -->
    <?php foreach ($bookings as $booking): 
    $car = $carQueries->getCarById($booking['car_id']);
    ?>
        <div class="modal fade" id="viewBookingModal<?= $booking['booking_id'] ?>" tabindex="-1" aria-labelledby="viewBookingModalLabel<?= $booking['booking_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewBookingModalLabel<?= $booking['booking_id'] ?>">Booking Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="../<?= htmlspecialchars($car['image_url'] ?? '../default-car.webp') ?>" class="img-fluid rounded mb-3" alt="Car Image">
                            </div>
                            <div class="col-md-6">
                                <h3><?= htmlspecialchars($car['name'] ?? 'Unknown Car') ?></h3>
                                <p class="text-muted"><?= htmlspecialchars($car['type'] ?? '') ?></p>
                                <p><?= htmlspecialchars($car['description'] ?? '') ?></p>
                                <hr>
                                <h5 class="mt-3">Booking Information</h5>
                                <p><strong>Booking ID:</strong> #<?= htmlspecialchars($booking['booking_id']) ?></p>
                                <p><strong>Pickup Date:</strong> <?= date("M d, Y H:i", strtotime($booking['pickup_date'])) ?></p>
                                <p><strong>Return Date:</strong> <?= date("M d, Y H:i", strtotime($booking['return_date'])) ?></p>
                                <p><strong>Pickup Location:</strong> <?= htmlspecialchars($booking['pickup_location']) ?></p>
                                <p><strong>Return Location:</strong> <?= htmlspecialchars($booking['return_location']) ?></p>
                                <p><strong>Daily Rate:</strong> $<?= number_format($car['daily_rate'] ?? 0, 2) ?></p>
                                <p><strong>Total Price:</strong> <span class="h5 text-primary">$<?= number_format($booking['total_price'], 2) ?></span></p>
                                <p>
                                    <strong>Status:</strong> 
                                    <span class="badge <?= $status_map[$booking['status']]['badge'] ?? 'bg-secondary' ?>">
                                        <?= $status_map[$booking['status']]['label'] ?? $booking['status'] ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <?php if (in_array($booking['status'], ['Pending', 'Confirmed'])): ?>
                            <form action="cancel-booking.php" method="POST" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Bottom Navigation With The Scripts -->
    <?php include '../includes/bottom-nav.php'; ?>

</body>
</html>