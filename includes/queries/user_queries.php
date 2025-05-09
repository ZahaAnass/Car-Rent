<?php

class UserQueries {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getUserByEmail($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function emailExists($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function createUser($first_name, $last_name, $email, $password_hash, $phone_number, $role, $address_country, $address_city) {
        try {
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
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateUserProfile($user_id, $first_name, $last_name, $email, $phone_number, $address_country, $address_city) {
        try {
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
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateUserPassword($user_id, $password_hash) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
            $stmt->execute([
                'user_id' => $user_id,
                'password_hash' => $password_hash
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteUser($user_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllUsers() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function changeUserRole($user_id, $role) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE user_id = :user_id");
            $stmt->execute([
                'user_id' => $user_id,
                'role' => $role
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}
?>