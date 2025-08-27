<?php
    require_once '../includes/session.php';
    start_session();
    require_once '../config/database.php';
    require_once '../includes/queries/testimonial_queries.php';
    require_once '../includes/queries/user_queries.php';
    require_once '../includes/queries/booking_queries.php';
    require_once '../includes/functions.php';
    require_once '../includes/auth_user_check.php';

    $testimonialQueries = new TestimonialQueries($pdo);
    $user = new UserQueries($pdo);
    $booking = new BookingQueries($pdo);

    $userData = $user->getUserById($_SESSION['user_id']);

    $spendedMoney = $user->getAllSpendedMoney($_SESSION['user_id']) ?? 0;
    $totalBookings = $booking->getTotalBookingsByUserId($_SESSION['user_id']) ?? 0;
    $totalTestimonials = $testimonialQueries->getAllTestimonialsCount($_SESSION['user_id']) ?? 0;

    $displayName = $userData['first_name'] . ' ' . $userData['last_name'];

    $recentBookings = $booking->getRecentBookingsByUserId($_SESSION['user_id']);
    $recentSpendedMoney = $user->getRecentSpendedMoney($_SESSION['user_id']);
    $recentTestimonials = $testimonialQueries->getRecentTestimonialsByUserId($_SESSION['user_id']);

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
    <!-- Spinner Start -->
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
                            <h1 class="mb-3 display-6 wow fadeInDown">Dashboard</h1>
                            <p class="text-muted wow fadeInUp">Welcome back! Here's an overview of your rental activity.</p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                        <i class="fas fa-car fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Bookings</h5>
                                    <p class="h3 text-primary"><?php echo $totalBookings; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.7s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                        <i class="fas fa-credit-card fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Spent</h5>
                                    <p class="h3 text-success"><?php echo $spendedMoney; ?> $</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="1s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                        <i class="fas fa-trophy fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Total Testimonials</h5>
                                    <p class="h3 text-warning"><?php echo $totalTestimonials; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Recent Activity -->
                        <div class="col-lg-8 mb-3 wow fadeInDown" data-wow-delay="0.7s">
                            <div class="card activity-card overflow-hidden">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Recent Activity</h4>
                                    <a href="my-reservations.php" class="btn btn-sm btn-outline-primary wow heartBeat" data-wow-delay="2s">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        // Helper functions
                                        function formatDate($date) {
                                            return date('F j, Y', strtotime($date));
                                        }

                                        function timeAgo($date) {
                                            $now = time();
                                            $diff = $now - strtotime($date);
                                            
                                            $periods = array(
                                                'year' => 31556926,
                                                'month' => 2629744,
                                                'week' => 604800,
                                                'day' => 86400,
                                                'hour' => 3600,
                                                'minute' => 60,
                                                'second' => 1
                                            );
                                            
                                            foreach($periods as $key => $value) {
                                                if($diff >= $value) {
                                                    $time = floor($diff/$value);
                                                    return $time . ' ' . $key . ($time > 1 ? 's' : '') . ' ago';
                                                }
                                            }
                                            return 'just now';
                                        }

                                        $recentBookings = $booking->getRecentBookingsByUserId($_SESSION['user_id']);
                                        $recentSpendedMoney = $user->getRecentSpendedMoney($_SESSION['user_id']);
                                        $recentTestimonials = $testimonialQueries->getRecentTestimonialsByUserId($_SESSION['user_id']);

                                        $activities = array_merge(
                                            array_map(function($booking) {
                                                return [
                                                    'type' => 'booking',
                                                    'icon' => $booking['status'] === 'completed' ? 'fa-check-circle' : 'fa-car-alt',
                                                    'icon_color' => $booking['status'] === 'completed' ? 'text-success' : 'text-primary',
                                                    'title' => ($booking['status'] === 'completed' ? 'Returned' : 'Booked') . ' ' . $booking['car_brand'] . ' ' . $booking['car_name'],
                                                    'subtitle' => $booking['status'] === 'completed' ? 'Completed rental' : 'Pickup on ' . formatDate($booking['pickup_date']),
                                                    'timestamp' => $booking['status'] === 'completed' ? $booking['return_date'] : $booking['pickup_date'],
                                                    'badge_color' => $booking['status']
                                                ];
                                            }, $recentBookings),
                                            array_map(function($spend) {
                                                return [
                                                    'type' => 'spend',
                                                    'icon' => 'fa-money-bill',
                                                    'icon_color' => 'text-warning',
                                                    'title' => 'Spent ' . $spend['total_price'] . ' $',
                                                    'subtitle' => 'Rented ' . $spend['car_brand'] . ' ' . $spend['car_name'],
                                                    'timestamp' => $spend['pickup_date'],
                                                    'badge_color' => 'warning'
                                                ];
                                            }, $recentSpendedMoney),
                                            array_map(function($testimonial) {
                                                return [
                                                    'type' => 'testimonial',
                                                    'icon' => 'fa-star',
                                                    'icon_color' => 'text-info',
                                                    'title' => 'You left a testimonial',
                                                    'subtitle' => $testimonial['rating'] . ' stars',
                                                    'timestamp' => $testimonial['created_at'],
                                                    'badge_color' => 'info'
                                                ];
                                            }, $recentTestimonials)
                                        );

                                        usort($activities, function($a, $b) {
                                            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
                                        });

                                        $activities = array_slice($activities, 0, 10);

                                        if (empty($activities)) {
                                            echo "<li class='list-group-item d-flex justify-content-between align-items-center wow fadeIn' data-wow-delay='1s'>
                                                <div class='d-flex align-items-center'>
                                                    <i class='fas fa-info-circle text-info me-3'></i>
                                                    <div>
                                                        <strong>No activities found</strong>
                                                    </div>
                                                </div>
                                            </li>";
                                        } else {
                                            foreach ($activities as $activity) {
                                                $timeAgo = timeAgo($activity['timestamp']);
                                                    echo "<li class='list-group-item d-flex justify-content-between align-items-center wow fadeIn' data-wow-delay='1s'>
                                                            <div class='d-flex align-items-center'>
                                                                <i class='fas {$activity['icon']} {$activity['icon_color']} me-3'></i>
                                                                <div>
                                                                    <strong>{$activity['title']}</strong>
                                                                    <small class='d-block text-muted'>{$activity['subtitle']}</small>
                                                                </div>
                                                            </div>
                                                            <span class='badge bg-{$activity['badge_color']} rounded-pill'>{$timeAgo}</span>
                                                        </li>";
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.9s">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h4 class="card-title">Quick Actions</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <a href="book-car.php" class="btn btn-primary wow fadeInDown" data-wow-delay="1s">
                                            <i class="fas fa-car me-2"></i>Book a Car
                                        </a>
                                        <a href="my-reservations.php" class="btn btn-success wow fadeInDown" data-wow-delay="2s">
                                            <i class="fas fa-calendar-alt me-2"></i>View Reservations
                                        </a>
                                        <a href="settings.php" class="btn btn-secondary wow fadeInDown" data-wow-delay="3s">
                                            <i class="fas fa-user-cog me-2"></i>Update Profile
                                        </a>
                                        <a href="add-testimonial.php" class="btn btn-warning text-white wow fadeInDown" data-wow-delay="4s">
                                            <i class="fas fa-star me-2"></i>Add Testimonial
                                        </a>
                                        <a href="settings.php" class="btn btn-dark wow fadeInDown" data-wow-delay="1.6s">
                                            <i class="fas fa-cog me-2"></i>Settings
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