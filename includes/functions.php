<?php

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
    return filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{10,15}$/']]) !== false;
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
    return filter_var($license_plate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9 -]{5,20}$/']]) !== false;
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
    return filter_var($user_id, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,10}$/']]) !== false;
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


?>