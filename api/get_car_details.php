<?php
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/car_queries.php";

    if(isset($_GET['car_id']) && is_numeric($_GET['car_id'])){
        $car_id = filter_input(INPUT_GET, 'car_id', FILTER_VALIDATE_INT);
    }
    else{
        http_response_code(400);
        echo json_encode(['error' => 'Invalid car ID']);
        exit();
    }

    $carQueries = new CarQueries($pdo);
    $car = $carQueries->getCarById($car_id);

    if (!$car) {
        http_response_code(404);
        echo json_encode(['error' => 'Car not found']);
        exit();
    }

    echo json_encode($car);
?>