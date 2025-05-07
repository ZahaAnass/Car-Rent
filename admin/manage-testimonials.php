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
    <title>Zoomix Admin - Manage Testimonials</title>
    
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
                    <!-- Page Title -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col">
                            <h1 class="display-6 mb-2">Manage Testimonials</h1>
                            <p class="text-muted mb-0">Review and publish user feedback.</p>
                        </div>
                        <!-- Optional: Add filters (Status: Pending/Approved/Rejected) -->
                    </div>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label for="filterTestimonialStatus" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="filterTestimonialStatus">
                                                <option selected value="">All Statuses</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterSearchTestimonial" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="filterSearchTestimonial" placeholder="Search by User or Content...">
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

                    <!-- Testimonials List/Table -->
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Testimonial</th>
                                                    <th scope="col">Date Submitted</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // --- PHP Logic to fetch testimonials from database ---
                                                $testimonials = [
                                                    ['id' => 1, 'user_name' => 'Jane Smith', 'user_id' => 5, 'testimonial' => 'Fantastic service! The booking was easy, the car was clean, and the return was hassle-free. Highly recommend Zoomix!', 'date_submitted' => '2025-05-03', 'status' => 'Approved'],
                                                    ['id' => 2, 'user_name' => 'John Doe', 'user_id' => 2, 'testimonial' => 'Good selection of cars. The Mustang I rented was a blast to drive.', 'date_submitted' => '2025-05-01', 'status' => 'Approved'],
                                                    ['id' => 3, 'user_name' => 'Robert Johnson', 'user_id' => 8, 'testimonial' => 'Decent experience, but the pickup location was a bit hard to find.', 'date_submitted' => '2025-05-05', 'status' => 'Pending'],
                                                    ['id' => 4, 'user_name' => 'Anonymous', 'user_id' => null, 'testimonial' => 'Very expensive compared to others.', 'date_submitted' => '2025-05-04', 'status' => 'Rejected'],
                                                    ['id' => 5, 'user_name' => 'Alice Johnson', 'user_id' => 10, 'testimonial' => 'The car was in perfect condition, and the driver was very helpful.', 'date_submitted' => '2025-05-02', 'status' => 'Approved'],
                                                    ['id' => 6, 'user_name' => 'Bob Smith', 'user_id' => 12, 'testimonial' => 'The car was in perfect condition, and the driver was very helpful.', 'date_submitted' => '2025-05-02', 'status' => 'Approved'],
                                                    ['id' => 7, 'user_name' => 'Charlie Brown', 'user_id' => 14, 'testimonial' => 'The car was in perfect condition, and the driver was very helpful.', 'date_submitted' => '2025-05-02', 'status' => 'Approved'],
                                                ];

                                                if (empty($testimonials)) {
                                                    echo '<tr><td colspan="5" class="text-center text-muted py-4">No testimonials found.</td></tr>';
                                                } else {
                                                    foreach ($testimonials as $testimonial): 
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($testimonial['user_id']): ?>
                                                                <a href="manage-users.php?view=<?= $testimonial['user_id'] ?>" data-bs-toggle="tooltip" title="View User Details">
                                                                    <?= htmlspecialchars($testimonial['user_name']) ?>
                                                                </a>
                                                            <?php else: ?>
                                                                <?= htmlspecialchars($testimonial['user_name']) ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="max-width: 400px;">
                                                            <span title="<?= htmlspecialchars($testimonial['testimonial']) ?>" data-bs-toggle="tooltip">
                                                                <?= htmlspecialchars(substr($testimonial['testimonial'], 0, 100)) ?>
                                                                <?= strlen($testimonial['testimonial']) > 100 ? '...' : '' ?>
                                                            </span>
                                                        </td>
                                                        <td><?= htmlspecialchars($testimonial['date_submitted']) ?></td>
                                                        <td>
                                                            <?php 
                                                                $status_badge = 'secondary';
                                                                if ($testimonial['status'] == 'Approved') $status_badge = 'success';
                                                                if ($testimonial['status'] == 'Pending') $status_badge = 'warning text-dark';
                                                                if ($testimonial['status'] == 'Rejected') $status_badge = 'danger';
                                                            ?>
                                                            <span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($testimonial['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <!-- Actions based on status -->
                                                            <?php if ($testimonial['status'] == 'Pending'): ?>
                                                                <button class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Approve Testimonial <?= $testimonial['id'] ?>">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-warning text-dark me-1" data-bs-toggle="tooltip" title="Reject Testimonial <?= $testimonial['id'] ?>">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            <?php elseif ($testimonial['status'] == 'Approved'): ?>
                                                                <button class="btn btn-sm btn-outline-warning text-dark me-1" data-bs-toggle="tooltip" title="Reject Testimonial <?= $testimonial['id'] ?>">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            <?php endif; ?>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Testimonial <?= $testimonial['id'] ?>">
                                                                <i class="fas fa-trash"></i> Delete
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
                                    
                                    <?php if (!empty($testimonials)): ?>
                                    <!-- Optional: Add Pagination -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
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

</body>
</html>