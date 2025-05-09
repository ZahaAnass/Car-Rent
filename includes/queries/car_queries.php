<?php

    class CarQueries {

        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function createCar($name, $type, $description, $daily_rate, $image_url, $license_plate, $year, $make, $model, $color, $seats, $fuel_type, $features) {
            $sql = "INSERT INTO cars (name, type, description, daily_rate, image_url, status, license_plate, year, make, model, color, seats, fuel_type, features) 
                    VALUES (:name, :type, :description, :daily_rate, :image_url, :status, :license_plate, :year, :make, :model, :color, :seats, :fuel_type, :features)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'daily_rate' => $daily_rate,
                'image_url' => $image_url,
                'status' => "Available",
                'license_plate' => $license_plate,
                'year' => $year,
                'make' => $make,
                'model' => $model,
                'color' => $color,
                'seats' => $seats,
                'fuel_type' => $fuel_type,
                'features' => $features
            ]);
            return $stmt->rowCount() > 0;
        }

        public function getCarById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE car_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        }

        public function getAllCars() {
            $stmt = $this->pdo->prepare("SELECT * FROM cars");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function updateCar($id, $name, $type, $description, $daily_rate, $image_url, $license_plate, $year, $make, $model, $color, $seats, $fuel_type, $features) {
            $sql = "UPDATE cars SET name = :name, type = :type, description = :description, daily_rate = :daily_rate,
                    image_url = :image_url, license_plate = :license_plate, year = :year, make = :make, model = :model,
                    color = :color, seats = :seats, fuel_type = :fuel_type, features = :features WHERE car_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'daily_rate' => $daily_rate,
                'image_url' => $image_url,
                'license_plate' => $license_plate,
                'year' => $year,
                'make' => $make,
                'model' => $model,
                'color' => $color,
                'seats' => $seats,
                'fuel_type' => $fuel_type,
                'features' => $features
            ]);
            return $stmt->rowCount() > 0;
        }

        public function deleteCar($id) {
            $sql = "DELETE FROM cars WHERE car_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        }

        public function getAvailableCars() {
            $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE status = 'Available'");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getCarByStatus($status) {
            $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE status = :status");
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll();
        }

        public function getCarCount() {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM cars");
            $stmt->execute();
            return $stmt->fetchColumn();
        }

    }

?>