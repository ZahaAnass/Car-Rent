<div class="bottom-nav d-md-none position-sticky bottom-0 start-0 end-0" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center bg-dark py-2 shadow-lg">
            <div class="col-2">
                <a href="../public/index.php" class="text-white">
                    <i class="fas fa-home"></i>
                    <small class="d-block" style="font-size: 11px;">Home</small>
                </a>
            </div>
            <div class="col-2 p-0">
                <a href="dashbord.php" class="text-center <?= basename($_SERVER['PHP_SELF']) == 'dashbord.php' ? 'centerprimary' : 'text-white' ?>">
                    <i class="fas fa-user"></i>
                    <small class="d-block" style="font-size: 11px;">Dashboard</small>
                </a>
            </div>
            <div class="col-2 p-0">
                <a href="book-car.php" class="text-center <?= basename($_SERVER['PHP_SELF']) == 'book-car.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-car"></i>
                    <small class="d-block" style="font-size: 11px;">Book</small>
                </a>
            </div>
            <div class="col-2 p-0">
                <a href="my-reservations.php" class="text-center <?= basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <small class="d-block" style="font-size: 11px;">Reservations</small>
                </a>
            </div>
            <div class="col-2 p-0">
                <a href="settings.php" class="text-center <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-cog"></i>
                    <small class="d-block" style="font-size: 11px;">Settings</small>
                </a>
            </div>
            <div class="col-2 p-0">
                <a href="../auth/logout.php" class="text-center text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <small class="d-block" style="font-size: 11px;">Logout</small>
                </a>
            </div>
        </div>
    </div>
</div>