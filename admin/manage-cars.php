<?php
require_once '../includes/session.php';
start_session();
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/car_queries.php';
$carQueries = new CarQueries($pdo);

// Pagination Config
$limit = 7;  // Number of cars per page
$type = isset($_GET['type']) ? $_GET['type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Validate status
if (!in_array($status, array('All', 'Available', 'Rented', 'Maintenance'))) {
    $status = '';
}

// Get total cars based on filters
$totalCars = $carQueries->getCarCount($type, $status);
$totalPages = max(1, ceil($totalCars / $limit));  // Ensure at least 1 page

// Get current page and validate it
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1 || ($totalCars > 0 && $page > $totalPages)) {
    header('Location: manage-cars.php?page=1');
    exit();
}
$offset = ($page - 1) * $limit;

// Fetch cars with pagination
$cars = $carQueries->getCarsWithLimit($limit, $offset, $status, $type);
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
                                    <form class="row g-3 align-items-center" id="filterForm" method="GET">
                                        <input type="hidden" name="page" value="1">
                                        <div class="col-md-4">
                                            <label for="filterCarType" class="form-label visually-hidden">Car Type</label>
                                            <?php
                                            $carTypes = $carQueries->getCarTypes();
                                            ?>
                                            <select class="form-select" id="filterCarType" name="type">
                                                <option id="filterCarTypeAll" <?= $type === '' ? 'selected' : '' ?> value="">All Types</option>
                                                <?php foreach ($carTypes as $carType): ?>
                                                    <option id="filterCarType<?= htmlspecialchars($carType['type']) ?>" value="<?= htmlspecialchars($carType['type']) ?>" <?= $carType['type'] === $type ? 'selected' : '' ?>><?= htmlspecialchars($carType['type']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterCarStatus" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="filterCarStatus" name="status">
                                                <option id="filterCarStatusAll" <?= $status === '' ? 'selected' : '' ?> value="">All Statuses</option>
                                                <option id="filterCarStatusAvailable" <?= $status === 'Available' ? 'selected' : '' ?> value="Available">Available</option>
                                                <option id="filterCarStatusRented" <?= $status === 'Rented' ? 'selected' : '' ?> value="Rented">Rented</option>
                                                <option id="filterCarStatusMaintenance" <?= $status === 'Maintenance' ? 'selected' : '' ?> value="Maintenance">Maintenance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="reset" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
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
                                                            <img src="<?= '../' . htmlspecialchars($car['image_url']) ?>" alt="<?= htmlspecialchars($car['name']) ?>" style="width: 80px; max-height: 60px; object-fit: cover;">
                                                        </td>
                                                        <td><?= htmlspecialchars($car['name']) ?></td>
                                                        <td><?= htmlspecialchars($car['type']) ?></td>
                                                        <td>$<?= number_format($car['daily_rate'], 2) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= ($car['status'] == 'Available') ? 'success' : (($car['status'] == 'Rented') ? 'warning' : 'info') ?>"><?= htmlspecialchars($car['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-primary me-1 edit-car-btn" 
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editCarModal"
                                                                        data-car-id="<?= $car['car_id'] ?>"
                                                                        data-bs-tooltip="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="Edit Car">
                                                                    <i class="fas fa-edit"></i>
                                                                    <span class="d-none d-md-inline">Edit</span>
                                                                </button>
                                                                <form action="manage-car-handeler.php" method="POST" class="d-inline">
                                                                    <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                                                                    <button type="submit" name="delete_car" 
                                                                            class="btn btn-sm btn-outline-danger" 
                                                                            data-bs-toggle="tooltip" 
                                                                            data-bs-placement="top"
                                                                            title="Delete Car"
                                                                            onclick="return confirm('Are you sure you want to delete this car?')">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span class="d-none d-md-inline">Delete</span>
                                                                    </button>
                                                                </form>
                                                            </div>
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
                                                $visiblePages = 2;  // Number of pages before/after the current one to show
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
                            <input type="number" step="0.01" class="form-control" id="carRate" name="daily_rate" min="0" max="100000" required placeholder="e.g. 150.00">
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
                    <button type="submit" form="addCarForm" name="add_car" class="btn btn-primary">Save Car</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Start Edit Car Modal -->
    <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editCarForm" method="POST" action="manage-car-handeler.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCarModalLabel">Edit Car</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editCarId" name="car_id">
                        <div class="mb-3">
                            <label for="editCarName" class="form-label">Car Name</label>
                            <input type="text" class="form-control" id="editCarName" name="name" required placeholder="e.g. Tesla Model S">
                        </div>
                        <div class="mb-3">
                            <label for="editCarType" class="form-label">Car Type</label>
                            <select class="form-select" id="editCarType" name="type" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="Electric">Electric</option>
                                <option value="SUV">SUV</option>
                                <option value="Luxury">Luxury</option>
                                <option value="Economy">Economy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editCarDescription" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="editCarDescription" name="description" rows="3" placeholder="e.g. Premium electric sedan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCarRate" class="form-label">Daily Rate ($)</label>
                            <input type="number" step="0.01" class="form-control" id="editCarRate" name="daily_rate" required placeholder="e.g. 150.00">
                        </div>
                        <div class="mb-3">
                            <label for="editCarStatus" class="form-label">Status</label>
                            <select class="form-select" id="editCarStatus" name="status" required>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editCarLicense" class="form-label">License Plate</label>
                            <input type="text" class="form-control" id="editCarLicense" name="license_plate" required placeholder="e.g. TESLA12345">
                        </div>
                        <div class="mb-3">
                            <label for="editCarYear" class="form-label">Year</label>
                            <input type="number" class="form-control" id="editCarYear" name="year" required min="1900" max="<?= date('Y') + 1 ?>" placeholder="e.g. 2023">
                        </div>
                        <div class="mb-3">
                            <label for="editCarMake" class="form-label">Make</label>
                            <input type="text" class="form-control" id="editCarMake" name="make" required placeholder="e.g. Tesla">
                        </div>
                        <div class="mb-3">
                            <label for="editCarModel" class="form-label">Model</label>
                            <input type="text" class="form-control" id="editCarModel" name="model" required placeholder="e.g. Model S">
                        </div>
                        <div class="mb-3">
                            <label for="editCarColor" class="form-label">Color</label>
                            <input type="text" class="form-control" id="editCarColor" name="color" required placeholder="e.g. Red">
                        </div>
                        <div class="mb-3">
                            <label for="editCarSeats" class="form-label">Seats</label>
                            <input type="number" class="form-control" id="editCarSeats" name="seats" required min="1" max="9" placeholder="e.g. 5">
                        </div>
                        <div class="mb-3">
                            <label for="editCarFuel" class="form-label">Fuel Type</label>
                            <input type="text" class="form-control" id="editCarFuel" name="fuel_type" required placeholder="e.g. Electric">
                        </div>
                        <div class="mb-3">
                            <label for="editCarFeatures" class="form-label">Features (Optional, comma-separated)</label>
                            <input type="text" class="form-control" id="editCarFeatures" name="features" placeholder="e.g. Autopilot, Navigation, Leather Seats">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_car" class="btn btn-primary">Update Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit Car Modal -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-car-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Fetch car details from API 
                    const carId = this.getAttribute('data-car-id');
                    fetch(`../api/get_car_details.php?car_id=${carId}`)
                        .then(response => response.json())
                        .then(car => {
                            document.getElementById('editCarId').value = car.car_id;
                            document.getElementById('editCarName').value = car.name;
                            document.getElementById('editCarType').value = car.type;
                            document.getElementById('editCarDescription').value = car.description;
                            document.getElementById('editCarRate').value = car.daily_rate;
                            document.getElementById('editCarStatus').value = car.status;
                            document.getElementById('editCarLicense').value = car.license_plate;
                            document.getElementById('editCarYear').value = car.year;
                            document.getElementById('editCarMake').value = car.make;
                            document.getElementById('editCarModel').value = car.model;
                            document.getElementById('editCarColor').value = car.color;
                            document.getElementById('editCarSeats').value = car.seats;
                            document.getElementById('editCarFuel').value = car.fuel_type;
                            document.getElementById('editCarFeatures').value = car.features;
                        })
                        .catch(error => console.error('Error fetching car details:', error));
                });
            });
        });
        function resetFilters() {
            document.getElementById('filterCarTypeAll').selected = true;
            document.getElementById('filterCarStatusAll').selected = true;
            document.getElementById('filterForm').submit();
        }
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Add Car Form Validation
    const addCarForm = document.getElementById('addCarForm');
    if (addCarForm) {
    addCarForm.addEventListener('submit', function(e) {
    // Clear all previous custom validity messages
    clearAllValidityMessages('add');

    // Get form values
    const name = document.getElementById('carName').value.trim();
    const type = document.getElementById('carType').value;
    const daily_rate = document.getElementById('carRate').value.trim();
    const status = document.getElementById('carStatus').value;
    const year = document.getElementById('carYear').value.trim();
    const make = document.getElementById('carMake').value.trim();
    const model = document.getElementById('carModel').value.trim();
    const color = document.getElementById('carColor').value.trim();
    const seats = document.getElementById('carSeats').value.trim();
    const fuel_type = document.getElementById('carFuel').value.trim();
    const features = document.getElementById('carFeatures').value.trim();

    // Validation patterns
    const nameRegex = /^[a-zA-Z0-9\s\-_.&'\/]{2,50}$/;
    const typeRegex = /^(Electric|SUV|Luxury|Economy)$/;
    const rateRegex = /^\d+(\.\d{1,2})?$/;
    const statusRegex = /^(Available|Unavailable)$/;
    const yearRegex = /^\d{4}$/;
    const carTextRegex = /^[a-zA-Z0-9\s\-_.&'\/]{1,50}$/;
    const seatsRegex = /^[1-9]$/;
    const fuelRegex = /^[a-zA-Z0-9\s\-_.&'\/]{1,30}$/;
    const featuresRegex = /^[a-zA-Z0-9\s\-_,.]{0,200}$/;

    let isValid = true;

    // Validate required fields
    if (!name || !type || !daily_rate || !license_plate || 
        !year || !make || !model || !color || 
        !seats || !fuel_type) {
        setCustomError('carName', 'All required fields must be filled.');
        isValid = false;
    }

    // Individual field validations
    if (name && !nameRegex.test(name)) {
    setCustomError('carName', 'Car name must be 2-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (type && !typeRegex.test(type)) {
    setCustomError('carType', 'Please select a valid car type.');
    isValid = false;
    }

    if (daily_rate && !rateRegex.test(daily_rate)) {
    setCustomError('carRate', 'Daily rate must be a valid number (e.g., 150 or 150.50).');
    isValid = false;
    } else if (daily_rate && (parseFloat(daily_rate) <= 0 || parseFloat(daily_rate) > 100000)) {
    setCustomError('carRate', 'Daily rate must be between $0.01 and $100,000.');
    isValid = false;
    }

    if (status && !statusRegex.test(status)) {
    setCustomError('carStatus', 'Please select a valid status.');
    isValid = false;
    }

    if (year && !yearRegex.test(year)) {
    setCustomError('carYear', 'Year must be a 4-digit number.');
    isValid = false;
    } else if (year && (parseInt(year) < 1900 || parseInt(year) > new Date().getFullYear() + 1)) {
    setCustomError('carYear', `Year must be between 1900 and ${new Date().getFullYear() + 1}.`);
    isValid = false;
    }

    if (make && !carTextRegex.test(make)) {
    setCustomError('carMake', 'Car make must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (model && !carTextRegex.test(model)) {
    setCustomError('carModel', 'Car model must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (color && !carTextRegex.test(color)) {
    setCustomError('carColor', 'Color must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (seats && !seatsRegex.test(seats)) {
    setCustomError('carSeats', 'Number of seats must be between 1 and 9.');
    isValid = false;
    }

    if (fuel_type && !fuelRegex.test(fuel_type)) {
    setCustomError('carFuel', 'Fuel type must be 1-30 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (features && !featuresRegex.test(features)) {
    setCustomError('carFeatures', 'Features must be less than 200 characters and contain only letters, numbers, spaces, commas, hyphens, and underscores.');
    isValid = false;
    }

    if (!isValid) {
    e.preventDefault();
    return false;
    }
    });
    }

    // Edit Car Form Validation
    const editCarForm = document.getElementById('editCarForm');
    if (editCarForm) {
    editCarForm.addEventListener('submit', function(e) {
    // Clear all previous custom validity messages
    clearAllValidityMessages('edit');

    // Get form values
    const name = document.getElementById('editCarName').value.trim();
    const type = document.getElementById('editCarType').value;
    const daily_rate = document.getElementById('editCarRate').value.trim();
    const license_plate = document.getElementById('editCarLicense').value.trim();
    const status = document.getElementById('editCarStatus').value;
    const year = document.getElementById('editCarYear').value.trim();
    const make = document.getElementById('editCarMake').value.trim();
    const model = document.getElementById('editCarModel').value.trim();
    const color = document.getElementById('editCarColor').value.trim();
    const seats = document.getElementById('editCarSeats').value.trim();
    const fuel_type = document.getElementById('editCarFuel').value.trim();
    const features = document.getElementById('editCarFeatures').value.trim();

    // Same validation patterns as add car form
    const nameRegex = /^[a-zA-Z0-9\s\-_.&'\/]{2,50}$/;
    const typeRegex = /^(Electric|SUV|Luxury|Economy)$/;
    const rateRegex = /^\d+(\.\d{1,2})?$/;
    const licenseRegex = /^[A-Za-z0-9\-\s]{5,20}$/;
    const statusRegex = /^(Available|Unavailable)$/;
    const yearRegex = /^\d{4}$/;
    const carTextRegex = /^[a-zA-Z0-9\s\-_.&'\/]{1,50}$/;
    const seatsRegex = /^[1-9]$/;
    const fuelRegex = /^[a-zA-Z0-9\s\-_.&'\/]{1,30}$/;
    const featuresRegex = /^[a-zA-Z0-9\s\-_,.]{0,200}$/;

    let isValid = true;

    // Validate required fields
    if (!name || !type || !daily_rate || !license_plate || 
    !year || !make || !model || !color || 
    !seats || !fuel_type) {
    setCustomError('editCarName', 'All required fields must be filled.');
    isValid = false;
    }

    // Individual field validations
    if (name && !nameRegex.test(name)) {
    setCustomError('editCarName', 'Car name must be 2-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (type && !typeRegex.test(type)) {
    setCustomError('editCarType', 'Please select a valid car type.');
    isValid = false;
    }

    if (daily_rate && !rateRegex.test(daily_rate)) {
    setCustomError('editCarRate', 'Daily rate must be a valid number (e.g., 150 or 150.50).');
    isValid = false;
    } else if (daily_rate && (parseFloat(daily_rate) <= 0 || parseFloat(daily_rate) > 100000)) {
    setCustomError('editCarRate', 'Daily rate must be between $0.01 and $100,000.');
    isValid = false;
    }

    if (license_plate && !licenseRegex.test(license_plate)) {
    setCustomError('editCarLicense', 'License plate must be 5-20 characters and contain only letters, numbers, hyphens, and spaces.');
    isValid = false;
    }

    if (status && !statusRegex.test(status)) {
    setCustomError('editCarStatus', 'Please select a valid status.');
    isValid = false;
    }

    if (year && !yearRegex.test(year)) {
    setCustomError('editCarYear', 'Year must be a 4-digit number.');
    isValid = false;
    } else if (year && (parseInt(year) < 1900 || parseInt(year) > new Date().getFullYear() + 1)) {
    setCustomError('editCarYear', `Year must be between 1900 and ${new Date().getFullYear() + 1}.`);
    isValid = false;
    }

    if (make && !carTextRegex.test(make)) {
    setCustomError('editCarMake', 'Car make must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (model && !carTextRegex.test(model)) {
    setCustomError('editCarModel', 'Car model must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (color && !carTextRegex.test(color)) {
    setCustomError('editCarColor', 'Color must be 1-50 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (seats && !seatsRegex.test(seats)) {
    setCustomError('editCarSeats', 'Number of seats must be between 1 and 9.');
    isValid = false;
    }

    if (fuel_type && !fuelRegex.test(fuel_type)) {
    setCustomError('editCarFuel', 'Fuel type must be 1-30 characters and contain only letters, numbers, spaces, and basic punctuation.');
    isValid = false;
    }

    if (features && !featuresRegex.test(features)) {
    setCustomError('editCarFeatures', 'Features must be less than 200 characters and contain only letters, numbers, spaces, commas, hyphens, and underscores.');
    isValid = false;
    }

    if (!isValid) {
    e.preventDefault();
    return false;
    }
    });
    }

    // Helper function to set custom error messages
    function setCustomError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
    field.setCustomValidity(message);
    field.reportValidity();
    }
    }

    // Helper function to clear all custom validity messages
    function clearAllValidityMessages(formType) {
    const prefix = formType === 'edit' ? 'edit' : '';
    const fields = [
    `${prefix}carName`, `${prefix}carType`, `${prefix}carRate`, 
    `${prefix}carLicense`, `${prefix}carStatus`, `${prefix}carYear`,
    `${prefix}carMake`, `${prefix}carModel`, `${prefix}carColor`,
    `${prefix}carSeats`, `${prefix}carFuel`, `${prefix}carFeatures`
    ];

    fields.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    if (field) {
    field.setCustomValidity('');
    }
    });
    }

    // Clear validation messages on input change
    function addInputListeners(formType) {
    const prefix = formType === 'edit' ? 'edit' : '';
    const fields = [
    `${prefix}carName`, `${prefix}carType`, `${prefix}carRate`, 
    `${prefix}carLicense`, `${prefix}carStatus`, `${prefix}carYear`,
    `${prefix}carMake`, `${prefix}carModel`, `${prefix}carColor`,
    `${prefix}carSeats`, `${prefix}carFuel`, `${prefix}carFeatures`
    ];

    fields.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    if (field) {
    field.addEventListener('input', function() {
        this.setCustomValidity('');
    });
    }
    });
    }

    // Add input listeners for both forms
    addInputListeners('add');
    addInputListeners('edit');
    });
    </script>

</body>
</html>