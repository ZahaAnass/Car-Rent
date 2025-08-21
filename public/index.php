<?php require_once '../includes/header.php'; ?>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Carousel Start -->
        <div class="header-carousel">
            <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="../assets/img/carousel-2.jpg" class="img-fluid w-100" alt="Premium Car Rental Experience"/>
                        <div class="carousel-caption">
                            <div class="container py-4">
                                <div class="row g-5">
                                    <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="bg-secondary rounded p-5">
                                            <h4 class="text-white mb-4">START YOUR JOURNEY</h4>
                                            <form action="../user/book-car.php" method="post">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <select class="form-select" aria-label="Select vehicle type">
                                                            <option selected>Choose Your Perfect Vehicle</option>
                                                            <option value="1">Compact - VW Golf VII</option>
                                                            <option value="2">Luxury - Audi A1 S-Line</option>
                                                            <option value="3">Sedan - Toyota Camry</option>
                                                            <option value="4">Premium - BMW 320 ModernLine</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span> <span class="ms-1">Pickup</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Enter pickup city or airport" aria-label="Pickup location">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="#" class="text-white d-block mb-2 small">Different drop-off location?</a>
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span><span class="ms-1">Dropoff</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Enter dropoff city or airport" aria-label="Dropoff location">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Pickup</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Pickup time">
                                                                <option selected>Select Time</option>
                                                                <option value="06:00">6:00 AM</option>
                                                                <option value="12:00">12:00 PM</option>
                                                                <option value="18:00">6:00 PM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Dropoff</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Dropoff time">
                                                                <option selected>Select Time</option>
                                                                <option value="06:00">6:00 AM</option>
                                                                <option value="12:00">12:00 PM</option>
                                                                <option value="18:00">6:00 PM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-primary btn-contact w-100 py-2" type="submit">Find Your Perfect Ride</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="text-start">
                                            <h1 class="display-5 text-white">Unlock Your Freedom: Premium Car Rentals</h1>
                                            <p class="lead text-light">Discover the perfect ride for your next adventure. Exclusive 15% off for new bookings!</p>
                                            <div class="d-flex align-items-center mt-4">
                                                <i class="fas fa-check-circle text-primary me-2"></i>
                                                <span class="text-light">Flexible Bookings</span>
                                                <i class="fas fa-check-circle text-primary mx-2"></i>
                                                <span class="text-light">24/7 Support</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/carousel-1.jpg" class="img-fluid w-100" alt="Explore with Comfort and Style"/>
                        <div class="carousel-caption">
                            <div class="container py-4">
                                <div class="row g-5">
                                    <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="bg-secondary rounded p-5">
                                            <h4 class="text-white mb-4">CUSTOMIZE YOUR RENTAL</h4>
                                            <form action="../user/book-car.php" method="post">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <select class="form-select" aria-label="Select vehicle type">
                                                            <option selected>Select Your Ideal Vehicle</option>
                                                            <option value="1">Economy - Volkswagen Polo</option>
                                                            <option value="2">Mid-Size - Honda Accord</option>
                                                            <option value="3">SUV - Jeep Grand Cherokee</option>
                                                            <option value="4">Luxury - Mercedes-Benz E-Class</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span><span class="ms-1">Pickup</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Enter pickup city or airport" aria-label="Pickup location">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="#" class="text-white d-block mb-2 small">Different drop-off location?</a>
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-map-marker-alt"></span><span class="ms-1">Dropoff</span>
                                                            </div>
                                                            <input class="form-control" type="text" placeholder="Enter dropoff city or airport" aria-label="Dropoff location">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Pickup</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Pickup time">
                                                                <option selected>Select Time</option>
                                                                <option value="06:00">6:00 AM</option>
                                                                <option value="12:00">12:00 PM</option>
                                                                <option value="18:00">6:00 PM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                <span class="fas fa-calendar-alt"></span><span class="ms-1">Dropoff</span>
                                                            </div>
                                                            <input class="form-control" type="date">
                                                            <select class="form-select ms-3" aria-label="Dropoff time">
                                                                <option selected>Select Time</option>
                                                                <option value="06:00">6:00 AM</option>
                                                                <option value="12:00">12:00 PM</option>
                                                                <option value="18:00">6:00 PM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-primary btn-contact w-100 py-2">Explore Your Options</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                        <div class="text-start">
                                            <h1 class="display-5 text-white">Your Journey, Your Choice: Rent Smart</h1>
                                            <p class="lead text-light">Choose from our premium fleet and experience comfort like never before. Book now and save!</p>
                                            <div class="d-flex align-items-center mt-4">
                                                <i class="fas fa-check-circle text-primary me-2"></i>
                                                <span class="text-light">Wide Vehicle Selection</span>
                                                <i class="fas fa-check-circle text-primary mx-2"></i>
                                                <span class="text-light">Best Price Guarantee</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- Features Start -->
        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Zoomix <span class="text-primary">Features</span></h1>
                    <p class="mb-0">Experience the ultimate in car rental convenience with Zoomix. We're committed to providing a seamless, high-quality rental experience that puts you in the driver's seat of your perfect journey.</p>
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-xl-4">
                        <div class="row gy-4 gx-0">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <span class="fa fa-trophy fa-2x"></span>
                                    </div>
                                    <div class="ms-4">
                                        <h5 class="mb-3">First-Class Service</h5>
                                        <p class="mb-0">Our dedicated team goes above and beyond to ensure your rental experience is smooth, professional, and tailored to your exact needs. From premium vehicle selection to personalized assistance.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <span class="fa fa-road fa-2x"></span>
                                    </div>
                                    <div class="ms-4">
                                        <h5 class="mb-3">24/7 Road Assistance</h5>
                                        <p class="mb-0">Travel with confidence knowing our expert support team is available around the clock. Whether you need roadside help or have a question, we're just a call away, ensuring your safety and peace of mind.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="../assets/img/features-img.png" class="img-fluid w-100" style="object-fit: cover;" alt="Zoomix Premium Car Rental Features">
                    </div>
                    <div class="col-xl-4">
                        <div class="row gy-4 gx-0">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="feature-item justify-content-end">
                                    <div class="text-end me-4">
                                        <h5 class="mb-3">Unbeatable Value</h5>
                                        <p class="mb-0">We deliver top-quality vehicles at competitive prices. Our commitment to excellence means you get premium service without breaking the bank, making luxury travel accessible to everyone.</p>
                                    </div>
                                    <div class="feature-icon">
                                        <span class="fa fa-tag fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="feature-item justify-content-end">
                                    <div class="text-end me-4">
                                        <h5 class="mb-3">Convenient Pickup & Drop-Off</h5>
                                        <p class="mb-0">Enjoy hassle-free rentals with our complimentary pickup and drop-off service. We bring convenience to your doorstep, saving you time and making your rental experience as smooth as possible.</p>
                                    </div>
                                    <div class="feature-icon">
                                        <span class="fa fa-map-pin fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features End -->

        <!-- About Start -->
        <div class="container-fluid overflow-hidden about py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-item">
                            <div class="pb-5">
                                <h1 class="display-5 text-capitalize">Zoomix <span class="text-primary">About</span></h1>
                                <p class="mb-0">Experience the ultimate in car rental convenience with Zoomix. We're committed to providing a seamless, high-quality rental experience that puts you in the driver's seat of your perfect journey.</p>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="about-item-inner border p-4">
                                        <div class="about-icon mb-4">
                                            <img src="../assets/img/about-icon-1.png" class="img-fluid w-50 h-50" alt="Vision Icon">
                                        </div>
                                        <h5 class="mb-3">Our Vision</h5>
                                        <p class="mb-0">To be the go-to car rental company for premium vehicles, offering exceptional service and value to our customers.</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="about-item-inner border p-4">
                                        <div class="about-icon mb-4">
                                            <img src="../assets/img/about-icon-2.png" class="img-fluid h-50 w-50" alt="Mission Icon">
                                        </div>
                                        <h5 class="mb-3">Our Mission</h5>
                                        <p class="mb-0">To revolutionize car rentals by providing top-quality vehicles, unparalleled customer service, and innovative solutions that make every journey memorable.</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-item my-4">At Zoomix, we believe that a great journey starts with the right vehicle. With over 17 years of experience, we've perfected the art of car rentals, combining cutting-edge technology, a diverse fleet, and a passion for customer satisfaction. Whether you're traveling for business or pleasure, we're here to ensure your transportation needs are met with excellence.</p>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="text-center rounded bg-secondary p-4">
                                        <h1 class="display-6 text-white">17</h1>
                                        <h5 class="text-light mb-0">Years Of Excellence</h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rounded">
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Premium Vehicle Selection</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Competitive Pricing</p>
                                        <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> 24/7 Customer Support</p>
                                        <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Flexible Booking Options</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center">
                                    <a href="about.php" class="btn btn-primary rounded py-3 px-5">More About Us</a>
                                </div>
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <img src="../assets/img/attachment-img.jpg" class="img-fluid rounded-circle border border-4 border-secondary" style="width: 100px; height: 100px;" alt="William Burgess">
                                        <div class="ms-4">
                                            <h4>William Burgess</h4>
                                            <p class="mb-0">Zoomix Founder</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="about-img">
                            <div class="img-1">
                                <img src="../assets/img/about-img.jpg" class="img-fluid rounded h-100 w-100" alt="Zoomix Car Rental Fleet">
                            </div>
                            <div class="img-2">
                                <img src="../assets/img/about-img-1.jpg" class="img-fluid rounded w-100" alt="Zoomix Customer Service">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Fact Counter -->
        <div class="container-fluid counter bg-secondary py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-thumbs-up fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">829</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Satisfied Customers</h4>
                            <p class="text-light mt-2">Our commitment to excellence has earned us loyal clients worldwide.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-car-alt fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">56</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Premium Vehicles</h4>
                            <p class="text-light mt-2">A diverse fleet of modern, well-maintained cars for every need.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">127</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Rental Locations</h4>
                            <p class="text-light mt-2">Conveniently located centers across multiple cities and airports.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">589</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Total Kilometers</h4>
                            <p class="text-light mt-2">Miles of adventure and memories created with our reliable vehicles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Counter -->

        <!-- Services Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Zoomix <span class="text-primary">Services</span></h1>
                    <p class="mb-0">Discover a world of convenience and flexibility with our comprehensive car rental services. We're committed to making your journey smooth, affordable, and tailored to your unique needs.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-phone-alt fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Easy Phone Reservation</h5>
                            <p class="mb-0">Simplify your booking with our hassle-free phone reservation service. Our friendly representatives are ready to help you find the perfect vehicle, answer questions, and ensure a smooth rental experience.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-money-bill-alt fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Competitive Rates</h5>
                            <p class="mb-0">Enjoy unbeatable pricing with our special rates. We offer transparent, budget-friendly options without compromising on quality. Our competitive pricing ensures you get the best value for your rental.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-road fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Flexible One-Way Rental</h5>
                            <p class="mb-0">Travel with ultimate freedom through our one-way rental service. Pick up and drop off your vehicle at different locations, giving you maximum flexibility and convenience for your journey.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-umbrella fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Comprehensive Protection</h5>
                            <p class="mb-0">Drive with complete peace of mind through our comprehensive insurance coverage. We protect you throughout your journey, ensuring confidence and security with every mile you travel.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-building fa-2x"></i>
                            </div>
                            <h5 class="mb-3">City-to-City Travel</h5>
                            <p class="mb-0">Explore beyond city limits with our seamless city-to-city rental service. Experience the freedom to travel between destinations with ease, comfort, and unparalleled convenience.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item p-4">
                            <div class="service-icon mb-4">
                                <i class="fa fa-car-alt fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Welcome Perks</h5>
                            <p class="mb-0">Enjoy our special welcome offers designed to enhance your rental experience. From complimentary upgrades to bonus miles, we go the extra mile to make your journey truly exceptional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Services End -->

        <!-- Car categories Start -->
        <div class="container-fluid categories py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Vehicle <span class="text-primary">Categories</span></h1>
                    <p class="mb-0">Explore our diverse fleet of premium vehicles designed to meet your every need. From compact city cars to luxurious electric models, we have the perfect ride for your journey.</p>
                </div>

                <div class="filter-button text-center mb-4">
                    <button class="btn btn-primary me-2 mb-2" onclick="filterCars('All')" data-wow-delay="0.1s"><i class="fas fa-car me-2"></i>All Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Luxury')" data-wow-delay="0.1s"><i class="fas fa-crown me-2"></i>Luxury Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Economy')" data-wow-delay="0.2s"><i class="fas fa-coins me-2"></i>Economy Cars</button>
                    <button class="btn btn-outline-primary me-2 mb-2" onclick="filterCars('Electric')" data-wow-delay="0.3s"><i class="fas fa-bolt me-2"></i>Electric Cars</button>
                    <button class="btn btn-outline-primary mb-2" onclick="filterCars('SUV')" data-wow-delay="0.4s"><i class="fas fa-truck me-2"></i>SUV Cars</button>
                </div>

                <?php
                    require_once '../includes/queries/car_queries.php';
                    $carQueries = new CarQueries($pdo); 
                    $all_cars = $carQueries->getAllCars(); 

                    if (!isset($all_cars) || empty($all_cars)) {
                        echo '<p class="text-center">No cars available at the moment.</p>';
                    } else {
                        // Define car types based on ENUM values
                        $carTypes = ['Electric', 'SUV', 'Luxury', 'Economy'];
                        
                        // Group cars by their type
                        $carsByCategory = [];
                        foreach ($all_cars as $car) {
                            $type = $car['type'];
                            if (!isset($carsByCategory[$type])) {
                                $carsByCategory[$type] = [];
                            }
                            $carsByCategory[$type][] = $car;
                        }
                        
                        // Display each category
                        foreach ($carTypes as $category):
                            if (isset($carsByCategory[$category]) && !empty($carsByCategory[$category])):
                ?>

                <div class="category-section mb-5 wow fadeInUp" data-wow-delay="0.1s" id="<?= htmlspecialchars($category); ?>" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2 class="text-primary text-capitalize mb-4 text-center" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);">
                        <i class="fas fa-car" style="margin-right: 10px;"></i>
                        <?= htmlspecialchars($category); ?> Cars
                    </h2>
                    <p class="text-center mb-4" style="font-size: 1.1rem; color: #6c757d;">Explore our selection of <?= strtolower(htmlspecialchars($category)); ?> cars, perfect for your next adventure!</p>
                    <div class="categories-carousel owl-carousel">
                        <?php foreach ($carsByCategory[$category] as $car): ?>
                            <div class="categories-item p-4"> 
                                <div class="categories-item-inner d-flex flex-column h-100 position-relative"> 
                                    <!-- Status Badge -->
                                    <?php 
                                        $status = $car['status'] ?? 'Available';
                                        $statusColor = 'success';
                                        $statusIcon = 'fa-check-circle';
                                                        
                                        if ($status == 'Rented') {
                                            $statusColor = 'warning';
                                            $statusIcon = 'fa-clock';
                                        } elseif ($status == 'Maintenance') {
                                            $statusColor = 'info';
                                            $statusIcon = 'fa-tools';
                                        } elseif ($status == 'Unavailable') {
                                            $statusColor = 'danger';
                                            $statusIcon = 'fa-ban';
                                        }
                                    ?>
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <span class="badge bg-<?= $statusColor ?> px-3 py-2 rounded-pill shadow">
                                            <i class="fas <?= $statusIcon ?> me-1"></i>
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="categories-img rounded-top">
                                        <img src="<?php echo !empty($car['image_url']) ? "../" . htmlspecialchars($car['image_url']) : '../assets/img/default-car.webp'; ?>" 
                                                class="img-fluid w-100 rounded-top" 
                                                alt="<?php echo htmlspecialchars($car['name']); ?>" 
                                                style="height: 200px; object-fit: cover;"> 
                                    </div>
                                    <div class="categories-content rounded-bottom p-4 d-flex flex-column flex-grow-1"> 
                                        <h4><?php echo htmlspecialchars($car['name']); ?></h4>
                                        <p class="text-muted mb-3"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></p>
                                        
                                        <div class="mb-4">
                                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$<?php echo htmlspecialchars(number_format($car['daily_rate'], 2)); ?>/Day</h4>
                                        </div>
                                        <div class="row gy-2 gx-0 text-center mb-4">
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-users text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['seats']); ?> Seats</span>
                                            </div>
                                            <div class="col-sm-4 border-end border-white mb-2 mb-sm-0">
                                                <i class="fa fa-calendar-alt text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['year']); ?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2 mb-sm-0">
                                                <i class="fa fa-gas-pump text-dark"></i> 
                                                <span class="text-body ms-1"><?php echo htmlspecialchars($car['fuel_type']); ?></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Description Snippet -->
                                        <?php if(!empty($car['description'])): ?>
                                        <div class="mb-3">
                                            <p class="text-muted small">
                                                <?php 
                                                    $desc = htmlspecialchars($car['description']);
                                                    echo (strlen($desc) > 80) ? substr($desc, 0, 80) . '...' : $desc;
                                                ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-auto"> 
                                            <?php $isBookable = ($status == 'Available' || $status == 'Rented'); ?>
                                            <form method="get" action="../user/book-car.php">
                                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['car_id']); ?>">
                                                <button type="submit" class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100 <?= !$isBookable ? 'disabled' : '' ?>" <?= !$isBookable ? 'disabled' : '' ?>>
                                                    <?php if($isBookable): ?>
                                                        <i class="fas fa-calendar-check me-2"></i>Book Now
                                                    <?php else: ?>
                                                        <i class="fas fa-ban me-2"></i>Not Available
                                                    <?php endif; ?>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php 
                            endif; 
                        endforeach; 
                    }
                ?>
            </div>
        </div>
        <!-- Car categories End -->

        <!-- Car Steps Start -->
        <div class="container-fluid steps py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize text-white mb-3">Zoomix<span class="text-primary"> Rental Process</span></h1>
                    <p class="mb-0 text-white">Discover our simple, three-step rental process designed to make your car rental experience quick, easy, and hassle-free.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Initial Consultation</h4>
                            <p class="mb-0">Discuss your travel needs with our team and find the perfect vehicle for your journey.</p>
                            <div class="setps-number">01.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Select Your Ideal Vehicle</h4>
                            <p class="mb-0">Choose from our diverse fleet the car that best matches your style and requirements.</p>
                            <div class="setps-number">02.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Hit the Road</h4>
                            <p class="mb-0">Complete your booking, pick up your vehicle, and start your adventure with ease.</p>
                            <div class="setps-number">03.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Car Steps End -->

        <!-- Blog Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Zoomix<span class="text-primary"> Insights</span></h1>
                    <p class="mb-0">Stay informed with the latest trends, tips, and expert advice in car rental, travel, and automotive technology.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="../assets/img/blog-1.jpg" class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="blog-content rounded-bottom p-4">
                                <div class="blog-date">30 Dec 2025</div>
                                <div class="blog-comment my-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span><span class="ms-2">Sarah Thompson</span></div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span><span class="ms-2">6 Comments</span></div>
                                </div>
                                <a href="cars.php" class="h4 d-block mb-3">Navigating Driving Fines: A Comprehensive Guide</a>
                                <p class="mb-3">Learn how to check, understand, and manage driving fines effectively. Our expert guide provides crucial insights for responsible drivers.</p>
                                <a href="cars.php" class="">Read More  <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="../assets/img/blog-2.jpg" class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="blog-content rounded-bottom p-4">
                                <div class="blog-date">25 Dec 2025</div>
                                <div class="blog-comment my-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span><span class="ms-2">Michael Rodriguez</span></div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span><span class="ms-2">4 Comments</span></div>
                                </div>
                                <a href="cars.php" class="h4 d-block mb-3">Top 5 Road Trip Destinations for 2026</a>
                                <p class="mb-3">Discover the most exciting and scenic road trip routes that promise unforgettable adventures and breathtaking landscapes.</p>
                                <a href="cars.php" class="">Read More  <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="../assets/img/blog-3.jpg" class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="blog-content rounded-bottom p-4">
                                <div class="blog-date">20 Dec 2025</div>
                                <div class="blog-comment my-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span><span class="ms-2">Emily Chen</span></div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span><span class="ms-2">5 Comments</span></div>
                                </div>
                                <a href="cars.php" class="h4 d-block mb-3">Eco-Friendly Driving: Reducing Your Carbon Footprint</a>
                                <p class="mb-3">Explore practical tips and strategies for minimizing environmental impact while enjoying the freedom of car rental.</p>
                                <a href="cars.php" class="">Read More  <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->

        <!-- Banner Start -->
        <div class="container-fluid banner py-5 wow zoomInDown" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="banner-item rounded">
                    <img src="../assets/img/banner-1.jpg" class="img-fluid rounded w-100" alt="Car Rental Banner">
                    <div class="banner-content">
                        <h2 class="text-primary">Your Journey Starts Here</h2>
                        <h1 class="text-white">Ready to Hit the Road?</h1>
                        <p class="text-white">Discover the perfect vehicle for your next adventure. Quick, easy, and hassle-free rentals.</p>
                        <div class="banner-btn">
                            <a href="#" class="btn btn-secondary rounded-pill py-3 px-4 px-md-5 me-2">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                            <a href="contact.php" class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2">
                                <i class="fas fa-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->

        <!-- Team Start -->
        <div class="container-fluid team py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Customer<span class="text-primary"> Support</span> Team</h1>
                    <p class="mb-0">Meet the dedicated professionals behind Zoomix's exceptional customer service. Our team is committed to ensuring your car rental experience is smooth, enjoyable, and tailored to your unique needs.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="../assets/img/team-1.jpg" class="img-fluid rounded w-100" alt="Alex Johnson, Customer Support Manager">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Alex Johnson</h4>
                                <p>Customer Support Manager</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="../assets/img/team-2.jpg" class="img-fluid rounded w-100" alt="Ryan Rodriguez, Senior Rental Advisor">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Ryan Rodriguez</h4>
                                <p>Senior Rental Advisor</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="../assets/img/team-3.jpg" class="img-fluid rounded w-100" alt="Jason Chen, Fleet Coordinator">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Jason Chen</h4>
                                <p>Fleet Coordinator</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item p-4 pt-0">
                            <div class="team-img">
                                <img src="../assets/img/team-4.jpg" class="img-fluid rounded w-100" alt="Daniel Martinez, Technical Support Specialist">
                            </div>
                            <div class="team-content pt-4">
                                <h4>Daniel Martinez</h4>
                                <p>Technical Support Specialist</p>
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->

        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">Our Clients<span class="text-primary"> Reviews</span></h1>
                    <p class="mb-0">Hear directly from our satisfied customers who have experienced the Zoomix difference. Their stories showcase our commitment to exceptional service, reliability, and unforgettable travel experiences.</p>
                </div>
                
                <?php
                    require_once '../includes/queries/testimonial_queries.php';
                    $testimonialQueries = new TestimonialQueries($pdo);
                    
                    // Get only approved testimonials
                    $approvedTestimonials = $testimonialQueries->getAllTestimonialsWithFilter('Approved');
                    
                    if (!empty($approvedTestimonials)):
                ?>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <?php 
                        $imageCount = 3; // We have 3 testimonial images available
                        $imageIndex = 1;
                        
                        foreach ($approvedTestimonials as $testimonial): 
                            // Cycle through the available images
                            $imagePath = "../assets/img/testimonial-" . $imageIndex . ".jpg";
                            $imageIndex = ($imageIndex % $imageCount) + 1;
                    ?>
                    <div class="testimonial-item">
                        <div class="testimonial-quote"><i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="testimonial-inner p-4">
                            <img src="<?php echo $imagePath; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($testimonial['user_name_display']); ?>">
                            <div class="ms-4">
                                <h4><?php echo htmlspecialchars($testimonial['user_name_display']); ?></h4>
                                <p><?php echo !empty($testimonial['first_name']) ? htmlspecialchars($testimonial['first_name'] . ' ' . $testimonial['last_name']) : 'Customer'; ?></p>
                                <div class="d-flex text-primary">
                                    <?php 
                                        $rating = (int)$testimonial['rating'];
                                        // Show filled stars for the rating
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="fas fa-star text-body"></i>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="border-top rounded-bottom p-4">
                            <p class="mb-0">"<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>"</p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-comment-slash fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted">No testimonials available yet</h3>
                    <p class="text-muted">Be the first to share your experience with us!</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../user/submit-testimonial.php" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Submit a Testimonial
                    </a>
                    <?php else: ?>
                    <a href="../auth/login.php" class="btn btn-primary mt-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Submit a Testimonial
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Testimonial End -->

<script defer src="../assets/js/filterCars.js"></script>
<?php require_once '../includes/footer.php'; ?>
