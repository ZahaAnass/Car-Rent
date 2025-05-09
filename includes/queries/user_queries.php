<?php

class UserQueries {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function createUser($first_name, $last_name, $email, $password_hash, $phone_number, $role, $address_country, $address_city) {
        if ($this->emailExists($email)) {
            return false;
        }
        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, password_hash, phone_number, role, address_country, address_city) VALUES (:first_name, :last_name, :email, :password_hash, :phone_number, :role, :address_country, :address_city)");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password_hash' => $password_hash,
            'phone_number' => $phone_number,
            'role' => $role,
            'address_country' => $address_country,
            'address_city' => $address_city
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateUserProfile($user_id, $first_name, $last_name, $email, $phone_number, $address_country, $address_city) {
        $stmt = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, address_country = :address_country, address_city = :address_city WHERE user_id = :user_id");
        $stmt->execute([
            'user_id' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'address_country' => $address_country,
            'address_city' => $address_city
        ]);
        // Return true if at least one row was affected
        return $stmt->rowCount() > 0;
    }

    public function updateUserPassword($user_id, $password_hash) {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
        $stmt->execute([
            'user_id' => $user_id,
            'password_hash' => $password_hash
        ]);
        return $stmt->rowCount() > 0;
    }

    public function deleteUser($user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->rowCount() > 0;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        // Returns an array of all users
        return $stmt->fetchAll();
    }

    public function changeUserRole($user_id, $role) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE user_id = :user_id");
        $stmt->execute([
            'user_id' => $user_id,
            'role' => $role
        ]);
        return $stmt->rowCount() > 0;
    }

}
?>