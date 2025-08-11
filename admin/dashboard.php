<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/queries/user_queries.php";
    require_once "../includes/queries/booking_queries.php";
    require_once "../includes/queries/car_queries.php";
    require_once "../includes/queries/testimonial_queries.php";
    require_once "../includes/queries/message_queries.php";
    require_once "../includes/auth_admin_check.php";

    $userQueries = new UserQueries($pdo);
    $bookingQueries = new BookingQueries($pdo);
    $carQueries = new CarQueries($pdo);
    $testimonialQueries = new TestimonialQueries($pdo);
    $messageQueries = new MessageQueries($pdo);

    $totalCars = $carQueries->getCarCount() ?? 0;
    $totalUsers = $userQueries->getUserCount() ?? 0;
    $totalRevenue = $bookingQueries->getTotalRevenue() ?? 0;
    $activeRentals = $bookingQueries->getActiveRentals() ?? 0;

    $recentBookings = $bookingQueries->getRecentBookings() ?? [];
    $recentSpendedMoney = $bookingQueries->getRecentSpendedMoney() ?? [];
    $recentTestimonials = $testimonialQueries->getRecentTestimonials() ?? [];
    $recentMessages = $messageQueries->getRecentMessages() ?? [];
    $recentCars = $carQueries->getRecentCars() ?? [];
    $recentUsers = $userQueries->getRecentUsers() ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - Dashboard</title>
    
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../assets/css/style.css" rel="stylesheet">

</head>
<body>
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <div class="container-fluid dashboard">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto px-4 py-5 pb-7 wow fadeInDown">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mb-3 display-6 wow fadeInDown">Admin Dashboard</h1>
                            <p class="text-muted wow fadeInUp">Manage your car rental business here.</p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3">
                                        <i class="fas fa-car fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Cars</h5>
                                    <p class="h3 text-primary"><?php echo $totalCars; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3">
                                        <i class="fas fa-credit-card fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Revenue</h5>
                                    <p class="h3 text-success">$<?php echo $totalRevenue; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3">
                                        <i class="fas fa-users fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Users</h5>
                                    <p class="h3 text-info"><?php echo $totalUsers; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.7s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3">
                                        <i class="fas fa-trophy fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Active Rentals</h5>
                                    <p class="h3 text-warning"><?php echo $activeRentals; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Recent Activity -->
                        <div class="col-lg-8 mb-4 mb-lg-0 wow fadeInDown" data-wow-delay="0.9s">
                            <div class="card activity-card overflow-hidden shadow-sm">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Recent Activity</h4>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        // Helper function to format date
                                        function formatDateTime($datetime) {
                                            $date = new DateTime($datetime);
                                            return $date->format('M j, Y H:i');
                                        }

                                        function dateDiffrent($datetime) {
                                            $date = new DateTime($datetime);
                                            $diff = $date->diff(new DateTime());
                                            if($diff->y > 0) {
                                                return $diff->y . ' years ago';
                                            } else if($diff->m > 0) {
                                                return $diff->m . ' months ago';
                                            } else if($diff->d > 0) {
                                                return $diff->d . ' days ago';
                                            } else if($diff->h > 0) {
                                                return $diff->h . ' hours ago';
                                            } else if($diff->i > 0) {
                                                return $diff->i . ' minutes ago';
                                            } else {
                                                return 'just now';
                                            }
                                        }

                                        // Combine all activities
                                        $activities = array_merge(
                                            array_map(function($booking) {
                                                return [
                                                    'type' => 'booking',
                                                    'icon' => 'fas fa-calendar-check',
                                                    'color' => 'text-success',
                                                    'title' => 'New Booking: ' . $booking['car_name'],
                                                    'subtitle' => 'By User ID: ' . $booking['user_id'] . ' | ' . formatDateTime($booking['pickup_date']),
                                                    'time' => dateDiffrent($booking['pickup_date'])
                                                ];
                                            }, $recentBookings),
                                            array_map(function($spend) {
                                                return [
                                                    'type' => 'spend',
                                                    'icon' => 'fas fa-money-bill',
                                                    'color' => 'text-primary',
                                                    'title' => 'Money Spent: $' . number_format($spend['total_price'], 2),
                                                    'subtitle' => 'For ' . $spend['car_brand'] . ' ' . $spend['car_name'],
                                                    'time' => dateDiffrent($spend['pickup_date'])
                                                ];
                                            }, $recentSpendedMoney),
                                            array_map(function($testimonial) {
                                                return [
                                                    'type' => 'testimonial',
                                                    'icon' => 'fas fa-star',
                                                    'color' => 'text-warning',
                                                    'title' => 'New Testimonial',
                                                    'subtitle' => $testimonial['user_name_display'] . ' rated ' . $testimonial['rating'] . '/5',
                                                    'time' => dateDiffrent($testimonial['submitted_at'])
                                                ];
                                            }, $recentTestimonials),
                                            array_map(function($message) {
                                                return [
                                                    'type' => 'message',
                                                    'icon' => 'fas fa-comment-dots',
                                                    'color' => 'text-info',
                                                    'title' => 'New Message',
                                                    'subtitle' => 'From: ' . $message['name'] . ' | Subject: ' . $message['subject'],
                                                    'time' => dateDiffrent($message['received_at'])
                                                ];
                                            }, $recentMessages),
                                            array_map(function($car) {
                                                return [
                                                    'type' => 'car',
                                                    'icon' => 'fas fa-car',
                                                    'color' => 'text-primary',
                                                    'title' => 'New Car Added',
                                                    'subtitle' => $car['make'] . ' ' . $car['name'],
                                                    'time' => dateDiffrent($car['added_at']) ?? date('Y-m-d H:i:s')
                                                ];
                                            }, $recentCars),
                                            array_map(function($user) {
                                                return [
                                                    'type' => 'user',
                                                    'icon' => 'fas fa-user-plus',
                                                    'color' => 'text-success',
                                                    'title' => 'New User Registered',
                                                    'subtitle' => $user['email'],
                                                    'time' => dateDiffrent($user['registered_at']) ?? date('Y-m-d H:i:s')
                                                ];
                                            }, $recentUsers)
                                        );

                                        // Sort activities by time
                                        usort($activities, function($a, $b) {
                                            return strtotime($b['time']) - strtotime($a['time']);
                                        });

                                        // Display up to 5 activities
                                        $activities = array_slice($activities, 0, 10);

                                        foreach ($activities as $activity) {
                                            echo "<li class='list-group-item d-flex justify-content-between align-items-center wow fadeIn' data-wow-delay='1s'>
                                                <div class='d-flex align-items-center'>
                                                    <i class='" . $activity['icon'] . " fa-fw me-3 " . $activity['color'] . "'></i>
                                                    <div>
                                                        <strong>{$activity['title']}</strong>
                                                        <small class='d-block text-muted'>{$activity['subtitle']}</small>
                                                    </div>
                                                </div>
                                                <span class='badge bg-danger text-white'>" . $activity['time'] . "</span>
                                            </li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-lg-4 wow fadeInUp" data-wow-delay="1s">
                            <div class="card shadow-sm ">
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0">Quick Actions</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="manage-cars.php" class="btn btn-primary wow fadeInDown" data-wow-delay="1.1s">
                                            <i class="fas fa-car me-2"></i>Manage Cars
                                        </a>
                                        <a href="manage-reservations.php" class="btn btn-success wow fadeInDown" data-wow-delay="1.2s">
                                            <i class="fas fa-calendar-alt me-2"></i>View Reservations
                                        </a>
                                        <a href="manage-users.php" class="btn btn-secondary wow fadeInDown" data-wow-delay="1.3s">
                                            <i class="fas fa-users-cog me-2"></i>Manage Users
                                        </a>
                                        <a href="manage-testimonials.php" class="btn btn-warning wow fadeInDown" data-wow-delay="1.4s">
                                            <i class="fas fa-comments me-2"></i>Manage Testimonials
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bottom Navigation With The Scripts -->
    <?php include '../includes/bottom-nav.php'; ?>

</body>
</html>