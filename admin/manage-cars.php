<?php
// Add session start and authentication check if needed
// session_start();
// include '../includes/session.php'; // Assuming you have session handling
// if (!is_admin()) { header('Location: ../login.php'); exit; } 
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
                                                <!-- Populate with PHP if types are dynamic -->
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
                                                // --- PHP Logic to fetch cars from database would go here ---
                                                // Example placeholder data:
                                                $cars = [
                                                    ['id' => 1, 'name' => 'Toyota Camry', 'image' => '../assets/img/car-1.png', 'type' => 'Sedan', 'price' => 45.00, 'status' => 'Available'],
                                                    ['id' => 2, 'name' => 'Honda CR-V', 'image' => '../assets/img/car-2.png', 'type' => 'SUV', 'price' => 60.00, 'status' => 'Rented'],
                                                    ['id' => 3, 'name' => 'Ford Mustang', 'image' => '../assets/img/car-3.png', 'type' => 'Sport', 'price' => 80.00, 'status' => 'Maintenance'],
                                                    ['id' => 4, 'name' => 'Ford Mustang', 'image' => '../assets/img/car-4.png', 'type' => 'Sport', 'price' => 80.00, 'status' => 'Maintenance'],
                                                    ['id' => 5, 'name' => 'Ford Mustang', 'image' => '../assets/img/car-1.png', 'type' => 'Sport', 'price' => 80.00, 'status' => 'Maintenance'],
                                                    ['id' => 6, 'name' => 'Ford Mustang', 'image' => '../assets/img/car-2.png', 'type' => 'Sport', 'price' => 80.00, 'status' => 'Maintenance'],
                                                    ['id' => 7, 'name' => 'Ford Mustang', 'image' => '../assets/img/car-3.png', 'type' => 'Sport', 'price' => 80.00, 'status' => 'Maintenance'],
                                                ];

                                                if (empty($cars)) {
                                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No cars found.</td></tr>';
                                                } else {
                                                    foreach ($cars as $car): 
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>" style="width: 80px; height: auto; object-fit: cover;">
                                                        </td>
                                                        <td><?= htmlspecialchars($car['name']) ?></td>
                                                        <td><?= htmlspecialchars($car['type']) ?></td>
                                                        <td>$<?= number_format($car['price'], 2) ?></td>
                                                        <td>
                                                            <?php 
                                                                $status_badge = 'secondary';
                                                                if ($car['status'] == 'Available') $status_badge = 'success';
                                                                if ($car['status'] == 'Rented') $status_badge = 'warning text-dark';
                                                                if ($car['status'] == 'Maintenance') $status_badge = 'info text-dark';
                                                            ?>
                                                            <span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($car['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Edit Car <?= $car['id'] ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Car <?= $car['id'] ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    endforeach; 
                                                }
                                                // --- End PHP Logic ---
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <?php if (!empty($cars)): ?>
                                    <!-- Optional: Add Pagination if many cars -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
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
                    <!-- Add Car Form Goes Here -->
                    <form>
                        <div class="mb-3">
                            <label for="carName" class="form-label">Car Name</label>
                            <input type="text" class="form-control" id="carName" required>
                        </div>
                        <div class="mb-3">
                            <label for="carType" class="form-label">Car Type</label>
                            <select class="form-select" id="carType" required>
                                <option selected disabled value="">Choose...</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>Truck</option>
                                <option>Van</option>
                                <option>Sport</option>
                                <option>Luxury</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="carRate" class="form-label">Price ($)</label>
                            <input type="number" step="0.01" class="form-control" id="carRate" required>
                        </div>
                        <div class="mb-3">
                            <label for="carImage" class="form-label">Car Image URL</label>
                            <input type="url" class="form-control" id="carImage" placeholder="https://example.com/image.png">
                            <small class="form-text text-muted">Or upload an image:</small>
                            <input type="file" class="form-control mt-1" id="carImageFile">
                        </div>
                        <div class="mb-3">
                            <label for="carStatus" class="form-label">Status</label>
                            <select class="form-select" id="carStatus" required>
                                <option value="Available" selected>Available</option>
                                <option value="Rented">Rented</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="carDescription" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="carDescription" rows="3"></textarea>
                        </div>
                        <!-- Add more fields as needed: features, license plate, etc. -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="" class="btn btn-primary">Save Car</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

</body>
</html>