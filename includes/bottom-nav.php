<div class="bottom-nav d-md-none position-sticky bottom-0 start-0 end-0" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center bg-dark py-2 shadow-lg">
            <div class="col">
                <a href="dashbord.php" class="text-white <?= basename($_SERVER['PHP_SELF']) == 'dashbord.php' ? 'text-primary' : '' ?>">
                    <i class="fas fa-home"></i>
                    <small class="d-block">Home</small>
                </a>
            </div>
            <div class="col">
                <a href="book-car.php" class="text-white <?= basename($_SERVER['PHP_SELF']) == 'book-car.php' ? 'text-primary' : '' ?>">
                    <i class="fas fa-car"></i>
                    <small class="d-block">Book</small>
                </a>
            </div>
            <div class="col">
                <a href="my-reservations.php" class="text-white <?= basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'text-primary' : '' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <small class="d-block">Reservations</small>
                </a>
            </div>
            <div class="col">
                <a href="settings.php" class="text-white <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'text-primary' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <small class="d-block">Settings</small>
                </a>
            </div>
        </div>
    </div>
</div>