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

    public function getUserCount(){
        try{
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUsersWithLimit($limit, $offset, $status_filter, $search) {
        try {
            $status_filter = $status_filter ?? '';
            $search = $search ?? '';
            $limit = filter_var($limit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 10]]);
            $offset = filter_var($offset, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'default' => 0]]);
            if (!$status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
            } elseif($status_filter && !$search) {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = :status_filter LIMIT :limit OFFSET :offset");
            } elseif(!$status_filter && $search) {
                $search = "%" . $search . "%";
                $stmt = $this->pdo->prepare("SELECT * FROM users 
                    WHERE (first_name LIKE :search OR last_name LIKE :search) 
                    LIMIT :limit OFFSET :offset");
            } elseif($status_filter && $search) {
                $search = "%" . $search . "%";
                $stmt = $this->pdo->prepare("SELECT * FROM users 
                    WHERE role = :status_filter AND (first_name LIKE :search OR last_name LIKE :search) 
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
            error_log("Database error in getUsersWithLimit: " . $e->getMessage());
            return [];
        }
    }

}
?>