<?php
$current_page = basename($_SERVER['PHP_SELF']);
$site_name = "Zoomix";
$site_description = "Explore the world with our premium car rental services";
$keywords = "car rental, travel, transportation";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $site_name; ?> - Car Rental</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo $keywords; ?>" name="keywords">
    <meta content="<?php echo $site_description; ?>" name="description">

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
    <link href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-secondary d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-6 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        <a href="tel:+212 (522) 987-654" class="text-muted me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+212 (522) 987-654</a>
                        <a href="mailto:info@zoomixrentals.com" class="text-muted me-0"><i class="fas fa-envelope text-primary me-2"></i>info@zoomixrentals.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="https://facebook.com/zoomix" class="btn btn-light btn-sm-square rounded-circle me-3" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/zoomix" class="btn btn-light btn-sm-square rounded-circle me-3" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/zoomix" class="btn btn-light btn-sm-square rounded-circle me-3" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com/company/zoomix" class="btn btn-light btn-sm-square rounded-circle me-0" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="../public/index.php" class="navbar-brand p-0">
                    <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i><?php echo $site_name; ?></h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="../public/index.php" class="nav-item nav-link <?php echo (basename($current_page) == 'index.php') ? 'active' : ''; ?>">Home</a>
                        <a href="../public/about.php" class="nav-item nav-link <?php echo (basename($current_page) == 'about.php') ? 'active' : ''; ?>">About</a>
                        <a href="../public/service.php" class="nav-item nav-link <?php echo (basename($current_page) == 'service.php') ? 'active' : ''; ?>">Service</a>
                        <a href="../public/blog.php" class="nav-item nav-link <?php echo (basename($current_page) == 'blog.php') ? 'active' : ''; ?>">Blog</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="../public/feature.php" class="dropdown-item">Our Feature</a>
                                <a href="../public/cars.php" class="dropdown-item">Our Cars</a>
                                <a href="../public/team.php" class="dropdown-item">Our Team</a>
                                <a href="../public/testimonial.php" class="dropdown-item">Testimonial</a>
                                <a href="../public/404.php" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
                        <a href="../public/contact.php" class="nav-item nav-link <?php echo (basename($current_page) == 'contact.php') ? 'active' : ''; ?>">Contact</a>
                    </div>
                    <a href="login.php" class="btn btn-primary rounded-pill me-2 py-2 px-4">Login</a>
                    <a href="register.php" class="btn btn-primary rounded-pill py-2 px-4">Register</a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->