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

    public function updateUserProfile($user_id, $first_name, $last_name, $email, $phone_number, $license_number) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, license_number = :license_number WHERE user_id = :user_id");
            $stmt->execute([
                'user_id' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone_number' => $phone_number,
                'license_number' => $license_number
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

    public function validateCurrentPassword($user_id, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT password_hash FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $row = $stmt->fetch();
            return password_verify($password, $row['password_hash']);
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

    public function createGoogleUser($first_name, $last_name, $email, $password_hash, $phone_number, $license_number, $role, $address_country, $address_city) {
        try {
            if ($this->emailExists($email)) {
                return false; // Email already exists
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
                'license_number' => $license_number, // Can be null for Google users initially
                'role' => $role,
                'address_country' => $address_country,
                'address_city' => $address_city
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Create Google user query failed: " . $e->getMessage());
        }
    }
    
    public function isProfileComplete($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT phone_number, license_number, address_country, address_city FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch();
            
            // Check if all required fields are filled
            return  !empty($user['phone_number']) && 
                    !empty($user['license_number']) && 
                    !empty($user['address_country']) && 
                    !empty($user['address_city']);
        } catch (PDOException $e) {
            die("Profile check query failed: " . $e->getMessage());
        }
    }
    
    public function completeProfile($user_id, $phone_number, $license_number, $address_country, $address_city) {
        try {
            // Check if license number is already taken by another user
            $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE license_number = :license_number AND user_id != :user_id");
            $stmt->execute(['license_number' => $license_number, 'user_id' => $user_id]);
            if ($stmt->rowCount() > 0) {
                return 'duplicate_license';
            }
            
            $stmt = $this->pdo->prepare(
                "UPDATE users SET phone_number = :phone_number, license_number = :license_number, " .
                "address_country = :address_country, address_city = :address_city WHERE user_id = :user_id"
            );
            $stmt->execute([
                'user_id' => $user_id,
                'phone_number' => $phone_number,
                'license_number' => $license_number,
                'address_country' => $address_country,
                'address_city' => $address_city
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Complete profile query failed: " . $e->getMessage());
        }
    }

    public function changePassword($user_id, $password) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id");
            $stmt->execute([
                'user_id' => $user_id,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
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

    public function deleteResetCodes($user_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM password_reset_tokens WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function storeResetCode($user_id, $code, $token, $expires_at) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO password_reset_tokens (user_id, code, token, expires_at) VALUES (:user_id, :code, :token, :expires_at)");
            
            $stmt->execute([
                ':user_id' => $user_id,
                ':code' => $code,
                ':token' => $token,
                ':expires_at' => $expires_at
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function verifyCode($user_id, $code) {
        try {
            $stmt = $this->pdo->prepare("SELECT token FROM password_reset_tokens WHERE user_id = :user_id AND code = :code AND expires_at > NOW() AND is_used = FALSE");
            $stmt->execute([
                ':user_id' => $user_id,
                ':code' => $code
            ]);
            $resetData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resetData;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function markCodeAsUsed($token) {
        try {
            $stmt = $this->pdo->prepare("UPDATE password_reset_tokens SET is_used = TRUE WHERE token = :token");
            $stmt->execute([':token' => $token]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function verifyToken($token) {
        try {
            $stmt = $this->pdo->prepare("SELECT prt.user_id, u.email FROM password_reset_tokens prt JOIN users u ON prt.user_id = u.user_id WHERE prt.token = :token AND prt.is_used = TRUE AND prt.expires_at > NOW()");
            $stmt->execute([':token' => $token]);
            $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $reset_data;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updatePassword($user_id, $password) {
        try{
            $hashed_password = hash_password($password);
        
            $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password WHERE user_id = :user_id");
            $result = $stmt->execute([
                ':password' => $hashed_password,
                ':user_id' => $user_id
            ]);
            return $result;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }            
    }

    public function deleteResetTokens($user_id) {
        try{
            $stmt = $this->pdo->prepare("DELETE FROM password_reset_tokens WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteRememberMeTokens($user_id) {
        try{
            $stmt = $this->pdo->prepare("DELETE FROM remember_me_tokens WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUserFromToken($token, $email) {
        try{
            $stmt = $this->pdo->prepare("SELECT u.first_name FROM users u JOIN password_reset_tokens prt ON u.user_id = prt.user_id WHERE prt.token = :token AND u.email = :email AND prt.is_used = TRUE");
            $stmt->execute([':token' => $token, ':email' => $email]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}

?>