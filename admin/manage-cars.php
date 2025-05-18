<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/car_queries.php";
    $carQueries = new CarQueries($pdo);

    // Pagination Config
    $limit = 7; // Number of cars per page
    $totalCars = $carQueries->getCarCount();
    $totalPages = ceil($totalCars / $limit);

    // Get current page and validate it and redirect to page 1 if invalid
    $page = isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages ? (int)$_GET["page"] : redirect("manage-cars.php?page=1");
    $offset = ($page - 1) * $limit;

    // Fetch cars with pagination
    $cars = $carQueries->getCarsWithLimit($limit, $offset);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoomix Admin - Manage Cars</title>
    
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
            
            <!-- Admin Sidebar -->
            <?php require_once '../includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-12 col-lg-9 col-md-8 ms-sm-auto min-vh-100 px-md-4 py-5">
                <div class="container-fluid">
                    <!-- Page Title & Add Button -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col-md-6">
                            <h1 class="display-6 mb-2">Manage Cars</h1>
                            <p class="text-muted mb-0">Add, edit, or remove rental cars.</p>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
                                <i class="fas fa-plus me-2"></i>Add New Car
                            </button>
                        </div>
                    </div>

                    <?php
                        start_session();
                        if (isset($_SESSION['register_success'])) {
                            echo "<div class='alert alert-success'>{$_SESSION['register_success']}</div>";
                            unset($_SESSION['register_success']);
                        }

                        if (isset($_SESSION['register_error'])) {
                            echo "<div class='alert alert-danger'>{$_SESSION['register_error']}</div>";
                            unset($_SESSION['register_error']);
                        }
                    ?>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label for="filterCarType" class="form-label visually-hidden">Car Type</label>
                                            <select class="form-select" id="filterCarType">
                                                <option selected value="">All Types</option>
                                                <option>Sedan</option>
                                                <option>SUV</option>
                                                <option>Truck</option>
                                                <option>Van</option>
                                                <option>Sport</option>
                                                <option>Luxury</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterCarStatus" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="filterCarStatus">
                                                <option selected value="">All Statuses</option>
                                                <option>Available</option>
                                                <option>Rented</option>
                                                <option>Maintenance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="reset" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cars Table -->
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (empty($cars)) {
                                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No cars found.</td></tr>';
                                                } else {
                                                    foreach ($cars as $car): 
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="<?= htmlspecialchars($car['image_url']) ?>" alt="<?= htmlspecialchars($car['name']) ?>" style="width: 80px; height: auto; object-fit: cover;">
                                                        </td>
                                                        <td><?= htmlspecialchars($car['name']) ?></td>
                                                        <td><?= htmlspecialchars($car['type']) ?></td>
                                                        <td>$<?= number_format($car['daily_rate'], 2) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= ($car['status'] == 'Available') ? 'success' : (($car['status'] == 'Rented') ? 'warning' : 'info') ?>"><?= htmlspecialchars($car['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Edit Car <?= $car['car_id'] ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Car <?= $car['car_id'] ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    endforeach; 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php if ($totalPages > 1): ?>
                                        <nav aria-label="Page navigation" class="mt-4">
                                            <ul class="pagination justify-content-center">
                                                <!-- Previous -->
                                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                                                </li>

                                                <?php
                                                $visiblePages = 2; // Number of pages before/after the current one to show
                                                $start = max(1, $page - $visiblePages);
                                                $end = min($totalPages, $page + $visiblePages);

                                                // Always show first page
                                                if ($start > 1):
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                                                    <?php if ($start > 2): ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <!-- Page Numbers Around Current -->
                                                <?php for ($i = $start; $i <= $end; $i++): ?>
                                                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <!-- Always show last page -->
                                                <?php if ($end < $totalPages): ?>
                                                    <?php if ($end < $totalPages - 1): ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                    <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>"><?= $totalPages ?></a></li>
                                                <?php endif; ?>

                                                <!-- Next -->
                                                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <?php require_once '../includes/bottom-nav.php'; ?>

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCarForm" method="POST" action="manage-car-handeler.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="carName" class="form-label">Car Name</label>
                            <input type="text" class="form-control" id="carName" name="name" required placeholder="e.g. Tesla Model S">
                        </div>
                        <div class="mb-3">
                            <label for="carType" class="form-label">Car Type</label>
                            <select class="form-select" id="carType" name="type" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="Electric">Electric</option>
                                <option value="SUV">SUV</option>
                                <option value="Luxury">Luxury</option>
                                <option value="Economy">Economy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="carDescription" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="carDescription" name="description" rows="3" placeholder="e.g. Premium electric sedan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="carRate" class="form-label">Daily Rate ($)</label>
                            <input type="number" step="0.01" class="form-control" id="carRate" name="daily_rate" required placeholder="e.g. 150.00">
                        </div>
                        <div class="mb-3">
                            <label for="carImageFile" class="form-label">Car Image</label>
                            <input type="file" class="form-control mt-1" id="carImageFile" name="car_image_file" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                        <div class="mb-3">
                            <label for="carStatus" class="form-label">Status</label>
                            <select class="form-select" id="carStatus" name="status" required>
                                <option value="Available" selected>Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="carLicense" class="form-label">License Plate</label>
                            <input type="text" class="form-control" id="carLicense" name="license_plate" required placeholder="e.g. TESLA12345">
                        </div>
                        <div class="mb-3">
                            <label for="carYear" class="form-label">Year</label>
                            <input type="number" class="form-control" id="carYear" name="year" required min="1900" max="<?= date('Y') + 1 ?>" placeholder="e.g. 2023">
                        </div>
                        <div class="mb-3">
                            <label for="carMake" class="form-label">Make</label>
                            <input type="text" class="form-control" id="carMake" name="make" required placeholder="e.g. Tesla">
                        </div>
                        <div class="mb-3">
                            <label for="carModel" class="form-label">Model</label>
                            <input type="text" class="form-control" id="carModel" name="model" required placeholder="e.g. Model S">
                        </div>
                        <div class="mb-3">
                            <label for="carColor" class="form-label">Color</label>
                            <input type="text" class="form-control" id="carColor" name="color" required placeholder="e.g. Red">
                        </div>
                        <div class="mb-3">
                            <label for="carSeats" class="form-label">Seats</label>
                            <input type="number" class="form-control" id="carSeats" name="seats" required min="1" max="9" placeholder="e.g. 5">
                        </div>
                        <div class="mb-3">
                            <label for="carFuel" class="form-label">Fuel Type</label>
                            <input type="text" class="form-control" id="carFuel" name="fuel_type" required placeholder="e.g. Electric">
                        </div>
                        <div class="mb-3">
                            <label for="carFeatures" class="form-label">Features (Optional, comma-separated)</label>
                            <input type="text" class="form-control" id="carFeatures" name="features" placeholder="e.g. Autopilot, Navigation, Leather Seats">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addCarForm" class="btn btn-primary">Save Car</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <script src="../assets/js/manage-car-verify.js"></script>

</body>
</html>