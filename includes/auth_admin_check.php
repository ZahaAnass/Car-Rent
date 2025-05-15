<?php

include_once '../includes/session.php';
start_session();

include_once '../includes/functions.php';

// Check If User Is Logged In
if (!is_logged_in()) {
    redirect('../auth/login.php');
}

// Check If User Isn't Admin
if (!is_admin()) {
    redirect('../user/dashboard.php');
}
