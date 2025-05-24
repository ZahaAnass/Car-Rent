<?php
$host = 'localhost';
$dbname = 'zoomix_rental';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    // Enable errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set Default Fetch Mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Test Connection
    // echo "DB Connection successful";
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

?>