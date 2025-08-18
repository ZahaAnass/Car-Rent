<?php
require_once "../includes/session.php";
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/message_queries.php";
require_once "../includes/auth_admin_check.php";

$messageQueries = new MessageQueries($pdo);

// Get filter/search from GET
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Pagination config
$limit = 10; // Number of messages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Get total messages with filter/search
$totalMessages = $messageQueries->getMessageCount($status_filter, $search);
$totalPages = ceil($totalMessages / $limit);
if ($page > $totalPages && $totalPages > 0) {
    // Redirect to first page with current filters
    $q = [];
    if ($status_filter) $q[] = 'status=' . urlencode($status_filter);
    if ($search) $q[] = 'search=' . urlencode($search);
    $qs = $q ? ('&' . implode('&', $q)) : '';
    redirect("manage-message.php?page=1$qs");
}

// Fetch filtered messages for current page
$messages = $messageQueries->getMessagesWithLimit($limit, $offset, $status_filter, $search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoomix Admin - Manage Messages</title>
    
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
                            <h1 class="display-6 mb-2">Manage Messages</h1>
                            <p class="text-muted mb-0">View and respond to customer inquiries from the contact form.</p>
                        </div>
                    </div>

                    <!-- Session Messages -->
                    <?php if(isset($_SESSION['message_success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $_SESSION['message_success']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif;
                    unset($_SESSION['message_success']); ?>

                    <?php if(isset($_SESSION['message_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $_SESSION['message_error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif;
                    unset($_SESSION['message_error']); ?>

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center" method="get" action="">
                                        <div class="col-md-4">
                                            <label for="status" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                                                <option value="" <?= $status_filter === null || $status_filter === '' ? 'selected' : '' ?>>All Statuses</option>
                                                <option value="Unread" <?= $status_filter === 'Unread' ? 'selected' : '' ?>>Unread</option>
                                                <option value="Read" <?= $status_filter === 'Read' ? 'selected' : '' ?>>Read</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="search" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search by Name, Email, Subject..." value="<?= htmlspecialchars($search ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="manage-message.php" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Table -->
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Subject</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($messages)) {
                                                    echo '<tr><td colspan="7" class="text-center text-muted py-4">No messages found.</td></tr>';
                                                } else {
                                                    foreach ($messages as $message):
                                                        $status_badge = $message['status'] == 'Unread' ? 'danger' : 'secondary';
                                                        $status_text = ucfirst($message['status']);
                                                ?>
                                                    <tr>
                                                        <td>#<?= htmlspecialchars($message['message_id']) ?></td>
                                                        <td><?= htmlspecialchars($message['name']) ?></td>
                                                        <td><a href="mailto:<?= htmlspecialchars($message['email']) ?>"><?= htmlspecialchars($message['email']) ?></a></td>
                                                        <td><?= htmlspecialchars(substr($message['subject'], 0, 30)) . (strlen($message['subject']) > 30 ? '...' : '') ?></td>
                                                        <td>
                                                            <?php
                                                                try {
                                                                    $date = new DateTime($message['received_at']);
                                                                    echo $date->format('M d, Y H:i');
                                                                } catch (Exception $e) {
                                                                    echo htmlspecialchars($message['received_at']);
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($status_text) ?></span></td>
                                                        <td class="text-end">
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewMessageModal<?= $message['message_id'] ?>" data-bs-toggle="tooltip" title="View Message">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                
                                                                <?php if ($message['status'] == 'Unread'): ?>
                                                                <form action="manage-message-handler.php" method="POST" class="d-inline">
                                                                    <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                                                    <input type="hidden" name="action" value="mark_read">
                                                                    <button type="submit" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Mark as Read">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>
                                                                <?php endif; ?>
                                                                
                                                                <form action="manage-message-handler.php" method="POST" class="d-inline">
                                                                    <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                                                    <input type="hidden" name="action" value="delete">
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Message" onclick="return confirm('Are you sure you want to delete this message?')">
                                                                        <i class="fas fa-trash"></i>
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

                                    <?php if (!empty($messages) && $totalPages > 1): ?>
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
                                                <a class="page-link" href="manage-message.php?page=<?= $page-1 . $qs ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                                <li class="page-item<?= $p == $page ? ' active' : '' ?>">
                                                    <a class="page-link" href="manage-message.php?page=<?= $p . $qs ?>"> <?= $p ?> </a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                                                <a class="page-link" href="manage-message.php?page=<?= $page+1 . $qs ?>" aria-label="Next">
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
                    
                    <!-- Message View Modals -->
                    <?php foreach ($messages as $message): ?>
                    <div class="modal fade" id="viewMessageModal<?= $message['message_id'] ?>" tabindex="-1" aria-labelledby="viewMessageModalLabel<?= $message['message_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewMessageModalLabel<?= $message['message_id'] ?>"><?= htmlspecialchars($message['subject']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p><strong>From:</strong> <?= htmlspecialchars($message['name']) ?></p>
                                            <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
                                            <p><strong>Phone:</strong> <?= htmlspecialchars($message['phone']) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Inquiry Type:</strong> <?= htmlspecialchars($message['inquiry_type']) ?></p>
                                            <p><strong>Date:</strong> <?php try { $date = new DateTime($message['received_at']); echo $date->format('M d, Y H:i A'); } catch (Exception $e) { echo htmlspecialchars($message['received_at']); } ?></p>
                                            <p><strong>Status:</strong> <span class="badge bg-<?= $message['status'] == 'Unread' ? 'danger' : 'secondary' ?>"><?= htmlspecialchars($message['status']) ?></span></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <strong>Message:</strong>
                                        <div class="mt-2 p-3 bg-light rounded text-start" style="white-space: pre-line;">
                                            <?= html_entity_decode(htmlspecialchars_decode($message['message_body'])) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    
                                    <?php if ($message['status'] == 'Unread'): ?>
                                    <form action="manage-message-handler.php" method="POST" class="d-inline">
                                        <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                        <input type="hidden" name="action" value="mark_read">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i> Mark as Read
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    
                                    <a href="mailto:<?= htmlspecialchars($message['email']) ?>?subject=Re: <?= htmlspecialchars($message['subject']) ?>" class="btn btn-primary">
                                        <i class="fas fa-reply me-1"></i> Reply via Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <?php require_once '../includes/bottom-nav.php'; ?>

</body>
</html>