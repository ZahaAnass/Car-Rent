<?php
// Add session start and authentication check if needed
// session_start();
// include '../includes/session.php'; // Assuming you have session handling
// if (!is_admin()) { header('Location: ../login.php'); exit; } 
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

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label for="filterBookingStatus" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="filterBookingStatus">
                                                <option selected value="">All Statuses</option>
                                                <option>Confirmed</option>
                                                <option>Pending</option>
                                                <option>Completed</option>
                                                <option>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterSearch" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="filterSearch" placeholder="Search by User or Car...">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="reset" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">Booking ID</th>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Car</th>
                                                    <th scope="col">Pickup Date</th>
                                                    <th scope="col">Return Date</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // --- PHP Logic to fetch bookings from database would go here ---
                                                // Example placeholder data:
                                                $bookings = [
                                                    ['id' => 101, 'user_name' => 'Jane Smith', 'user_id' => 5, 'car_name' => 'Toyota Camry', 'car_id' => 1, 'pickup_date' => '2025-05-10', 'return_date' => '2025-05-15', 'total_cost' => 225.00, 'status' => 'Confirmed'],
                                                    ['id' => 102, 'user_name' => 'Robert Johnson', 'user_id' => 8, 'car_name' => 'Honda CR-V', 'car_id' => 2, 'pickup_date' => '2025-05-12', 'return_date' => '2025-05-14', 'total_cost' => 180.00, 'status' => 'Pending'],
                                                    ['id' => 103, 'user_name' => 'John Doe', 'user_id' => 2, 'car_name' => 'Ford Mustang', 'car_id' => 3, 'pickup_date' => '2025-04-20', 'return_date' => '2025-04-25', 'total_cost' => 400.00, 'status' => 'Completed'],
                                                    ['id' => 104, 'user_name' => 'Jane Smith', 'user_id' => 5, 'car_name' => 'Toyota Camry', 'car_id' => 1, 'pickup_date' => '2025-06-01', 'return_date' => '2025-06-05', 'total_cost' => 180.00, 'status' => 'Cancelled'],
                                                    ['id' => 105, 'user_name' => 'Robert Johnson', 'user_id' => 8, 'car_name' => 'Honda CR-V', 'car_id' => 2, 'pickup_date' => '2025-05-12', 'return_date' => '2025-05-14', 'total_cost' => 180.00, 'status' => 'Pending'],
                                                    ['id' => 106, 'user_name' => 'John Doe', 'user_id' => 2, 'car_name' => 'Ford Mustang', 'car_id' => 3, 'pickup_date' => '2025-04-20', 'return_date' => '2025-04-25', 'total_cost' => 400.00, 'status' => 'Completed'],
                                                    ['id' => 107, 'user_name' => 'Jane Smith', 'user_id' => 5, 'car_name' => 'Toyota Camry', 'car_id' => 1, 'pickup_date' => '2025-06-01', 'return_date' => '2025-06-05', 'total_cost' => 180.00, 'status' => 'Cancelled'],
                                                ];

                                                if (empty($bookings)) {
                                                    echo '<tr><td colspan="8" class="text-center text-muted py-4">No bookings found.</td></tr>';
                                                } else {
                                                    foreach ($bookings as $booking): 
                                                ?>
                                                    <tr>
                                                        <td>#<?= htmlspecialchars($booking['id']) ?></td>
                                                        <td>
                                                            <a href="manage-users.php?view=<?= $booking['user_id'] ?>" data-bs-toggle="tooltip" title="View User Details">
                                                                <?= htmlspecialchars($booking['user_name']) ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="manage-cars.php?view=<?= $booking['car_id'] ?>" data-bs-toggle="tooltip" title="View Car Details">
                                                                <?= htmlspecialchars($booking['car_name']) ?>
                                                            </a>
                                                        </td>
                                                        <td><?= htmlspecialchars($booking['pickup_date']) ?></td>
                                                        <td><?= htmlspecialchars($booking['return_date']) ?></td>
                                                        <td>$<?= number_format($booking['total_cost'], 2) ?></td>
                                                        <td>
                                                            <?php 
                                                                $status_badge = 'secondary';
                                                                if ($booking['status'] == 'Confirmed') $status_badge = 'success';
                                                                if ($booking['status'] == 'Pending') $status_badge = 'warning text-dark';
                                                                if ($booking['status'] == 'Completed') $status_badge = 'info text-dark';
                                                                if ($booking['status'] == 'Cancelled') $status_badge = 'danger';
                                                            ?>
                                                            <span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($booking['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <!-- Add actions based on status -->
                                                            <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="tooltip" title="View Booking Details <?= $booking['id'] ?>">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <?php if ($booking['status'] == 'Pending'): ?>
                                                            <button class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Confirm Booking <?= $booking['id'] ?>">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Cancel Booking <?= $booking['id'] ?>">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                            <?php elseif ($booking['status'] == 'Confirmed'): ?>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Cancel Booking <?= $booking['id'] ?>">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                            <?php endif; ?>
                                                            <!-- Maybe add 'Mark as Completed' or 'Delete' for old bookings -->
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    endforeach; 
                                                }
                                                // --- End PHP Logic ---
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <?php if (!empty($bookings)): ?>
                                    <!-- Optional: Add Pagination -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
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

    <!-- Mobile Bottom Navigation -->
    <?php require_once '../includes/bottom-nav.php'; ?>

</body>
</html>