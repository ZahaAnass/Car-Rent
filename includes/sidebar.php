<?php
// Get the current script's path relative to the document root
$current_path = $_SERVER['PHP_SELF'];

// Get the current page filename for active link highlighting
$current_page = basename($current_path);

// Check if we are in the admin or user section
$is_admin_section = strpos($current_path, '/admin/') !== false; 
?>

<div class="col-md-4 col-lg-3 d-none d-md-block bg-dark sidebar wow fadeInLeft" style="min-height: 100vh;"> 
    <div class="position-sticky pt-3">
        <a href="../public/index.php" class="d-flex align-items-center justify-content-center py-4 text-decoration-none wow fadeInDown">
            <h2 class="text-primary display-6">
                <i class="fas fa-car-alt me-3"></i>Zoomix
                <?php if ($is_admin_section): ?>
                    <span class="text-white">Admin</span>
                <?php endif; ?>
            </h2>
        </a>

        <?php if ($is_admin_section): ?>
            <!-- Admin Sidebar Links -->
            <ul class="nav nav-pills flex-column mb-auto px-3">
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.3s">
                    <a href="../public/index.php" class="nav-link text-white">
                        <i class="fas fa-home fa-fw me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.5s">
                    <a href="dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.7s">
                    <a href="manage-cars.php" class="nav-link <?= $current_page == 'manage-cars.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-car fa-fw me-2"></i>Manage Cars
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.9s">
                    <a href="manage-reservations.php" class="nav-link <?= $current_page == 'manage-reservations.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-calendar-alt fa-fw me-2"></i>Manage Bookings
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.1s">
                    <a href="manage-users.php" class="nav-link <?= $current_page == 'manage-users.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-users fa-fw me-2"></i>Manage Users
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.3s">
                    <a href="manage-message.php" class="nav-link <?= $current_page == 'manage-message.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-envelope fa-fw me-2"></i>Messages
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.5s">
                    <a href="manage-testimonials.php" class="nav-link <?= $current_page == 'manage-testimonials.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-comment-dots fa-fw me-2"></i>Testimonials
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.7s">
                    <a href="settings.php" class="nav-link <?= $current_page == 'settings.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-cog fa-fw me-2"></i>Settings
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.9s">
                    <a href="../auth/logout.php" class="nav-link text-danger"> 
                        <i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout
                    </a>
                </li>
            </ul>

        <?php else: ?>
            <!-- User Sidebar Links -->
            <ul class="nav nav-pills flex-column mb-auto px-3">
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.3s">
                    <a href="../public/index.php" class="nav-link text-white">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.6s">
                    <a href="dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.9s">
                    <a href="book-car.php" class="nav-link <?= $current_page == 'book-car.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-car me-2"></i>Book a Car
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.2s">
                    <a href="my-reservations.php" class="nav-link <?= $current_page == 'my-reservations.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-calendar-alt me-2"></i>My Bookings
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.5s">
                    <a href="settings.php" class="nav-link <?= $current_page == 'settings.php' ? 'active' : 'text-white' ?>">
                        <i class="fas fa-cog me-2"></i>Settings
                    </a>
                </li>
                <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.7s">
                    <a href="../auth/logout.php" class="nav-link text-danger"> 
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </li>
            </ul>
        <?php endif; ?>

    </div>
</div>