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

                    <!-- Filters -->
                    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <form class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label for="filterMessageStatus" class="form-label visually-hidden">Status</label>
                                            <select class="form-select" id="filterMessageStatus">
                                                <option selected value="">All Statuses</option>
                                                <option value="unread">Unread</option>
                                                <option value="read">Read</option>
                                                <option value="replied">Replied</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterSearchMessage" class="form-label visually-hidden">Search</label>
                                            <input type="text" class="form-control" id="filterSearchMessage" placeholder="Search by Name, Email, Subject...">
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
                                                // --- PHP Logic to fetch messages from database would go here ---
                                                // Example placeholder data:
                                                $messages = [
                                                    ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'subject' => 'Question about SUV rental', 'message' => 'Hi, I was wondering about the availability of the Honda CR-V next weekend...', 'timestamp' => '2025-05-05 10:30:00', 'status' => 'unread'],
                                                    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.s@sample.net', 'subject' => 'Feedback on service', 'message' => 'Just wanted to say I had a great experience renting the Camry. Smooth process!', 'timestamp' => '2025-05-04 15:00:00', 'status' => 'read'],
                                                    ['id' => 3, 'name' => 'Robert Johnson', 'email' => 'r.johnson@mail.com', 'subject' => 'Problem with booking', 'message' => 'I seem to be having trouble completing my booking online. Can you help?', 'timestamp' => '2025-05-05 14:15:00', 'status' => 'replied'],
                                                    ['id' => 4, 'name' => 'Emily White', 'email' => 'emily.w@example.com', 'subject' => 'Urgent: Change Pickup Time', 'message' => 'Need to change my pickup time for booking #12345 to 3 PM instead of 1 PM.', 'timestamp' => '2025-05-06 09:00:00', 'status' => 'unread'],
                                                    ['id' => 5, 'name' => 'Michael Brown', 'email' => 'michael.b@example.com', 'subject' => 'Request for refund', 'message' => 'I need to request a refund for my recent booking #67890 due to a vehicle issue.', 'timestamp' => '2025-05-07 11:45:00', 'status' => 'unread'],
                                                    ['id' => 6, 'name' => 'Sarah Davis', 'email' => 'sarah.d@example.com', 'subject' => 'Booking confirmation', 'message' => 'Just wanted to confirm my booking for the Honda CR-V next weekend. Please let me know if there are any changes.', 'timestamp' => '2025-05-08 16:30:00', 'status' => 'read'],
                                                    ['id' => 7, 'name' => 'William Wilson', 'email' => 'william.w@example.com', 'subject' => 'Issue with vehicle', 'message' => 'I seem to be having trouble with my vehicle. Can you help me resolve this issue?', 'timestamp' => '2025-05-09 10:15:00', 'status' => 'unread'],
                                                ];

                                                if (empty($messages)) {
                                                    echo '<tr><td colspan="7" class="text-center text-muted py-4">No messages found.</td></tr>';
                                                } else {
                                                    foreach ($messages as $message):
                                                        $status_badge = 'secondary'; // Default for 'read'
                                                        $status_text = ucfirst($message['status']);
                                                        if ($message['status'] == 'unread') {
                                                            $status_badge = 'danger'; // Red for unread
                                                        } elseif ($message['status'] == 'replied') {
                                                            $status_badge = 'success'; // Green for replied
                                                        }
                                                ?>
                                                    <tr>
                                                        <td>#<?= htmlspecialchars($message['id']) ?></td>
                                                        <td><?= htmlspecialchars($message['name']) ?></td>
                                                        <td><a href="mailto:<?= htmlspecialchars($message['email']) ?>"><?= htmlspecialchars($message['email']) ?></a></td>
                                                        <td><?= htmlspecialchars(substr($message['subject'], 0, 30)) . (strlen($message['subject']) > 30 ? '...' : '') ?></td>
                                                        <td>
                                                            <?php
                                                                try {
                                                                    $date = new DateTime($message['timestamp']);
                                                                    echo $date->format('M d, Y H:i');
                                                                } catch (Exception $e) {
                                                                    echo htmlspecialchars($message['timestamp']);
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><span class="badge bg-<?= $status_badge ?>"><?= htmlspecialchars($status_text) ?></span></td>
                                                        <td class="text-end">
                                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewMessageModal<?= $message['id'] ?>" data-bs-toggle="tooltip" title="View Message <?= $message['id'] ?>">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <?php if ($message['status'] == 'unread' || $message['status'] == 'read'): ?>
                                                            <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="tooltip" title="Mark as Read/Replied <?= $message['id'] ?>">
                                                                <i class="fas fa-check"></i> <!-- Icon could change based on action -->
                                                            </button>
                                                            <?php endif; ?>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Message <?= $message['id'] ?>">
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

                                    <?php if (!empty($messages)): ?>
                                    <!-- Optional: Add Pagination if many messages -->
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
                    <!-- Add Modals for viewing full messages if needed -->
                    <?php foreach ($messages as $message): ?>
                    <div class="modal fade" id="viewMessageModal<?= $message['id'] ?>" tabindex="-1" aria-labelledby="viewMessageModalLabel<?= $message['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewMessageModalLabel<?= $message['id'] ?>"><?= htmlspecialchars($message['subject']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>From:</strong> <?= htmlspecialchars($message['name']) ?> (<?= htmlspecialchars($message['email']) ?>)</p>
                                    <p><strong>Date:</strong> <?php try { $date = new DateTime($message['timestamp']); echo $date->format('M d, Y H:i A'); } catch (Exception $e) { echo htmlspecialchars($message['timestamp']); } ?></p>
                                    <hr>
                                    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- Optional: Add Reply Button -->
                                    <button type="button" class="btn btn-primary"><i class="fas fa-reply me-1"></i> Reply</button>
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