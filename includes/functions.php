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
    return filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{10}$/']]) !== false;
}

function validate_password($password) {
    return strlen($password) >= 8;
}

function validate_confirm_password($password, $confirm_password) {
    return $password === $confirm_password;
}

function validate_name($name) {
    return preg_match('/^[a-zA-Z ]+$/', $name);
}

function validate_car($car) {
    return filter_var($car, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$']]) !== false;
}

function validate_car_model($car_model) {
    return filter_var($car_model, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$']]) !== false;
}

function validate_car_year($car_year) {
    return filter_var($car_year, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{4}$/']]) !== false;
}

function validate_car_price($car_price) {
    return filter_var($car_price, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{4}$/']]) !== false;
}

function validate_car_image($car_image) {
    return filter_var($car_image, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$']]) !== false;
}

function validate_car_description($car_description) {
    return filter_var($car_description, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$']]) !== false;
}

function validate_car_status($car_status) {
    return filter_var($car_status, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z ]+$']]) !== false;
}

function get_current_page_name() {
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page;
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
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