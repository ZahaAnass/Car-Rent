<?php 
    require_once '../includes/header.php';
    require_once '../config/database.php';
    require_once '../includes/queries/user_queries.php';
    require_once '../includes/functions.php';
    require_once '../includes/session.php';
    start_session();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        redirect("../auth/login.php");
    }

    try {
        $user = new UserQueries($pdo);
        $userData = $user->getUserById($_SESSION['user_id']);
        
        $pageTitle = "Contact Us";
        $displayName = $userData['first_name'] . ' ' . $userData['last_name'] ?? 'Guest';
    } catch (Exception $e) {
        $_SESSION["error"] = "Failed to retrieve user data";
        redirect("../auth/login.php");
    }

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '';
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) ?? '';
            $inquiry_type = filter_input(INPUT_POST, 'inquiry_type', FILTER_SANITIZE_STRING) ?? '';
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) ?? '';
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) ?? '';
            $_SESSION["success"] = "Message sent successfully";
            // Removed the messageQuery object creation and the createMessage method call
            redirect("contact.php");
        }
    } catch (Exception $e) {
        $_SESSION["error"] = "Failed to retrieve user data";
        redirect("../auth/login.php");
    }
?>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Session Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1030;">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contact Us</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white">Pages</li>
                    <li class="breadcrumb-item active text-primary">Contact</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <!-- Contact Start -->
        <div class="container-fluid contact py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize text-primary mb-3">Contact Zoomix</h1>
                    <p class="mb-0">Have questions or need assistance? Our dedicated support team is ready to help you. Reach out through the form below or use our contact information.</p>
                </div>
                <div class="row g-5">
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row g-5">
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Our Headquarters</h4>
                                        <p class="mb-0">Maroc, Mohammedia, 20200</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Email Support</h4>
                                        <p class="mb-0">support@zoomixrentals.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fa fa-phone-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Customer Helpline</h4>
                                        <p class="mb-0">+1 (888) ZOOMIX-RENT</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fab fa-whatsapp fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>WhatsApp Support</h4>
                                        <p class="mb-0">+1 (415) 555-ZOOM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-secondary p-5 rounded">
                            <h4 class="text-primary mb-4">Send Your Message</h4>
                            <form action="contact-handler.php" method="post">
                                <div class="row g-4">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name" required name="name">
                                            <label for="name">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" placeholder="Your Email" required name="email">
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="phone" placeholder="Phone Number" required name="phone">
                                            <label for="phone">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="inquiry-type" required name="inquiry_type">
                                                <option value="">Select Inquiry Type</option>
                                                <option value="Car Rental Inquiry">Car Rental Inquiry</option>
                                                <option value="Customer Support">Customer Support</option>
                                                <option value="Feedback">Feedback</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label for="inquiry-type">Inquiry Type</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Subject" required name="subject">
                                            <label for="subject">Subject Line</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Describe your inquiry" id="message" style="height: 160px" required name="message"></textarea>
                                            <label for="message">Your Message</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-contact w-100 py-3">
                                            <i class="fas fa-paper-plane me-2"></i>Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                    <div class="col-12 col-xl-1 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="d-flex flex-xl-column align-items-center justify-content-center">
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-4 me-4 me-xl-0" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-4 me-4 me-xl-0" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-4 me-4 me-xl-0" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-0 me-0 me-xl-0" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="p-5 bg-light rounded">
                            <div class="bg-white rounded p-4 mb-4">
                                <h4 class="mb-3">Casablanca Branch</h4>
                                <div class="d-flex align-items-center flex-shrink-0 mb-3">
                                    <p class="mb-0 text-dark me-2">Address:</p><i class="fas fa-map-marker-alt text-primary me-2"></i><p class="mb-0">Boulevard Mohammed V, Casablanca 20250, Morocco</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-dark me-2">Telephone:</p><i class="fa fa-phone-alt text-primary me-2"></i><p class="mb-0">+212 (0) 522 54 54 54</p>
                                </div>
                            </div>
                            <div class="bg-white rounded p-4 mb-4">
                                <h4 class="mb-3">Rabat Branch</h4>
                                <div class="d-flex align-items-center mb-3">
                                    <p class="mb-0 text-dark me-2">Address:</p><i class="fas fa-map-marker-alt text-primary me-2"></i><p class="mb-0">Avenue Mohammed VI, Rabat 10000, Morocco</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-dark me-2">Telephone:</p><i class="fa fa-phone-alt text-primary me-2"></i><p class="mb-0">+212 (0) 537 70 70 70</p>
                                </div>
                            </div>
                            <div class="bg-white rounded p-4 mb-0">
                                <h4 class="mb-3">Marrakech Branch</h4>
                                <div class="d-flex align-items-center mb-3">
                                    <p class="mb-0 text-dark me-2">Address:</p><i class="fas fa-map-marker-alt text-primary me-2"></i><p class="mb-0">Avenue Mohammed V, Marrakech 40000, Morocco</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-dark me-2">Telephone:</p><i class="fa fa-phone-alt text-primary me-2"></i><p class="mb-0">+212 (0) 524 44 44 44</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rounded">
                            <iframe class="rounded w-100" 
                            style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3319.363463855426!2d-7.375437123710808!3d33.69954277329198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7b6dd53776a79%3A0xbae399f544a58122!2sISTA%20%3A%20Institut%20Sp%C3%A9cialis%C3%A9%20de%20Technologie%20Appliqu%C3%A9e_Mohammedia!5e0!3m2!1sen!2sma!4v1746195010047!5m2!1sen!2sma" 
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

<?php require_once '../includes/footer.php'; ?>