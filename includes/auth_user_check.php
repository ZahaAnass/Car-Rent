<?php

include_once '../includes/session.php';
start_session();

include_once '../includes/functions.php';

// Check If User Is Logged In
if (!is_logged_in()) {
    redirect('../public/auth/login.php');
}

// Check If User Is Admin
if (is_admin()) {
    redirect('../admin/dashboard.php');
}
