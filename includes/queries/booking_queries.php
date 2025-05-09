<?php

class BookingQueries {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createBooking($user_id, $car_id, $pickup_date, $return_date, $pickup_location, $return_location, $total_price) {
        $sql = "INSERT INTO bookings (user_id, car_id, pickup_date, return_date, pickup_location, return_location, total_price, status) VALUES (:user_id, :car_id, :pickup_date, :return_date, :pickup_location, :return_location, :total_price, :status)"; 
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
    }

    public function getBookingById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE booking_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getBookingByUserId($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function isCarAvailable($car_id, $pickup_date, $return_date) {
        $sql = "SELECT * FROM bookings WHERE car_id = :car_id AND NOT (:return_date < pickup_date OR :pickup_date > return_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'car_id' => $car_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date
        ]);
        return $stmt->rowCount() == 0;
    }

    public function updateBookingStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE bookings SET status = :status WHERE booking_id = :id");
        $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
        return $stmt->rowCount() > 0;
    }

    public function updateBookingDetails($id, $pickup_date, $return_date, $pickup_location, $return_location, $total_price) {
        $sql = "UPDATE bookings SET pickup_date = :pickup_date, return_date = :return_date, pickup_location = :pickup_location, return_location = :return_location, total_price = :total_price WHERE booking_id = :id";
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
    }

    public function deleteBooking($id) {
        $sql = "DELETE FROM bookings WHERE booking_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function getAllBookings() {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings");
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

?>