<?php
function start_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function login_user($user_id, $username, $first_name, $last_name, $role = 'user') {
    start_session();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['role'] = $role;
}

function logout_user($redirect_url = "../public/index.php") {
    start_session();
    session_regenerate_id(true);
    $_SESSION = [];
    session_destroy();
    header("Location: $redirect_url");
    exit();
}

function is_logged_in() {
    start_session();
    return isset($_SESSION['user_id']);
}

function is_admin() {
    start_session();
    return $_SESSION['role'] === 'admin';
}

function require_login($redirect_url = "../public/login.php") {
    if (!is_logged_in()) {
        set_flash_message('auth_error', 'You must be logged in to access this page.', 'warning');
        header("Location: $redirect_url");
        exit();
    }
}

function require_admin($redirect_url = "../public/index.php") {
    if (!is_logged_in()) { 
        set_flash_message('auth_error', 'You must be logged in to access this page.', 'warning');
        header("Location: $redirect_url");
        exit();
    } elseif (!is_admin()) { 
        set_flash_message('auth_error', 'You do not have permission to access this page.', 'danger');
        header("Location: $redirect_url"); 
        exit();
    }
}

function set_flash_message($key, $message, $type = 'info') {
    start_session();
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    $_SESSION['flash_messages'][$key] = ['message' => $message, 'type' => $type];
}

function display_flash_messages() {
    start_session();
    if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])) {
        foreach ($_SESSION['flash_messages'] as $key => $flash) {
            $message = htmlspecialchars($flash['message']);
            $type = htmlspecialchars($flash['type']);
            $icon = '';
            switch ($type) {
                case 'success': $icon = '<i class="fas fa-check-circle me-2"></i>'; break;
                case 'danger': $icon = '<i class="fas fa-exclamation-triangle me-2"></i>'; break;
                case 'warning': $icon = '<i class="fas fa-exclamation-circle me-2"></i>'; break;
                case 'info': $icon = '<i class="fas fa-info-circle me-2"></i>'; break;
            }
            echo "<div class=\"alert alert-{$type} alert-dismissible fade show wow fadeInUp\" role=\"alert\">";
            echo "{$icon}{$message}";
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo "</div>";
        }
        unset($_SESSION['flash_messages']);
    }
}

?>