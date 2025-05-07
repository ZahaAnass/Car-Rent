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

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label for="filterUserRole" class="form-label visually-hidden">Role</label>
                                            <select class="form-select" id="filterUserRole">
                                                <option selected value="">All Roles</option>
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterSearchUser" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="filterSearchUser" placeholder="Search by Name/Email...">
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
                                                // --- PHP Logic to fetch users from database ---
                                                // Make sure not to fetch sensitive data like passwords here
                                                $users = [
                                                    ['id' => 1, 'name' => 'Admin User', 'email' => 'admin@zoomix.com', 'registered_date' => '2025-04-01', 'role' => 'Admin'],
                                                    ['id' => 2, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'registered_date' => '2025-04-15', 'role' => 'User'],
                                                    ['id' => 3, 'name' => 'Admin User', 'email' => 'admin@zoomix.com', 'registered_date' => '2025-04-01', 'role' => 'Admin'],
                                                    ['id' => 4, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'registered_date' => '2025-04-15', 'role' => 'User'],
                                                    ['id' => 5, 'name' => 'Jane Smith', 'email' => 'jane.s@sample.net', 'registered_date' => '2025-04-20', 'role' => 'User'],
                                                    ['id' => 6, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'registered_date' => '2025-04-15', 'role' => 'User'],
                                                    ['id' => 7, 'name' => 'Jane Smith', 'email' => 'jane.s@sample.net', 'registered_date' => '2025-04-20', 'role' => 'User'],
                                                ];
                                                
                                                // Get current admin ID if needed to prevent self-modification
                                                $current_admin_id = 1; // Example: Get this from session

                                                if (empty($users)) {
                                                    echo '<tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>';
                                                } else {
                                                    foreach ($users as $user): 
                                                ?>
                                                    <tr>
                                                        <td>#<?= htmlspecialchars($user['id']) ?></td>
                                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                                        <td><?= htmlspecialchars($user['registered_date']) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= $user['role'] == 'Admin' ? 'primary' : 'secondary' ?>">
                                                                <?= htmlspecialchars($user['role']) ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            <!-- Prevent modifying the current admin user -->
                                                            <?php if ($user['id'] != $current_admin_id): ?> 
                                                                
                                                                <!-- Edit Role Button (Example using dropdown) -->
                                                                <div class="btn-group me-1">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Change Role">
                                                                        <i class="fas fa-user-shield"></i> Role
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="?action=setRole&id=<?= $user['id'] ?>&role=Admin">Make Admin</a></li>
                                                                        <li><a class="dropdown-item" href="?action=setRole&id=<?= $user['id'] ?>&role=User">Make User</a></li>
                                                                    </ul>
                                                                </div>

                                                                
                                                                <!-- Delete Button -->
                                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete User <?= $user['id'] ?>">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="text-muted fst-italic">(Current Admin)</span>
                                                            <?php endif; ?>
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
                                    
                                    <?php if (!empty($users)): ?>
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="userName" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="userEmail" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="userPassword" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userRole" class="form-label">Role</label>
                                <select class="form-select" id="userRole" name="role" required>
                                    <option value="User" selected>User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">Phone Number (Optional)</label>
                            <input type="tel" class="form-control" id="userPhone" name="phone">
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


</body>
</html>