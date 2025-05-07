<?php
// Get the current script's path relative to the document root
$current_path = $_SERVER['PHP_SELF'];
// Get the current page filename for active link highlighting
$current_page = basename($current_path);

// Determine if we are in the admin or user section
$is_admin_section = strpos($current_path, '/admin/') !== false; 

// Common styles for the small text
$small_style = 'style="font-size: 11px;"'; 
?>

<div class="bottom-nav d-md-none position-sticky bottom-0 start-0 end-0" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center bg-dark py-2 shadow-lg">

            <?php if ($is_admin_section): ?>
                
                <!-- Admin Bottom Nav Links -->
                <div class="col-2 p-0">
                    <a href="dashboard.php" class="text-center <?= $current_page == 'dashboard.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <small class="d-block" <?= $small_style ?>>Dashboard</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="manage-cars.php" class="text-center <?= $current_page == 'manage-cars.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-car"></i>
                        <small class="d-block" <?= $small_style ?>>Cars</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="manage-reservations.php" class="text-center <?= $current_page == 'manage-reservations.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-calendar-check"></i>
                        <small class="d-block" <?= $small_style ?>>Bookings</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="manage-users.php" class="text-center <?= $current_page == 'manage-users.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-users"></i>
                        <small class="d-block" <?= $small_style ?>>Users</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="manage-message.php" class="text-center <?= $current_page == 'manage-message.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-envelope"></i>
                        <small class="d-block" <?= $small_style ?>>Messages</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="../auth/logout.php" class="text-center text-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        <small class="d-block" <?= $small_style ?>>Logout</small>
                    </a>
                </div>

            <?php else: ?>

                <!-- User Bottom Nav Links -->
                <div class="col-2 p-0">
                    <a href="../public/index.php" class="text-center text-white">
                        <i class="fas fa-home"></i>
                        <small class="d-block" <?= $small_style ?>>Home</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="dashboard.php" class="text-center <?= $current_page == 'dashboard.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-user"></i>
                        <small class="d-block" <?= $small_style ?>>Dashboard</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="book-car.php" class="text-center <?= $current_page == 'book-car.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-car"></i>
                        <small class="d-block" <?= $small_style ?>>Book</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="my-reservations.php" class="text-center <?= $current_page == 'my-reservations.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-calendar-alt"></i>
                        <small class="d-block" <?= $small_style ?>>Bookings</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="settings.php" class="text-center <?= $current_page == 'settings.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-cog"></i>
                        <small class="d-block" <?= $small_style ?>>Settings</small>
                    </a>
                </div>
                <div class="col-2 p-0">
                    <a href="add-testimonial.php" class="text-center <?= $current_page == 'add-testimonial.php' ? 'text-primary' : 'text-white' ?>">
                        <i class="fas fa-comment-dots"></i>
                        <small class="d-block" <?= $small_style ?>>Testimonial</small>
                    </a>
                </div>

            <?php endif; ?>

        </div>
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