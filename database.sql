-- Create The Db
create database zoomix_rental;
use zoomix_rental;

-- Database Schema

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    license_number VARCHAR(50) NULL UNIQUE,
    role ENUM('User', 'Admin') DEFAULT 'User',
    address_country VARCHAR(100),
    address_city VARCHAR(100),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create cars table
CREATE TABLE cars (
    car_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM("Electric", "SUV", "Luxury", "Economy") NOT NULL, -- i need to change this in phpmyadmin
    description TEXT,
    daily_rate DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    status ENUM('Available', 'Rented', 'Maintenance', 'Unavailable') NOT NULL DEFAULT 'Available',
    license_plate VARCHAR(20) UNIQUE,
    year INT,
    make VARCHAR(100),
    model VARCHAR(100),
    color VARCHAR(50),
    seats INT,
    fuel_type VARCHAR(50),
    features TEXT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create bookings table
CREATE TABLE bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_date DATETIME NOT NULL,
    return_date DATETIME NOT NULL,
    pickup_location VARCHAR(255),
    return_location VARCHAR(255),
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed', 'Active') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (car_id) REFERENCES cars(car_id)
);

-- Create messages table
CREATE TABLE messages (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    inquiry_type ENUM('Car Rental Inquiry', 'Customer Support', 'Feedback', 'Other') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message_body TEXT NOT NULL,
    status ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
    received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create testimonials table
CREATE TABLE testimonials (
    testimonial_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    user_name_display VARCHAR(255) NOT NULL,
    testimonial_text TEXT NOT NULL,
    rating INT,
    status ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Create remember me table
CREATE TABLE remember_me_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE KEY (token)
);

-- Create password reset tokens table
CREATE TABLE password_reset_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    code VARCHAR(10) NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_code (code),
    INDEX idx_token (token),
    INDEX idx_user_id (user_id),
    INDEX idx_expires (expires_at)
);

-- Inserting Data

INSERT INTO cars (name, type, description, daily_rate, image_url, status, license_plate, year, make, model, color, seats, fuel_type, features)
VALUES
('Audi A8', 'Luxury', 'Luxury sedan with high-end features.', 150.00, 'assets/cars/Audi A8.png', 'Available', 'LUX-001-AUD', 2022, 'Audi', 'A8', 'Black', 5, 'Petrol', 'Leather Seats, GPS, Sunroof'),
('BMW 7 Series', 'Luxury', 'Premium executive luxury car.', 160.00, 'assets/cars/BMW 7 Series.png', 'Available', 'LUX-002-BMW', 2022, 'BMW', '7 Series', 'White', 5, 'Petrol', 'Heated Seats, GPS, Bluetooth'),
('Mercedes-Benz S-Classcom', 'Luxury', 'High-end Mercedes sedan.', 170.00, 'assets/cars/Mercedes-Benz S-Classcom.png', 'Available', 'LUX-003-MBZ', 2023, 'Mercedes-Benz', 'S-Class', 'Silver', 5, 'Petrol', 'Sunroof, Massage Seats, GPS'),
('Lexus LS', 'Luxury', 'Refined luxury with smooth ride.', 145.00, 'assets/cars/Lexus LS.png', 'Available', 'LUX-004-LEX', 2021, 'Lexus', 'LS', 'Gray', 5, 'Petrol', 'Touchscreen, Parking Sensors'),

('Toyota RAV4', 'SUV', 'Reliable and spacious SUV.', 100.00, 'assets/cars/Toyota RAV4.png', 'Available', 'SUV-001-TYR', 2022, 'Toyota', 'RAV4', 'White', 5, 'Petrol', 'All-Wheel Drive, Bluetooth'),
('Honda CR-V', 'SUV', 'Compact SUV with great fuel economy.', 95.00, 'assets/cars/Honda CR-V.png', 'Available', 'SUV-002-HCR', 2021, 'Honda', 'CR-V', 'Blue', 5, 'Petrol', 'Rear Camera, Cruise Control'),
('Hyundai Tucson', 'SUV', 'Stylish and affordable SUV.', 90.00, 'assets/cars/Hyundai Tucson.png', 'Available', 'SUV-003-HYT', 2021, 'Hyundai', 'Tucson', 'Gray', 5, 'Petrol', 'Touchscreen, Lane Assist'),
('Ford Explorer', 'SUV', 'Spacious SUV for families.', 110.00, 'assets/cars/Ford Explorer.png', 'Available', 'SUV-004-FDE', 2022, 'Ford', 'Explorer', 'Black', 7, 'Petrol', 'GPS, Parking Sensors'),
('Jeep Grand Cherokee', 'SUV', 'Off-road and urban capable.', 120.00, 'assets/cars/Jeep Grand Cherokee.png', 'Available', 'SUV-005-JGC', 2023, 'Jeep', 'Grand Cherokee', 'Red', 5, 'Petrol', '4WD, Navigation'),

('Tesla Model 3', 'Electric', 'Affordable electric car.', 130.00, 'assets/cars/Tesla Model 3.png', 'Available', 'ELE-001-TM3', 2023, 'Tesla', 'Model 3', 'White', 5, 'Electric', 'Autopilot, GPS'),
('Tesla Model S', 'Electric', 'Premium electric vehicle.', 180.00, 'assets/cars/Tesla Model S.png', 'Available', 'ELE-002-TMS', 2022, 'Tesla', 'Model S', 'Black', 5, 'Electric', 'Long Range, Autopilot'),
('Hyundai Ioniq 5', 'Electric', 'Modern design and efficient EV.', 125.00, 'assets/cars/Hyundai Ioniq 5.png', 'Available', 'ELE-003-HYI', 2022, 'Hyundai', 'Ioniq 5', 'Silver', 5, 'Electric', 'Fast Charging, Navigation'),
('Kia EV6', 'Electric', 'Sleek and futuristic electric car.', 128.00, 'assets/cars/Kia EV6.png', 'Available', 'ELE-004-KIE', 2022, 'Kia', 'EV6', 'Gray', 5, 'Electric', 'Wireless CarPlay, Lane Assist'),
('Chevrolet Bolt EV', 'Electric', 'Compact electric hatchback.', 115.00, 'assets/cars/Chevrolet Bolt EV.png', 'Available', 'ELE-005-CBV', 2021, 'Chevrolet', 'Bolt EV', 'Blue', 5, 'Electric', 'Touchscreen, GPS'),
('Nissan Leaf', 'Electric', 'Trusted electric car.', 110.00, 'assets/cars/Nissan Leaf.png', 'Available', 'ELE-006-NSL', 2021, 'Nissan', 'Leaf', 'Green', 5, 'Electric', 'Backup Camera, Navigation'),

('Toyota Corolla', 'Economy', 'Fuel-efficient and reliable.', 65.00, 'assets/cars/Toyota Corolla.png', 'Available', 'ECO-001-TYC', 2021, 'Toyota', 'Corolla', 'White', 5, 'Petrol', 'Bluetooth, USB'),
('Honda Civic', 'Economy', 'Comfortable and compact.', 67.00, 'assets/cars/Honda Civic.png', 'Available', 'ECO-002-HDC', 2022, 'Honda', 'Civic', 'Black', 5, 'Petrol', 'Touchscreen, Cruise Control'),
('Hyundai Elantra', 'Economy', 'Stylish and affordable sedan.', 64.00, 'assets/cars/Hyundai Elantra.png', 'Available', 'ECO-003-HYE', 2022, 'Hyundai', 'Elantra', 'Silver', 5, 'Petrol', 'Apple CarPlay, Rear Camera'),
('Kia Rio', 'Economy', 'Compact and budget-friendly.', 60.00, 'assets/cars/Kia Rio.png', 'Available', 'ECO-004-KIR', 2021, 'Kia', 'Rio', 'Blue', 5, 'Petrol', 'AUX, USB, Bluetooth'),
('Nissan Versa', 'Economy', 'Simple and fuel-efficient.', 62.00, 'assets/cars/Nissan Versa.png', 'Available', 'ECO-005-NSV', 2022, 'Nissan', 'Versa', 'Gray', 5, 'Petrol', 'Cruise Control, USB Port');
