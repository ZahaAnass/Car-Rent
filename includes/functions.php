<?php

// PHPMailer setup
require __DIR__ . "/../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_email($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function validate_phone($phone) {
    return filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{9,15}$/']]) !== false;
}

function validate_password($password) {
    return filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9]{8,}$/']]) !== false;
}

function validate_confirm_password($password, $confirm_password) {
    return $password === $confirm_password;
}

function validate_license($license){
    return filter_var($license, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9]{5,15}$/']]) !== false;
}

function validate_name($name) {
    return preg_match('/^[a-zA-Z0-9 ]{2,}$/', $name);
}

function validate_car($car) {
    return filter_var($car, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z- ]+$/']]) !== false;
}

function validate_car_model($car_model) {
    return filter_var($car_model, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9 ]+$/']]) !== false;
}

function validate_car_year($car_year) {
    return filter_var($car_year, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{4}$/']]) !== false;
}

function validate_car_price($car_price) {
    return filter_var($car_price, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,10}(\.[0-9]{1,2})?$/']]) !== false;
}

function validate_car_image($car_image) {
    return filter_var($car_image, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$/']]) !== false;
}

function validate_car_description($car_description) {
    return filter_var($car_description, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$/']]) !== false;
}

function validate_car_status($car_status) {
    return filter_var($car_status, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$/']]) !== false;
}

function validate_daily_rate($daily_rate) {
    return filter_var($daily_rate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,10}(\\.[0-9]{1,2})?$/']]) !== false;
}

function validate_license_plate($license_plate) {
    return filter_var($license_plate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[A-Za-z0-9\- ]{5,20}$/']]) !== false;
}

function validate_year($year) {
    return filter_var($year, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{4}$/']]) !== false;
}

function validate_seats($seats) {
    return filter_var($seats, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[1-9]$/']]) !== false;
}

function validate_fuel_type($fuel_type) {
    return filter_var($fuel_type, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$/']]) !== false;
}

function validate_features($features) {
    return empty($features) || filter_var($features, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9, ]+$/']]) !== false;
}

function validate_date($date){
    return filter_var($date, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/']]) !== false;
}

function validate_booking_id($booking_id){
    return filter_var($booking_id, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,10}$/']]) !== false;
}

function validate_user_id($user_id){
    return filter_var($user_id, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,11}$/']]) !== false;
}

function validate_action($action){
    return filter_var($action, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(add|delete|update)$/']]) !== false;
}

function validate_role($role){
    return filter_var($role, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(Admin|User)$/']]) !== false;
}

function get_current_page_name() {
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page;
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function get_post_var($var_name) {
    if (isset($_POST[$var_name])) {
        return $_POST[$var_name];
    }
    return null;
}

function get_get_var($var_name) {
    if (isset($_GET[$var_name])) {
        return $_GET[$var_name];
    }
    return null;
}

function sendVerificationCodeEmail($email, $firstName, $code) {

    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST']; // Gmail STMP server
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME']; // Email
        $mail->Password = $_ENV['MAIL_PASSWORD']; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['MAIL_PORT'];
        
        // Recipients
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Zoomix'); 
        $mail->addAddress($email, $firstName);
        $mail->addReplyTo($_ENV['MAIL_USERNAME'], 'Zoomix Support');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code - Zoomix';
        $mail->Body = generateVerificationEmailTemplate($firstName, $code);

        $mail->send();
        return true;
    } catch (Exception $e) {
        $_SESSION['forgot_error'] = "Email sending failed: " . $mail->ErrorInfo;
        return false;
    }
}

function generateVerificationEmailTemplate($firstName, $code) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Password Reset Code - Zoomix</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; background: white; }
            .header { background: #007bff; color: white; padding: 30px; text-align: center; }
            .logo { font-size: 28px; font-weight: bold; margin-bottom: 10px; }
            .content { padding: 40px 30px; }
            .code-box { background: #f8f9fa; border: 2px dashed #007bff; padding: 30px; text-align: center; margin: 30px 0; border-radius: 10px; }
            .code { font-size: 36px; font-weight: bold; color: #007bff; letter-spacing: 5px; font-family: monospace; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 14px; }
            .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <div class='logo'>🚗 Zoomix</div>
                <div>Password Reset Verification</div>
            </div>
            <div class='content'>
                <h2 style='color: #333; margin-top: 0;'>Hello " . htmlspecialchars($firstName) . "!</h2>
                <p>We received a request to reset your password for your Zoomix account.</p>
                <p>Please use the following 6-digit verification code:</p>
                
                <div class='code-box'>
                    <div style='font-size: 16px; margin-bottom: 10px; color: #666;'>Your Verification Code</div>
                    <div class='code'>" . $code . "</div>
                </div>
                
                <div class='warning'>
                    <strong>⚠️ Important:</strong>
                    <ul style='margin: 10px 0; padding-left: 20px;'>
                        <li>This code will expire in <strong>15 minutes</strong></li>
                        <li>Don't share this code with anyone</li>
                        <li>If you didn't request this, please ignore this email</li>
                    </ul>
                </div>
                
                <p>Enter this code on the password reset page to continue setting your new password.</p>
            </div>
            <div class='footer'>
                <p>This is an automated message from Zoomix. Please do not reply to this email.</p>
                <p>Need help? Contact us at support@zoomix.com</p>
            </div>
        </div>
    </body>
    </html>";
}


?>