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

    public function licenseExists($license_number) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE license_number = :license_number");
            $stmt->execute(['license_number' => $license_number]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function createUser($first_name, $last_name, $email, $password_hash, $phone_number, $license_number, $role, $address_country, $address_city) {
        try {
            if ($this->emailExists($email)) {
                return false; // Email already exists
            }
            if ($this->licenseExists($license_number)) {
                return false; // License already exists
            }
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (first_name, last_name, email, password_hash, phone_number, license_number, role, address_country, address_city) " .
                "VALUES (:first_name, :last_name, :email, :password_hash, :phone_number, :license_number, :role, :address_country, :address_city)"
            );
            $stmt->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password_hash' => $password_hash,
                'phone_number' => $phone_number,
                'license_number' => $license_number,
                'role' => $role,
                'address_country' => $address_country,
                'address_city' => $address_city
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create user query failed: " . $e->getMessage());
            return false;
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

    public function createRememberMeToken($user_id, $token, $expires_at) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO remember_me_tokens (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
            $stmt->execute([
                'user_id' => $user_id,
                'token' => $token,
                'expires_at' => $expires_at
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRememberMeToken($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM remember_me_tokens WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUserFromRememberMeToken($token) {
        try {
            $stmt = $this->pdo->prepare("SELECT user_id FROM remember_me_tokens WHERE token = :token AND expires_at > NOW()");
            $stmt->execute(['token' => $token]);
            $row = $stmt->fetch();
            return $row['user_id'];
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteRememberMeToken($token) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM remember_me_tokens WHERE token = :token");
            $stmt->execute(['token' => $token]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}
?>