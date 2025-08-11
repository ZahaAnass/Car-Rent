<?php

class BookingQueries {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createBooking($user_id, $car_id, $pickup_date, $return_date, $pickup_location, $return_location, $total_price) {
        $sql = "INSERT INTO bookings (user_id, car_id, pickup_date, return_date, pickup_location, return_location, total_price, status) VALUES (:user_id, :car_id, :pickup_date, :return_date, :pickup_location, :return_location, :total_price, :status)"; 
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'car_id' => $car_id,
                'pickup_date' => $pickup_date,
                'return_date' => $return_date,
                'pickup_location' => $pickup_location,
                'return_location' => $return_location,
                'total_price' => $total_price,
                'status' => 'Pending',
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getBookingById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE booking_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getBookingByUserId($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function isCarAvailable($car_id, $pickup_date, $return_date) {
        $sql = "SELECT * FROM bookings WHERE car_id = :car_id AND NOT (:return_date < pickup_date OR :pickup_date > return_date)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'car_id' => $car_id,
                'pickup_date' => $pickup_date,
                'return_date' => $return_date
            ]);
            return $stmt->rowCount() == 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateBookingStatus($id, $status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE bookings SET status = :status WHERE booking_id = :id");
            $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
            return $stmt->rowCount() > 0;
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateBookingDetails($id, $pickup_date, $return_date, $pickup_location, $return_location, $total_price) {
        $sql = "UPDATE bookings SET pickup_date = :pickup_date, return_date = :return_date, pickup_location = :pickup_location, return_location = :return_location, total_price = :total_price WHERE booking_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'pickup_date' => $pickup_date,
                'return_date' => $return_date,
                'pickup_location' => $pickup_location,
                'return_location' => $return_location,
                'total_price' => $total_price
            ]);
            return $stmt->rowCount() > 0;
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteBooking($id) {
        $sql = "DELETE FROM bookings WHERE booking_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllBookings($status_filter = null, $search = null) {
        try {
            $status_filter = $status_filter ?? '';
            $search = $search ?? '';
            
            if (!$status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b");
            } elseif($status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b WHERE b.status = :status_filter");
            } elseif(!$status_filter && $search) {
                $search = "%$search%"; // Add wildcards for LIKE query
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b WHERE (b.user_id IN (SELECT id FROM users WHERE first_name LIKE :search OR last_name LIKE :search) OR b.car_id IN (SELECT id FROM cars WHERE name LIKE :search))");
            } elseif($status_filter && $search) {
                $search = "%$search%"; // Add wildcards for LIKE query
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b WHERE b.status = :status_filter AND (b.user_id IN (SELECT id FROM users WHERE first_name LIKE :search OR last_name LIKE :search) OR b.car_id IN (SELECT id FROM cars WHERE name LIKE :search))");
            }
            
            if ($status_filter) {
                $stmt->bindParam(':status_filter', $status_filter, PDO::PARAM_STR);
            }
            if ($search) {
                $stmt->bindParam(':search', $search, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getAllBookings: " . $e->getMessage());
            return [];
        }
    }

    public function checkCarAvailability($car_id, $pickup_date, $return_date) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE car_id = :car_id AND NOT (:return_date < pickup_date OR :pickup_date > return_date) AND status != 'Pending'");
            $stmt->execute([
                'car_id' => $car_id,
                'pickup_date' => $pickup_date,
                'return_date' => $return_date
            ]);
            return $stmt->rowCount() == 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getBookingCount() {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bookings");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getBookingsWithLimit($limit, $offset, $status_filter, $search) {
        try {
            $status_filter = $status_filter ?? '';
            $search = $search ?? '';
            $limit = filter_var($limit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 10]]);
            $offset = filter_var($offset, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'default' => 0]]);
            if (!$status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b LIMIT :limit OFFSET :offset");
            } elseif($status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b WHERE b.status = :status_filter LIMIT :limit OFFSET :offset");
            } elseif(!$status_filter && $search) {
                $search = "%" . $search . "%";
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b 
                    WHERE (b.user_id IN (SELECT id FROM users WHERE first_name LIKE :search OR last_name LIKE :search) 
                    OR b.car_id IN (SELECT id FROM cars WHERE name LIKE :search)) 
                    LIMIT :limit OFFSET :offset");
            } elseif($status_filter && $search) {
                $search = "%" . $search . "%";
                $stmt = $this->pdo->prepare("SELECT b.* FROM bookings b 
                    WHERE b.status = :status_filter AND (b.user_id IN (SELECT id FROM users WHERE first_name LIKE :search OR last_name LIKE :search) 
                    OR b.car_id IN (SELECT id FROM cars WHERE name LIKE :search)) 
                    LIMIT :limit OFFSET :offset");
            }
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            if ($status_filter) {
                $stmt->bindParam(':status_filter', $status_filter, PDO::PARAM_STR);
            }
            if ($search) {
                $stmt->bindParam(':search', $search, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);                
        } catch (PDOException $e) {
            error_log("Database error in getBookingsWithLimit: " . $e->getMessage());
            return [];
        }
    }

    public function cancelBooking($booking_id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE booking_id = :booking_id");
            $stmt->execute(['booking_id' => $booking_id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateBookingStatusBasedOnDate() {
        $current_date = date('Y-m-d H:i:s');
        
        $this->pdo->prepare("
            UPDATE bookings 
            SET status = 'Active' 
            WHERE status = 'Confirmed' 
            AND pickup_date <= :current_date 
            AND return_date >= :current_date
        ")->execute(['current_date' => $current_date]);
        
        $this->pdo->prepare("
            UPDATE bookings 
            SET status = 'Completed' 
            WHERE status = 'Active' 
            AND return_date < :current_date
        ")->execute(['current_date' => $current_date]);
    }

    public function getTotalBookingsByUserId($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM bookings WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getTotalRevenue() {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(total_price) AS total FROM bookings");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getActiveRentals() {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM bookings WHERE status = 'Active'");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentBookings() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM bookings ORDER BY booking_id DESC LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentSpendedMoney() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    b.booking_id,
                    b.user_id,
                    b.total_price,
                    b.pickup_date,
                    c.name as car_name,
                    c.make as car_brand
                FROM bookings b
                JOIN cars c ON b.car_id = c.car_id
                ORDER BY b.booking_id DESC
                LIMIT 5
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentBookingsByUserId($user_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    b.booking_id,
                    b.car_id,
                    b.status,
                    b.pickup_date,
                    b.return_date,
                    c.name as car_name,
                    c.make as car_brand,
                    c.daily_rate
                FROM bookings b
                JOIN cars c ON b.car_id = c.car_id
                WHERE b.user_id = :user_id
                ORDER BY b.booking_id DESC
                LIMIT 5
            ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}

?>