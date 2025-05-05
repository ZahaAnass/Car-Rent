<div class="bottom-nav d-md-none position-sticky bottom-0 start-0 end-0" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center bg-dark py-2 shadow-lg">
            <div class="col">
                <a href="../public/index.php" class="text-white">
                    <i class="fas fa-home"></i>
                    <small class="d-block">Home</small>
                </a>
            </div>
            <div class="col">
                <a href="dashbord.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashbord.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-user"></i>
                    <small class="d-block">Dashboard</small>
                </a>
            </div>
            <div class="col">
                <a href="book-car.php" class="<?= basename($_SERVER['PHP_SELF']) == 'book-car.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-car"></i>
                    <small class="d-block">Book</small>
                </a>
            </div>
            <div class="col">
                <a href="my-reservations.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <small class="d-block">Reservations</small>
                </a>
            </div>
            <div class="col">
                <a href="settings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'text-primary' : 'text-white' ?>">
                    <i class="fas fa-cog"></i>
                    <small class="d-block">Settings</small>
                </a>
            </div>
        </div>
    </div>
</div>