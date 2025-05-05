<div class="col-md-4 col-lg-3 d-none d-md-block bg-dark sidebar wow fadeInLeft" style="min-height: 100vh;"> 
    <div class="position-sticky pt-3">
        <a href="../public/index.php" class="d-flex align-items-center justify-content-center py-4 text-decoration-none wow fadeInDown">
            <h2 class="text-primary display-6">
                <i class="fas fa-car-alt me-3"></i>Zoomix
            </h2>
        </a>
        <ul class="nav nav-pills flex-column mb-auto px-3">
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.3s">
                <a href="../public/index.php" class="nav-link text-white">
                    <i class="fas fa-home me-2"></i>Home
                </a>
            </li>
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.6s">
                <a href="dashbord.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashbord.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-user me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="0.9s">
                <a href="book-car.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'book-car.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-car me-2"></i>Book a Car
                </a>
            </li>
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.2s">
                <a href="my-reservations.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-calendar-alt me-2"></i>Reservations
                </a>
            </li>
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.5s">
                <a href="settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
            </li>
            <li class="nav-item mb-2 wow fadeInRight" data-wow-delay="1.7s">
                <a href="../auth/logout.php" class="nav-link text-danger"> 
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</div>