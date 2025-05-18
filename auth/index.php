<?php
    require_once '../includes/session.php';
    start_session();

    require_once '../includes/functions.php';
    
    if (is_logged_in() && is_admin()) {
        redirect('../public/index.php');
    }elseif (is_logged_in() && !is_admin()) {
        redirect('../public/index.php');
    }
    else{
        redirect('../auth/login.php');
    }

?>