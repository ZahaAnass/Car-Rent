<div class="col-md-4 col-lg-3 d-none d-md-block bg-dark sidebar" style="height: 100vh;">
    <div class="position-sticky pt-3">
        <a href="#" class="d-flex align-items-center justify-content-center py-4 text-decoration-none">
            <h2 class="text-white">Rent-A-Wheels</h2>
        </a>
        <ul class="nav nav-pills flex-column mb-auto px-3">
            <li class="nav-item mb-2">
                <a href="dashbord.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashbord.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-home me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="book-car.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'book-car.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-car me-2"></i>Book a Car
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="my-reservations.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-calendar-alt me-2"></i>Reservations
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
            </li>
        </ul>
    </div>
</div>