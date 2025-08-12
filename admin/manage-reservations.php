<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/booking_queries.php";
    require_once "../includes/queries/car_queries.php";
    require_once "../includes/queries/user_queries.php";
    
    $bookingQueries = new BookingQueries($pdo);
    $carQueries = new CarQueries($pdo);
    $userQueries = new UserQueries($pdo);

    // Update booking status based on date
    $bookingQueries->updateBookingStatusBasedOnDate();

    // Pagination Config
    $limit = 7; // Number of bookings per page 
    $totalBookings = $bookingQueries->getBookingCount();
    $totalPages = ceil($totalBookings / $limit);

    // Get current page and validate it
    $page = isset($_GET['page']) ? (int)$_GET["page"] : 1;
    
    // Validate page number
    if ($page < 1 || ($totalPages > 0 && $page > $totalPages)) {
        redirect("manage-reservations.php?page=1");
    }
    
    $offset = ($page - 1) * $limit;

    // Get filter status if set
    $status_filter = isset($_GET['status']) ? $_GET['status'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    
    // Fetch bookings with pagination 
    $bookings = $bookingQueries->getBookingsWithLimit($limit, $offset, $status_filter, $search);
    
    // If filters are applied, update the total count and pages
    if ($status_filter || $search) {
        $totalBookings = count($bookingQueries->getAllBookings($status_filter, $search));
        $totalPages = ceil($totalBookings / $limit);
        
        // Recheck page validity with new total
        if ($page > $totalPages && $totalPages > 0) {
            redirect("manage-reservations.php?page=1" . 
                        ($status_filter ? "&status=" . urlencode($status_filter) : "") . 
                        ($search ? "&search=" . urlencode($search) : ""));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoomix Admin - Manage Bookings</title>
    
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
            
            <!-- Admin Sidebar -->
            <?php require_once '../includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto min-vh-100 px-md-4 py-5">
                <div class="container-fluid">
                    <!-- Page Title -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col">
                            <h1 class="display-6 mb-2">Manage Bookings</h1>
                            <p class="text-muted mb-0">View and update car reservations.</p>
                        </div>
                    </div>

                    <!-- Session Messages -->
                    <?php
                        if (isset($_SESSION['booking_success'])) {
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                            echo "<i class='fas fa-check-circle me-2'></i>{$_SESSION['booking_success']}";
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                            echo "</div>";
                            unset($_SESSION['booking_success']);
                        }

                        if (isset($_SESSION['booking_error'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                            echo "<i class='fas fa-exclamation-triangle me-2'></i>{$_SESSION['booking_error']}";
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                            echo "</div>";
                            unset($_SESSION['booking_error']);
                        }
                    ?>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center" method="GET" action="manage-reservations.php">
                                        <div class="col-md-4">
                                            <label for="status" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="" <?= !$status_filter ? 'selected' : '' ?>>All Statuses</option>
                                                <option value="Confirmed" <?= $status_filter == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                <option value="Pending" <?= $status_filter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Active" <?= $status_filter == 'Active' ? 'selected' : '' ?>>Active</option>
                                                <option value="Completed" <?= $status_filter == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                                <option value="Cancelled" <?= $status_filter == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="search" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search by User or Car..." value="<?= htmlspecialchars($search ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="manage-reservations.php" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </a>
                                        </div>
                                        <input type="hidden" name="page" value="1">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Car</th>
                                                    <th scope="col">Pickup Date</th>
                                                    <th scope="col">Return Date</th>
                                                    <th scope="col">Total Price</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($bookings)): ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                                <h5>No Bookings Found</h5>
                                                                <p class="text-muted">There are no bookings matching your criteria.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach($bookings as $booking): 
                                                        // Get car and user details
                                                        $car = $carQueries->getCarById($booking['car_id']);
                                                        $user = $userQueries->getUserById($booking['user_id']);
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                                                            <td>
                                                                <?php if ($user): ?>
                                                                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                                                                <?php else: ?>
                                                                    <span class="text-muted">Unknown User</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($car): ?>
                                                                    <?= htmlspecialchars($car['name']) ?>
                                                                <?php else: ?>
                                                                    <span class="text-muted">Unknown Car</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= htmlspecialchars(date('M d, Y', strtotime($booking['pickup_date']))) ?></td>
                                                            <td><?= htmlspecialchars(date('M d, Y', strtotime($booking['return_date']))) ?></td>
                                                            <td>$<?= number_format($booking['total_price'], 2) ?></td>
                                                            <td>
                                                                <?php 
                                                                    $status_badge = 'secondary';
                                                                    if ($booking['status'] == 'Confirmed') $status_badge = 'success';
                                                                    if ($booking['status'] == 'Pending') $status_badge = 'warning';
                                                                    if ($booking['status'] == 'Completed') $status_badge = 'info';
                                                                    if ($booking['status'] == 'Cancelled') $status_badge = 'danger';
                                                                ?>
                                                                <span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($booking['status']) ?></span>
                                                            </td>
                                                            <td class="text-end">
                                                                <!-- View Booking Details -->
                                                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#viewBookingModal<?= $booking['booking_id'] ?>" title="View Details">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                
                                                                <!-- Update Booking Status Buttons -->
                                                                <form action="manage-reservation-handeler.php" method="POST" class="d-inline">
                                                                    <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                                                    
                                                                    <?php if ($booking['status'] == 'Pending'): ?>
                                                                    <!-- Confirm Button -->
                                                                    <button type="submit" name="update_status" value="Confirmed" class="btn btn-sm btn-outline-success me-1" title="Confirm Booking">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                    
                                                                    <!-- Cancel Button -->
                                                                    <button type="submit" name="update_status" value="Cancelled" class="btn btn-sm btn-outline-danger" title="Cancel Booking">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                    
                                                                    <?php elseif ($booking['status'] == 'Confirmed'): ?>
                                                                    <!-- Mark as Completed -->
                                                                    <button type="submit" name="update_status" value="Completed" class="btn btn-sm btn-outline-primary me-1" title="Mark as Completed">
                                                                        <i class="fas fa-check-double"></i>
                                                                    </button>
                                                                    
                                                                    <!-- Cancel Button -->
                                                                    <button type="submit" name="update_status" value="Cancelled" class="btn btn-sm btn-outline-danger" title="Cancel Booking">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <?php endif; ?>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <?php if ($totalPages > 1): ?>
                                        <nav aria-label="Page navigation" class="mt-4">
                                            <ul class="pagination justify-content-center">
                                                <!-- Previous -->
                                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $page - 1 ?>
                                                    <?php if ($status_filter): ?>
                                                    &status=<?= urlencode($status_filter) ?>
                                                    <?php endif; ?>
                                                    <?php if ($search): ?>
                                                    &search=<?= urlencode($search) ?>
                                                    <?php endif; ?>
                                                    ">Previous</a>
                                                </li>

                                                <?php
                                                $visiblePages = 2; // Number of pages before/after the current one to show
                                                $start = max(1, $page - $visiblePages);
                                                $end = min($totalPages, $page + $visiblePages);

                                                // Always show first page
                                                if ($start > 1):
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?page=1
                                                    <?php if ($status_filter): ?>
                                                    &status=<?= urlencode($status_filter) ?>
                                                    <?php endif; ?>
                                                    <?php if ($search): ?>
                                                    &search=<?= urlencode($search) ?>
                                                    <?php endif; ?>
                                                    ">1</a></li>
                                                    <?php if ($start > 2): ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <!-- Page Numbers Around Current -->
                                                <?php for ($i = $start; $i <= $end; $i++): ?>
                                                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $i ?>
                                                        <?php if ($status_filter): ?>
                                                        &status=<?= urlencode($status_filter) ?>
                                                        <?php endif; ?>
                                                        <?php if ($search): ?>
                                                        &search=<?= urlencode($search) ?>
                                                        <?php endif; ?>
                                                        "><?= $i ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <!-- Always show last page -->
                                                <?php if ($end < $totalPages): ?>
                                                    <?php if ($end < $totalPages - 1): ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                    <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>
                                                    <?php if ($status_filter): ?>
                                                    &status=<?= urlencode($status_filter) ?>
                                                    <?php endif; ?>
                                                    <?php if ($search): ?>
                                                    &search=<?= urlencode($search) ?>
                                                    <?php endif; ?>
                                                    "><?= $totalPages ?></a></li>
                                                <?php endif; ?>

                                                <!-- Next -->
                                                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $page + 1 ?>
                                                    <?php if ($status_filter): ?>
                                                    &status=<?= urlencode($status_filter) ?>
                                                    <?php endif; ?>
                                                    <?php if ($search): ?>
                                                    &search=<?= urlencode($search) ?>
                                                    <?php endif; ?>
                                                    ">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
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
        $user = $userQueries->getUserById($booking['user_id']);
    ?>
        <div class="modal fade" id="viewBookingModal<?= $booking['booking_id'] ?>" tabindex="-1" aria-labelledby="viewBookingModalLabel<?= $booking['booking_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="viewBookingModalLabel<?= $booking['booking_id'] ?>">
                            Booking <?= $booking['booking_id'] ?> - <?= htmlspecialchars($car['name'] ?? 'Car Details') ?>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img src="<?= "../" . htmlspecialchars($car['image_url'] ?? '../assets/img/default-car.webp') ?>" 
                                        class="img-fluid rounded" 
                                        alt="<?= htmlspecialchars($car['name'] ?? 'Car Image') ?>">
                                </div>
                                <h5>Car Details</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Make:</strong> <?= htmlspecialchars($car['make'] ?? 'N/A') ?></li>
                                    <li><strong>Model:</strong> <?= htmlspecialchars($car['model'] ?? 'N/A') ?></li>
                                    <li><strong>Year:</strong> <?= htmlspecialchars($car['year'] ?? 'N/A') ?></li>
                                    <li><strong>Type:</strong> <?= htmlspecialchars($car['type'] ?? 'N/A') ?></li>
                                    <li><strong>Color:</strong> <?= htmlspecialchars($car['color'] ?? 'N/A') ?></li>
                                    <li><strong>License Plate:</strong> <?= htmlspecialchars($car['license_plate'] ?? 'N/A') ?></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Booking Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Status:</strong> 
                                        <span class="badge bg-<?= 
                                            $booking['status'] === 'Confirmed' ? 'primary' : 
                                            ($booking['status'] === 'Active' ? 'success' : 
                                            ($booking['status'] === 'Completed' ? 'secondary' : 
                                            ($booking['status'] === 'Cancelled' ? 'danger' : 'warning')))
                                        ?>">
                                            <?= htmlspecialchars($booking['status']) ?>
                                        </span>
                                    </li>
                                    <li><strong>Pickup Date:</strong> <?= date("M d, Y H:i", strtotime($booking['pickup_date'])) ?></li>
                                    <li><strong>Return Date:</strong> <?= date("M d, Y H:i", strtotime($booking['return_date'])) ?></li>
                                    <li><strong>Pickup Location:</strong> <?= htmlspecialchars($booking['pickup_location']) ?></li>
                                    <li><strong>Return Location:</strong> <?= htmlspecialchars($booking['return_location']) ?></li>
                                    <li><strong>Daily Rate:</strong> $<?= number_format($car['daily_rate'] ?? 0, 2) ?></li>
                                    <li class="mt-2"><strong>Total Price:</strong> <span class="h5 text-primary">$<?= number_format($booking['total_price'], 2) ?></span></li>
                                </ul>

                                <h5 class="mt-4">Customer Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></li>
                                    <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                                    <li><strong>Phone:</strong> <?= htmlspecialchars($user['phone_number'] ?? 'N/A') ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    <!-- Mobile Bottom Navigation -->
    <?php require_once '../includes/bottom-nav.php'; ?>

</body>
</html>