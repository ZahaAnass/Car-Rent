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

                    <!-- Tabs -->
                    <div class="row wow fadeInUp" data-wow-delay="0.5s">
                        <div class="col-12">
                            <?php 
                            // Sample Reservation Data (Replace with actual data fetching)
                            $reservations = [
                                ['id' => 101, 'car_name' => 'Toyota Camry', 'car_image' => '../assets/img/car-1.png', 'pickup_date' => '2025-06-15', 'return_date' => '2025-06-20', 'pickup_loc' => 'Airport', 'return_loc' => 'Downtown Station', 'total_cost' => 225, 'status' => 'Upcoming'],
                                ['id' => 102, 'car_name' => 'Honda CR-V', 'car_image' => '../assets/img/car-2.png', 'pickup_date' => '2025-05-10', 'return_date' => '2025-05-14', 'pickup_loc' => 'Uptown Branch', 'return_loc' => 'Uptown Branch', 'total_cost' => 240, 'status' => 'Active'],
                                ['id' => 103, 'car_name' => 'Ford Mustang', 'car_image' => '../assets/img/car-3.png', 'pickup_date' => '2025-04-01', 'return_date' => '2025-04-05', 'pickup_loc' => 'Airport', 'return_loc' => 'Airport', 'total_cost' => 340, 'status' => 'Completed'],
                                ['id' => 104, 'car_name' => 'Toyota Camry', 'car_image' => '../assets/img/car-1.png', 'pickup_date' => '2025-07-01', 'return_date' => '2025-07-03', 'pickup_loc' => 'Downtown Station', 'return_loc' => 'Downtown Station', 'total_cost' => 90, 'status' => 'Upcoming'],
                                ['id' => 105, 'car_name' => 'Honda CR-V', 'car_image' => '../assets/img/car-2.png', 'pickup_date' => '2025-03-10', 'return_date' => '2025-03-15', 'pickup_loc' => 'Airport', 'return_loc' => 'Uptown Branch', 'total_cost' => 300, 'status' => 'Cancelled'],
                            ];

                            // Filter reservations by status
                            $upcoming = array_filter($reservations, fn($r) => $r['status'] === 'Upcoming');
                            $active = array_filter($reservations, fn($r) => $r['status'] === 'Active');
                            $past = array_filter($reservations, fn($r) => in_array($r['status'], ['Completed', 'Cancelled']));

                            // Status badge mapping
                            $status_badges = [
                                'Upcoming' => 'bg-primary',
                                'Active' => 'bg-success',
                                'Completed' => 'bg-secondary',
                                'Cancelled' => 'bg-danger'
                            ];
                            ?>

                            <ul class="nav nav-tabs nav-fill mb-4" id="reservationsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">
                                        Upcoming <span class="badge bg-primary rounded-pill"><?= count($upcoming) ?></span>
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
                                            foreach ($upcoming as $res): 
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="<?= $res['car_image'] ?>" class="img-fluid rounded" alt="<?= $res['car_name'] ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= $res['car_name'] ?></h5>
                                                                    <span class="badge <?= $status_badges[$res['status']] ?> ms-2"><?= $res['status'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>Pickup:</strong> <?= date("M d, Y", strtotime($res['pickup_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-calendar-check fa-fw text-primary me-1"></i> 
                                                                        <strong>Return:</strong> <?= date("M d, Y", strtotime($res['return_date'])) ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> 
                                                                        <strong>From:</strong> <?= $res['pickup_loc'] ?>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <i class="fas fa-map-pin fa-fw text-primary me-1"></i> 
                                                                        <strong>To:</strong> <?= $res['return_loc'] ?>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($res['total_cost'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <button class="btn btn-sm btn-outline-danger w-100 w-sm-auto mb-2 mb-sm-0 me-sm-2">Cancel</button>
                                                                        <button class="btn btn-sm btn-primary w-100 mt-md-2 w-sm-auto">View Details</button>
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
                                            foreach ($active as $res): 
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="<?= $res['car_image'] ?>" class="img-fluid rounded" alt="<?= $res['car_name'] ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= $res['car_name'] ?></h5>
                                                                    <span class="badge <?= $status_badges[$res['status']] ?> ms-2"><?= $res['status'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> <strong>Pickup:</strong> <?= date("M d, Y", strtotime($res['pickup_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-check fa-fw text-primary me-1"></i> <strong>Return:</strong> <?= date("M d, Y", strtotime($res['return_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> <strong>From:</strong> <?= $res['pickup_loc'] ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-pin fa-fw text-primary me-1"></i> <strong>To:</strong> <?= $res['return_loc'] ?></div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($res['total_cost'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <button class="btn btn-sm btn-outline-primary w-100 w-sm-auto">View Details</button>
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
                                            foreach ($past as $res): 
                                            ?>
                                            <div class="col-12 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                                                <div class="card shadow-sm border-0 h-100 reservation-card">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                                            <img src="<?= $res['car_image'] ?>" class="img-fluid rounded <?= $res['status'] === 'Cancelled' ? 'opacity-50' : '' ?>" alt="<?= $res['car_name'] ?>" style="max-height: 120px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body d-flex flex-column h-100">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="card-title mb-0"><?= $res['car_name'] ?></h5>
                                                                    <span class="badge <?= $status_badges[$res['status']] ?> ms-2"><?= $res['status'] ?></span>
                                                                </div>
                                                                <div class="row gx-3 gy-2 small text-muted mb-3">
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-alt fa-fw text-primary me-1"></i> <strong>Pickup:</strong> <?= date("M d, Y", strtotime($res['pickup_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-calendar-check fa-fw text-primary me-1"></i> <strong>Return:</strong> <?= date("M d, Y", strtotime($res['return_date'])) ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-marker-alt fa-fw text-primary me-1"></i> <strong>From:</strong> <?= $res['pickup_loc'] ?></div>
                                                                    <div class="col-sm-6"><i class="fas fa-map-pin fa-fw text-primary me-1"></i> <strong>To:</strong> <?= $res['return_loc'] ?></div>
                                                                </div>
                                                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><strong>Total Cost:</strong> <span class="text-primary h5 mb-0">$<?= number_format($res['total_cost'], 2) ?></span></p>
                                                                    <div class="text-center text-sm-end">
                                                                        <button class="btn btn-sm btn-outline-primary w-100 w-sm-auto">View Details</button>
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

    <!-- Bottom Navigation -->
    <?php include '../includes/bottom-nav.php'; ?>

</body>
</html>