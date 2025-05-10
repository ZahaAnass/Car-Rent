-- Database Schema

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    role ENUM('User', 'Admin') NOT NULL DEFAULT 'User',
    address_country VARCHAR(100),
    address_city VARCHAR(100),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create cars table
CREATE TABLE cars (
    car_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
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
    email VARCHAR(255) NOT NULL,
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
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (token)
);