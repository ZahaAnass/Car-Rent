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

    public function updateUserProfile($user_id, $first_name, $last_name, $email, $phone_number) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number WHERE user_id = :user_id");
            $stmt->execute([
                'user_id' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone_number' => $phone_number,
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
            return $row ? $row['user_id'] : null;
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

    public function getUserCount($status = null, $search = null){
        try{
            $query = "SELECT COUNT(*) as user_count FROM users WHERE 1=1";
            $params = [];
            if ($status !== null && $status !== "") {
                $query .= " AND role = :role";
                $params['role'] = $status;
            }
            if ($search !== null && $search !== "") {
                $query .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
                $params['search'] = "%{$search}%";
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUsersWithLimit($limit, $offset, $status = null, $search = null) {
        try {
            $query = "SELECT * FROM users WHERE 1=1";
            $params = [];
            if ($status !== null && $status !== "") {
                $query .= " AND role = :role";
                $params['role'] = $status;
            }
            if ($search !== null && $search !== "") {
                $query .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
                $params['search'] = "%{$search}%";
            }
            $query .= " ORDER BY user_id DESC LIMIT :limit OFFSET :offset";
            $params['limit'] = (int)$limit;
            $params['offset'] = (int)$offset;
            $stmt = $this->pdo->prepare($query);
            // Bind limit and offset as integers
            foreach ($params as $key => $value) {
                if ($key === 'limit' || $key === 'offset') {
                    $stmt->bindValue(":" . $key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(":" . $key, $value);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllSpendedMoney($user_id){
        try{
            $stmt = $this->pdo->prepare("SELECT SUM(total_price) FROM bookings WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentUsers() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY user_id DESC LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentSpendedMoney($user_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    b.booking_id,
                    b.total_price,
                    b.pickup_date,
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