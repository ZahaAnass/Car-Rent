<?php
require_once "../includes/session.php";
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/testimonial_queries.php";
require_once "../includes/queries/user_queries.php";
require_once "../includes/auth_admin_check.php";

$testimonialQueries = new TestimonialQueries($pdo);
$userQueries = new UserQueries($pdo);

// Get filter/search from GET
$status_filter = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : null;
$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : null;

// Validate status filter
if ($status_filter && !in_array($status_filter, ['Pending', 'Approved', 'Rejected'])) {
    $status_filter = null;
}

// Pagination config
$limit = 10; // Number of testimonials per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Get total testimonials with filter/search
$totalTestimonials = $testimonialQueries->getTestimonialCount($status_filter, $search);
$totalPages = $totalTestimonials > 0 ? ceil($totalTestimonials / $limit) : 1;

// Validate page number
if ($page > $totalPages && $totalPages > 0) {
    // Redirect to last valid page with current filters
    $q = [];
    if ($status_filter) $q[] = 'status=' . urlencode($status_filter);
    if ($search) $q[] = 'search=' . urlencode($search);
    $qs = $q ? ('&' . implode('&', $q)) : '';
    redirect("manage-testimonials.php?page=$totalPages$qs");
}

// Fetch filtered testimonials for current page
$testimonials = $testimonialQueries->getTestimonialsWithLimit($limit, $offset, $status_filter, $search);
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
                    <!-- Success/Error Messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Page Title -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col">
                            <h1 class="display-6 mb-2">Manage Testimonials</h1>
                            <p class="text-muted mb-0">Review and publish user feedback.</p>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center" method="GET">
                                        <div class="col-md-4">
                                            <label for="status" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                                                <option value="">All Statuses</option>
                                                <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Approved" <?= $status_filter === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                <option value="Rejected" <?= $status_filter === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="search" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search by User or Content..." value="<?= htmlspecialchars($search ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="manage-testimonials.php" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </a>
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
                                                    <th scope="col">Rating</th>
                                                    <th scope="col">Date Submitted</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (empty($testimonials)) {
                                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No testimonials found.</td></tr>';
                                                } else {
                                                    foreach ($testimonials as $testimonial): 
                                                        $displayName = htmlspecialchars($testimonial['user_name_display']);
                                                        if ($testimonial['first_name'] && $testimonial['last_name']) {
                                                            $fullName = htmlspecialchars($testimonial['first_name'] . ' ' . $testimonial['last_name']);
                                                        } else {
                                                            $fullName = $displayName;
                                                        }
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($testimonial['user_id']): ?>
                                                                <?= $fullName ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="max-width: 400px;">
                                                            <?php 
                                                            $testimonialText = htmlspecialchars($testimonial['testimonial_text']);
                                                            $truncatedText = strlen($testimonialText) > 100 ? substr($testimonialText, 0, 100) . '...' : $testimonialText;
                                                            ?>
                                                            <span title="<?= $testimonialText ?>" data-bs-toggle="tooltip">
                                                                <?= $truncatedText ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $rating = (int)($testimonial['rating'] ?? 0);
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $rating) {
                                                                    echo '<i class="fas fa-star text-warning"></i>';
                                                                } else {
                                                                    echo '<i class="far fa-star text-muted"></i>';
                                                                }
                                                            }
                                                            ?>
                                                            <br><small class="text-muted"><?= $rating ?>/5</small>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            try {
                                                                echo date('M j, Y', strtotime($testimonial['submitted_at']));
                                                            } catch (Exception $e) {
                                                                echo htmlspecialchars($testimonial['submitted_at']);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $status_badge = 'secondary';
                                                                $status = $testimonial['status'] ?? 'Pending';
                                                                if ($status == 'Approved') $status_badge = 'success';
                                                                if ($status == 'Pending') $status_badge = 'warning text-dark';
                                                                if ($status == 'Rejected') $status_badge = 'danger';
                                                            ?>
                                                            <span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($status) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <!-- Actions based on status -->
                                                            <?php if ($status == 'Pending'): ?>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Approve Testimonial">
                                                                        <i class="fas fa-check"></i> Approve
                                                                    </button>
                                                                </form>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-warning text-dark me-1" data-bs-toggle="tooltip" title="Reject Testimonial">
                                                                        <i class="fas fa-times"></i> Reject
                                                                    </button>
                                                                </form>
                                                            <?php elseif ($status == 'Approved'): ?>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="pending">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="tooltip" title="Mark as Pending">
                                                                        <i class="fas fa-clock"></i> Pending
                                                                    </button>
                                                                </form>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-warning text-dark me-1" data-bs-toggle="tooltip" title="Reject Testimonial">
                                                                        <i class="fas fa-times"></i> Reject
                                                                    </button>
                                                                </form>
                                                            <?php elseif ($status == 'Rejected'): ?>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Approve Testimonial">
                                                                        <i class="fas fa-check"></i> Approve
                                                                    </button>
                                                                </form>
                                                                <form class="d-inline" method="POST" action="manage-testimonials-handler.php">
                                                                    <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                    <input type="hidden" name="action" value="pending">
                                                                    <?php 
                                                                    // Preserve current filters
                                                                    if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                    if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                    if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                    ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="tooltip" title="Mark as Pending">
                                                                        <i class="fas fa-clock"></i> Pending
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                            <form class="d-inline" method="POST" action="manage-testimonials-handler.php" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                                                <input type="hidden" name="testimonial_id" value="<?= (int)$testimonial['testimonial_id'] ?>">
                                                                <input type="hidden" name="action" value="delete">
                                                                <?php 
                                                                // Preserve current filters
                                                                if ($status_filter) echo '<input type="hidden" name="status" value="' . htmlspecialchars($status_filter) . '">';
                                                                if ($search) echo '<input type="hidden" name="search" value="' . htmlspecialchars($search) . '">';
                                                                if ($page > 1) echo '<input type="hidden" name="page" value="' . $page . '">';
                                                                ?>
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Testimonial">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
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
                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <?php 
                                            // Build query string for pagination
                                            $queryParams = [];
                                            if ($status_filter) $queryParams[] = 'status=' . urlencode($status_filter);
                                            if ($search) $queryParams[] = 'search=' . urlencode($search);
                                            $queryString = $queryParams ? '&' . implode('&', $queryParams) : '';
                                            ?>
                                            
                                            <!-- Previous Button -->
                                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                                <a class="page-link" href="<?= $page <= 1 ? '#' : "manage-testimonials.php?page=" . ($page - 1) . $queryString ?>">Previous</a>
                                            </li>
                                            
                                            <?php
                                            // Show page numbers with ellipsis for large page counts
                                            $startPage = max(1, $page - 2);
                                            $endPage = min($totalPages, $page + 2);
                                            
                                            // Show first page if not in range
                                            if ($startPage > 1) {
                                                echo '<li class="page-item"><a class="page-link" href="manage-testimonials.php?page=1' . $queryString . '">1</a></li>';
                                                if ($startPage > 2) {
                                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                }
                                            }
                                            
                                            // Show page numbers in range
                                            for ($i = $startPage; $i <= $endPage; $i++) {
                                                $active = $i == $page ? 'active' : '';
                                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="manage-testimonials.php?page=' . $i . $queryString . '">' . $i . '</a></li>';
                                            }
                                            
                                            // Show last page if not in range
                                            if ($endPage < $totalPages) {
                                                if ($endPage < $totalPages - 1) {
                                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                }
                                                echo '<li class="page-item"><a class="page-link" href="manage-testimonials.php?page=' . $totalPages . $queryString . '">' . $totalPages . '</a></li>';
                                            }
                                            ?>
                                            
                                            <!-- Next Button -->
                                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                                <a class="page-link" href="<?= $page >= $totalPages ? '#' : "manage-testimonials.php?page=" . ($page + 1) . $queryString ?>">Next</a>
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

</body>
</html>