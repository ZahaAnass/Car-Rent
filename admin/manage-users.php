<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/user_queries.php";
    require_once "../includes/auth_admin_check.php";
    
    $userQueries = new UserQueries($pdo);
    
    // Get filter/search from GET
    $status_filter = isset($_GET['status']) ? $_GET['status'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;

    // Pagination config
    $limit = 10; // Number of users per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    // Get total users with filter/search
    $totalUsers = $userQueries->getUserCount($status_filter, $search);
    $totalPages = ceil($totalUsers / $limit);
    if ($page > $totalPages && $totalPages > 0) {
        // Redirect to first page with current filters
        $q = [];
        if ($status_filter) $q[] = 'status=' . urlencode($status_filter);
        if ($search) $q[] = 'search=' . urlencode($search);
        $qs = $q ? ('&' . implode('&', $q)) : '';
        redirect("manage-users.php?page=1$qs");
    }

    // Fetch filtered users for current page
    $users = $userQueries->getUsersWithLimit($limit, $offset, $status_filter, $search);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoomix Admin - Manage Users</title>
    
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
                    <!-- Page Title & Optional Add User Button -->
                    <div class="row mb-4 align-items-center wow fadeInDown">
                        <div class="col-md-6">
                            <h1 class="display-6 mb-2">Manage Users</h1>
                            <p class="text-muted mb-0">View and manage user accounts.</p>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fas fa-user-plus me-2"></i>Add New User
                            </button>
                        </div>
                    </div>

                    <?php if(isset($_SESSION['action_success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $_SESSION['action_success']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif;
                    unset($_SESSION['action_success']); ?>

                    <?php if(isset($_SESSION['action_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $_SESSION['action_error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif;
                    unset($_SESSION['action_error']); ?>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center" method="get" action="">
                                        <div class="col-md-4">
                                            <label for="status" class="form-label visually-hidden">Role</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="" <?= $status_filter === null || $status_filter === '' ? 'selected' : '' ?>>All Roles</option>
                                                <option value="Admin" <?= $status_filter === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="User" <?= $status_filter === 'User' ? 'selected' : '' ?>>User</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="search" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search by Name/Email..." value="<?= htmlspecialchars($search ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="manage-users.php" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">User ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Date Registered</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (empty($users)) {
                                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>';
                                                } else {
                                                    foreach ($users as $singleUser): 
                                                    $isCurrentUser = ($singleUser['user_id'] == $_SESSION['user_id']);
                                                ?>
                                                    <tr>
                                                        <td>#<?= htmlspecialchars($singleUser['user_id']) ?></td>
                                                        <td><?= htmlspecialchars($singleUser['first_name'] . ' ' . $singleUser['last_name']) ?></td>
                                                        <td><?= htmlspecialchars($singleUser['email']) ?></td>
                                                        <td><?= date('M d, Y', strtotime($singleUser['registered_at'])) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= $singleUser['role'] == 'Admin' ? 'primary' : 'secondary' ?>">
                                                                <?= htmlspecialchars($singleUser['role']) ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            <?php if (!$isCurrentUser): ?> 
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <!-- Role Selector -->
                                                                    <form action="manage-user-handeler.php?action=update_role" method="post" style="min-width: 120px;">
                                                                        <input type="hidden" name="userId" value="<?= $singleUser['user_id'] ?>">
                                                                        <select name="role" onchange="this.form.submit()" class="form-select form-select-sm">
                                                                            <option value="User" <?= $singleUser['role'] === 'User' ? 'selected' : '' ?>>User</option>
                                                                            <option value="Admin" <?= $singleUser['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                                        </select>
                                                                    </form>
                                                                    
                                                                    <!-- Delete Button -->
                                                                    <form action="manage-user-handeler.php?action=delete" method="post" class="d-inline">
                                                                        <input type="hidden" name="userId" value="<?= $singleUser['user_id'] ?>">
                                                                        <button type="submit" 
                                                                                class="btn btn-sm btn-outline-danger" 
                                                                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                                                                title="Delete User">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="text-muted fst-italic">(Current User)</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    endforeach; 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <?php if (!empty($users)): ?>
                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <?php 
                                            $q = [];
                                            if ($status_filter) $q[] = 'status=' . urlencode($status_filter);
                                            if ($search) $q[] = 'search=' . urlencode($search);
                                            $qs = $q ? ('&' . implode('&', $q)) : '';
                                            ?>
                                            <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                                                <a class="page-link" href="manage-users.php?page=<?= $page-1 . $qs ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                                <li class="page-item<?= $p == $page ? ' active' : '' ?>">
                                                    <a class="page-link" href="manage-users.php?page=<?= $p . $qs ?>"> <?= $p ?> </a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                                                <a class="page-link" href="manage-users.php?page=<?= $page+1 . $qs ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" class="register-form" action="manage-user-handeler.php?action=add" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Password must be at least 8 characters long</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">+212</span>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                        pattern="[0-9]{9}" title="Please enter a valid 9-digit phone number">
                                </div>
                                <div class="form-text"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="User" selected>User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="license_number" class="form-label">License Number</label>
                                <input type="text" class="form-control" id="license_number" name="license_number" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select name="country" id="country" class="form-select" required>
                                        <option value="" selected disabled>Select Country</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <select name="city" id="city" class="form-select" required>
                                        <option value="" selected disabled>Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addUserForm" class="btn btn-primary">Add User</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add User Modal -->

    <script src="../assets/js/add-user-validation.js"></script>
    <script src="../assets/js/countries.js"></script>

</body>
</html>