<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheels - Book a Car</title>
    
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto px-4 wow fadeInDown">
                <div class="container-fluid py-5">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mb-3 display-6 wow fadeInDown">Book a Car</h1>
                            <p class="text-muted wow fadeInUp">Select your perfect vehicle and complete your booking.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Car Listing -->
                        <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="row g-4">
                                <?php 
                                $car = ['id' => 1, 'name' => 'Toyota Camry', 'type' => 'Sedan', 'price' => 45, 'seats' => 5, 'transmission' => 'Automatic', 'fuel' => 'Hybrid', 'image' => '../assets/img/car-1.png'];
                                ?>
                                <div class="col wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="card h-100 border-0 shadow-sm car-card">
                                        <div class="card-body">
                                            <div class="position-relative mb-3">
                                                <img src="<?= $car['image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $car['name'] ?>" style="object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded-pill">
                                                    $<?= $car['price'] ?>/day
                                                </div>
                                            </div>
                                            <h5 class="card-title"><?= $car['name'] ?></h5>
                                            <p class="card-text text-muted"><?= $car['type'] ?></p>
                                            <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                                                <span><i class="fas fa-users me-1 text-primary"></i><?= $car['seats'] ?> seats</span>
                                                <span><i class="fas fa-car me-1 text-primary"></i><?= $car['transmission'] ?></span>
                                                <span><i class="fas fa-gas-pump me-1 text-primary"></i><?= $car['fuel'] ?></span>
                                            </div>
                                            <button class="btn btn-primary w-100 p-2 ">Select Car</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Form -->
                        <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="card border-0 shadow-sm sticky-lg-top" style="top: 20px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Booking Details</h4>
                                    <form id="bookingForm">
                                        <div class="mb-3">
                                            <label for="pickup-date" class="form-label">Pickup Date</label>
                                            <input type="date" class="form-control" id="pickup-date" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="return-date" class="form-label">Return Date</label>
                                            <input type="date" class="form-control" id="return-date" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pickup-location" class="form-label">Pickup Location</label>
                                            <select class="form-select" id="pickup-location" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>Airport</option>
                                                <option>Downtown Station</option>
                                                <option>Uptown Branch</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="return-location" class="form-label">Return Location</label>
                                            <select class="form-select" id="return-location" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>Airport</option>
                                                <option>Downtown Station</option>
                                                <option>Uptown Branch</option>
                                            </select>
                                        </div>
                                        <div class="alert alert-info small d-none" id="booking-summary"></div>
                                        <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
                                    </form>
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