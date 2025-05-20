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
                                    <h5 class="card-title">Total Rentals</h5>
                                    <p class="h3 text-primary">12</p>
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
                                    <p class="h3 text-success">$1,245</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="1s">
                            <div class="card stat-card border-0 shadow-sm overflow-hidden">
                                <div class="card-body text-center position-relative">
                                    <div class="dashboard-icons rounded-circle p-3 d-inline-block mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                        <i class="fas fa-trophy fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title">Loyalty Points</h5>
                                    <p class="h3 text-warning">350</p>
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
                                        <li class="list-group-item d-flex justify-content-between align-items-center wow fadeIn">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-car-alt me-3 text-primary"></i>
                                                <div>
                                                    <strong>Booked Toyota Camry</strong>
                                                    <small class="d-block text-muted">Pickup on May 15, 2025</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">2 days ago</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center wow fadeIn" data-wow-delay="1s">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-check-circle me-3 text-success"></i>
                                                <div>
                                                    <strong>Returned Honda Civic</strong>
                                                    <small class="d-block text-muted">Completed rental</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-success rounded-pill">1 week ago</span>
                                        </li>
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