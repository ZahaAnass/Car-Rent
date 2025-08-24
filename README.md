# Car-Rent

A modern, fully-functional car rental web application with comprehensive user and admin panels.

## Project Overview

Car-Rent is a complete car rental management system with both user-facing and administrative capabilities. Built with PHP 8, MySQL, and responsive Bootstrap 5 design, it features secure user authentication, car booking, testimonials, messaging, and comprehensive admin controls for managing users, vehicles, reservations, and more. The application implements the MVC (Model-View-Controller) pattern with separation of business logic from presentation layers through a well-organized query class system.

## Features

### User Features

- User registration and authentication with email verification
- Password recovery with secure reset codes
- User profiles with personal information management
- Car browsing and filtering by type, availability, and features
- Car booking system with date selection and location options
- Booking management (view, cancel)
- Testimonial submission
- Contact form for inquiries

### Admin Features

- Comprehensive dashboard with statistics and recent activities
- User management (view, add, edit, delete users and change roles)
- Car inventory management (add, edit, delete vehicles with detailed specifications)
- Reservation management (view, confirm, cancel bookings)
- Testimonial moderation (approve/reject user feedback)
- Message center for customer inquiries
- Settings management

### Technical Features

- Responsive design (Bootstrap 5)
- Secure authentication with password hashing
- PDO database interaction for SQL injection prevention
- Modular architecture with clean separation of concerns
- Email integration for notifications and verification
- "Remember me" functionality
- Input validation and sanitization
- Dynamic content loading
- AJAX-powered interactions

## Detailed Directory Structure and File Functionality

### Admin Module (`/admin`)

This directory contains all administrator-specific functionality, providing a complete management interface for the car rental business.

- `dashboard.php` - Main admin landing page displaying key statistics, recent bookings, user registrations, messages, and testimonials
- `index.php` - Redirect script that ensures proper admin authentication before accessing the dashboard
- `manage-cars.php` - Interface for viewing, filtering, and managing the car inventory with pagination
- `manage-car-handeler.php` - Backend processor for car CRUD operations (Create, Read, Update, Delete)
- `manage-users.php` - Interface for user account management with role assignment capabilities
- `manage-user-handeler.php` - Backend processor for user management operations
- `manage-reservations.php` - Interface for viewing and managing all booking reservations
- `manage-reservation-handeler.php` - Backend processor for updating booking statuses
- `manage-testimonials.php` - Interface for moderating user testimonials
- `manage-testimonials-handler.php` - Backend processor for approving/rejecting testimonials
- `manage-message.php` - Interface for viewing and responding to customer inquiries
- `manage-message-handler.php` - Backend processor for marking messages as read/unread
- `settings.php` - Admin account settings page for profile management
- `settings-handler.php` - Backend processor for admin profile updates

### API Module (`/api`)

Provides data endpoints for AJAX functionality throughout the application.

- `get_car_details.php` - Returns JSON data for car details used in dynamic car information loading

### Authentication Module (`/auth`)

Handles all user authentication, registration, and account management processes.

- `login.php` - User login interface with "Remember Me" functionality
- `login-handeler.php` - Backend processor for authentication validation
- `register.php` - New user registration interface
- `register-handeler.php` - Backend processor for account creation
- `logout.php` - Session termination and cookie cleanup
- `forgot-password.php` - Password recovery request interface
- `forgot-password-handler.php` - Backend processor for initiating password reset
- `reset-password.php` - Interface for setting new password
- `reset-password-handler.php` - Backend processor for password updates
- `verify-code.php` - Interface for password reset code verification
- `verify-code-handler.php` - Backend processor for code validation
- `send-code-again.php` - Backend processor for resending verification codes
- `google-handler.php` - OAuth integration for Google sign-in
- `profile-completion.php` - Interface for completing profile after social login
- `profile-completion-handler.php` - Backend processor for profile completion

### Assets (`/assets`)

Contains all static resources used throughout the application.

- `/cars` - Vehicle images organized by make and model
- `/css` - Stylesheet files including Bootstrap and custom styles
- `/img` - General images for UI elements and branding
- `/js` - JavaScript files:
  - `add-user-validation.js` - Client-side validation for user creation form
  - `countries-cities.json` - Location data for address selection
  - `countries.js` - Country/city selection functionality
  - `filterCars.js` - Dynamic car filtering on the frontend
  - `header_footer.js` - Navigation and footer behavior
  - `login-validation.js` - Client-side validation for login form
  - `main.js` - Core JavaScript functionality
  - `register-validation.js` - Client-side validation for registration form
  - `setting.js` - Account settings form handling
- `/lib` - Third-party libraries for animations, carousels, and other UI components
- `/uploads` - Target directory for dynamically uploaded content

### Configuration (`/config`)

Core application settings and database connection management.

- `config.php` - Application-wide configuration settings
- `database.php` - Database connection setup using PDO for secure queries

### Includes (`/includes`)

Shared components and utilities used throughout the application.

- `auth_admin_check.php` - Authentication middleware for admin access control
- `auth_user_check.php` - Authentication middleware for regular user access control
- `auth_header.php` - Common header for authentication pages
- `auth_footer.php` - Common footer for authentication pages
- `auto-login.php` - "Remember Me" functionality implementation
- `bottom-nav.php` - Mobile-friendly bottom navigation component
- `footer.php` - Common footer for main application pages
- `functions.php` - Global utility functions for validation, email sending, etc.
- `header.php` - Common header for main application pages
- `session.php` - Session management functionality
- `sidebar.php` - Navigation sidebar component
- `/queries` - Database model classes:
  - `booking_queries.php` - Booking-related database operations
  - `car_queries.php` - Car-related database operations
  - `message_queries.php` - Message-related database operations
  - `testimonial_queries.php` - Testimonial-related database operations
  - `user_queries.php` - User-related database operations

### Public Frontend (`/public`)

Customer-facing pages that represent the main website.

- `index.php` - Homepage with featured cars and main navigation
- `about.php` - Company information page
- `cars.php` - Car browsing and filtering interface
- `contact.php` - Contact form interface
- `contact-handler.php` - Backend processor for contact form submissions
- `service.php` - Service information page
- `feature.php` - Feature highlight page
- `team.php` - Team information page
- `testimonial.php` - Public testimonials display
- `blog.php` - Blog posts display
- `privacy.php` - Privacy policy page
- `terms.php` - Terms and conditions page
- `404.php` - Custom error page

### User Module (`/user`)

Customer account functionality for managing bookings and preferences.

- `dashboard.php` - User account overview showing recent activity
- `index.php` - Redirect script ensuring proper authentication
- `book-car.php` - Car booking interface with date/location selection
- `book-car-handeler.php` - Backend processor for booking creation
- `my-reservations.php` - Interface for viewing personal bookings
- `cancel-booking.php` - Backend processor for cancelling bookings
- `add-testimonial.php` - Interface for submitting feedback
- `testimonial-handler.php` - Backend processor for testimonial submission
- `settings.php` - User account settings page
- `settings-handler.php` - Backend processor for profile updates

### Vendor (`/vendor`)

Composer-managed dependencies.

- `autoload.php` - Composer autoloader for PHP dependencies
- Third-party libraries:
  - `phpmailer` - Email functionality
  - `dotenv` - Environment variable management
  - `firebase` - Google authentication integration
  - `google` - Google API client
  - `symfony` - Various utilities
  - `vlucas` - PHPDotEnv package

### Root Files

- `.htaccess` - Apache server configuration for URL rewriting and security
- `composer.json` - Dependency management specification
- `composer.lock` - Dependency version locking
- `database.sql` - Database schema and initial data
- `index.php` - Entry point that redirects to public homepage
- `README.md` - Project documentation
- `structure.txt` - File structure documentation
- `tree_structure.sh` - Script to generate directory structure

## Admin Panel Functionality

### Dashboard (`admin/dashboard.php`)

- Overview of system statistics (users, cars, revenue, active rentals)
- Recent activities (bookings, testimonials, messages, new users)

### User Management (`admin/manage-users.php`)

- View all users with pagination and filtering
- Add new users with complete profile information
- Edit existing user details, change roles (User/Admin)
- Delete users

1. Navigate to "Manage Users" in the admin sidebar
2. Click "Add New User" to create a user
3. Use the filter and search options to find specific users
4. Click the action buttons to edit or delete users

### Car Management (`admin/manage-cars.php`)

- View all cars with pagination and filtering by type/status
- Add new cars with detailed specifications (make, model, year, features, etc.)
- Upload car images
- Edit car details and change availability status
- Delete cars from inventory

1. Navigate to "Manage Cars" in the admin sidebar
2. Click "Add New Car" to add a vehicle to inventory
3. Use the filter options to view cars by type or status
4. Click the action buttons to edit or delete cars

### Reservation Management (`admin/manage-reservations.php`)

- View all bookings with pagination and filtering
- See booking details (user, car, dates, price)
- Update booking status (Confirm, Cancel, Complete)
- Auto-update of booking status based on dates

1. Navigate to "Manage Reservations" in the admin sidebar
2. Use filters to view bookings by status
3. Click on action buttons to update booking status

### Testimonial Management (`admin/manage-testimonials.php`)

- View all testimonials submitted by users
- Approve or reject testimonials for public display
- Delete testimonials

1. Navigate to "Manage Testimonials" in the admin sidebar
2. Review pending testimonials
3. Click "Approve" or "Reject" for each testimonial

### Message Center (`admin/manage-message.php`)

- View and respond to customer inquiries
- Mark messages as read
- Delete messages

1. Navigate to "Messages" in the admin sidebar
2. View message details
3. Mark messages as read after handling

## User Panel Functionality

### Dashboard (`user/dashboard.php`)

- Overview of user activity and recent bookings
- Quick stats (total bookings, money spent)

### Car Booking (`user/book-car.php`)

- Select cars from inventory
- Choose pickup and return dates
- Select locations
- View pricing calculation
- Confirm booking

1. Browse cars from the main page or car catalog
2. Click "Book Now" on a car
3. Fill in the booking form with dates and locations
4. Confirm booking

### Reservations (`user/my-reservations.php`)

- View all personal bookings
- See status and details of each booking
- Cancel upcoming bookings if needed

### Testimonials (`user/add-testimonial.php`)

- Submit reviews about rental experience
- Rate service with 1-5 stars
- View submitted testimonials

### User Settings (`user/settings.php`)

- Update personal information
- Change password
- Manage contact details

## Database Structure

The system uses a MySQL database with the following main tables:

- `users` - User accounts and profiles
  - Stores user information (ID, name, email, password hash, phone, license, address, role)
  - Role-based access control (User/Admin)
  - Tracks registration date
  - Maintains unique constraints on email and license number

- `cars` - Vehicle inventory and specifications
  - Comprehensive vehicle details (make, model, year, type, color)
  - Categorization by type (Electric, SUV, Luxury, Economy)
  - Status tracking (Available, Rented, Maintenance, Unavailable)
  - Price management with daily rates
  - Features and specifications storage
  - Image URL reference
  - Timestamps for creation and updates

- `bookings` - Rental reservations
  - Links users to cars with foreign key relationships
  - Date range for pickup and return
  - Location information
  - Total price calculation
  - Status tracking (Pending, Confirmed, Cancelled, Completed, Active)
  - Automatic status updates based on dates
  - Timestamps for creation and updates

- `testimonials` - User reviews
  - User feedback with ratings (1-5 stars)
  - Moderation system (Pending, Approved, Rejected)
  - User attribution with foreign key to users table
  - Submission timestamp

- `messages` - Customer inquiries
  - Contact form submissions
  - Inquiry type categorization
  - Status tracking (Read/Unread)
  - Timestamp for receipt

- `remember_me_tokens` - Authentication persistence
  - Secure token storage for "Remember Me" functionality
  - User association with foreign key
  - Expiration management
  - Token uniqueness enforcement

- `password_reset_tokens` - Password recovery
  - Secure password reset mechanism
  - One-time verification codes
  - Token-based authentication
  - Expiration management
  - Usage tracking

## Getting Started

1. **Clone or Download** this repository:

   ```bash
   git clone https://github.com/ZahaAnass/Car-Rent.git
   cd Car-Rent
   ```

2. **Create Database**: Import `database.sql` to set up the database schema

3. **Configure Environment**: Create `.env` file with database credentials and email settings

4. **Copy environment file**

   ```bash
   cp .env.example .env
   ```

5. **Required environment variables**

   ```bash
       CLIENT_ID=your_google_client_id_here
       CLIENT_SECRET=your_google_client_secret_here
       REDIRECT_URI=your_redirect_uri_here

       MAIL_HOST=your_smtp_host
       MAIL_PORT=587
       MAIL_USERNAME=your_email@example.com
       MAIL_PASSWORD=your_email_password_or_app_password
       MAIL_ENCRYPTION=tls

       DB_HOST=localhost
       DB_NAME=your_database_name
       DB_USER=your_database_username
       DB_PASSWORD=your_database_password
       DB_CHARSET=utf8mb4
   ```

6. **Install Dependencies**: Run `composer install` to install PHP dependencies

7. **Server Setup**: Configure your web server (Apache/Nginx) to point to the project directory

8. **Access Application**: Navigate to the site URL in your browser

9. **Permissions (Linux/Mac)**

   ```bash
   chmod -R 755 assets/uploads/
   chmod -R 755 assets/cars/
   ```

## Customization

- Edit core settings in `config/config.php`
- Modify database connection in `config/database.php`
- Customize email templates in the `includes/functions.php`
- Adjust styling in `assets/css/style.css`

## Security Features

- Password hashing using PHP's password_hash()
- CSRF protection for forms
- Input validation and sanitization
- PDO prepared statements for database queries
- Role-based access control
- Secure session management

### Credits

- [Bootstrap](https://getbootstrap.com/)
- [FontAwesome](https://fontawesome.com/)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [Dotenv](https://github.com/vlucas/phpdotenv)
- [OwlCarousel](https://owlcarousel2.github.io/OwlCarousel2/)
- [Animate.css](https://animate.style/)
- [WOW.js](https://wowjs.uk/)
- [CounterUp](https://github.com/bfintal/Counter-Up)
- [Waypoints](http://imakewebthings.com/waypoints/)
- [Easing](https://gsgd.co.uk/sandbox/jquery/easing/)

## Technology Stack

### Backend

- **PHP 8+** - Server-side programming
- **MySQL** - Database management
- **PDO** - Database abstraction layer
- **Composer** - Dependency management

### Frontend

- **HTML5/CSS3** - Markup and styling
- **Bootstrap 5** - Responsive framework
- **JavaScript/jQuery** - Interactive functionality
- **FontAwesome** - Icons

### Libraries & Tools

- **PHPMailer** - Email functionality
- **Google OAuth** - Social authentication
- **OwlCarousel** - Image sliders
- **WOW.js** - Animations

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact & Support

- **Developer**: Zaha Anass
- **GitHub**: [ZahaAnass](https://github.com/ZahaAnass)
- **Issues**: [Report Issues](https://github.com/ZahaAnass/Car-Rent/issues)
