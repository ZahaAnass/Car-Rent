<?php

    class CarQueries {

        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getCarById($id) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE car_id = :id");
                $stmt->execute(['id' => $id]);
                return $stmt->fetch();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getAllCars() {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars");
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getCarsByType($type) {
            $sanitizedType = filter_var($type, FILTER_SANITIZE_STRING);
            $carTypes = $this->getCarTypes();
            if(!in_array($sanitizedType, $carTypes)) {
                return $this->getAllCars();
            }
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE type = :type");
                $stmt->execute(['type' => $sanitizedType]);
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getCarTypes() {
            try {
                $stmt = $this->pdo->prepare("SELECT DISTINCT type FROM cars");
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function createCar($name, $type, $description, $daily_rate, $image_url, $status, $license_plate, $year, $make, $model, $color, $seats, $fuel_type, $features) {
            if($this->licenseExists($license_plate)) {
                return 'duplicate_license';
            }
            $sql = "INSERT INTO cars (name, type, description, daily_rate, image_url, status, license_plate, year, make, model, color, seats, fuel_type, features) 
                    VALUES (:name, :type, :description, :daily_rate, :image_url, :status, :license_plate, :year, :make, :model, :color, :seats, :fuel_type, :features)";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'daily_rate' => $daily_rate,
                    'image_url' => $image_url,
                    'status' => $status,
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
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function updateCar($car_id, $name, $type, $description, $daily_rate, $status, $license_plate, $year, $make, $model, $color, $seats, $fuel_type, $features) {
            $sql = "UPDATE cars SET name = :name, type = :type, description = :description, daily_rate = :daily_rate, status = :status, license_plate = :license_plate, year = :year, make = :make, model = :model, color = :color, seats = :seats, fuel_type = :fuel_type, features = :features WHERE car_id = :car_id";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    'car_id' => $car_id,
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'daily_rate' => $daily_rate,
                    'status' => $status,
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
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function deleteCar($id) {
            $sql = "DELETE FROM cars WHERE car_id = :id";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $id]);
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getAvailableCars() {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE status = 'Available'");
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getCarByStatus($status) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE status = :status");
                $stmt->execute(['status' => $status]);
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getCarCount() {
            try {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM cars");
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function licenseExists($license) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE license_plate = :license");
                $stmt->execute(['license' => $license]);
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public function getCarsWithLimit($limit, $offset) {
            try {
                $limit = filter_var($limit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 10]]);
                $offset = filter_var($offset, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'default' => 0]]);
                $stmt = $this->pdo->prepare("SELECT * FROM cars LIMIT :limit OFFSET :offset");
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);                
            } catch (PDOException $e) {
                error_log("Database error in getCarsWithLimit: " . $e->getMessage());
                return [];
            }
        }

        public function updateCarStatus($car_id, $status) {
            try {
                $stmt = $this->pdo->prepare("UPDATE cars SET status = :status WHERE car_id = :car_id");
                $stmt->execute(['car_id' => $car_id, 'status' => $status]);
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

    }

?>