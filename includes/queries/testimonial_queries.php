<?php

class TestimonialQueries {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createTestimonial($user_id, $user_name_display, $testimonial_text, $rating) {
        $sql = "INSERT INTO testimonials (user_id, user_name_display, testimonial_text, rating, status) VALUES (:user_id, :user_name_display, :testimonial_text, :rating, :status)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'user_name_display' => $user_name_display,
                'testimonial_text' => $testimonial_text,
                'rating' => $rating,
                'status' => 'Pending'
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getTestimonialById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM testimonials WHERE testimonial_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllTestimonials() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM testimonials");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getTestimonialsByUserId($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM testimonials WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateTestimonial($id, $user_name_display, $testimonial_text, $rating) {
        $sql = "UPDATE testimonials SET user_name_display = :user_name_display, testimonial_text = :testimonial_text, rating = :rating WHERE testimonial_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'user_name_display' => $user_name_display,
                'testimonial_text' => $testimonial_text,
                'rating' => $rating
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteTestimonial($id) {
        $sql = "DELETE FROM testimonials WHERE testimonial_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateTestimonialStatus($id, $status) {
        $sql = "UPDATE testimonials SET status = :status WHERE testimonial_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllTestimonialsCount($user_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM testimonials WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentTestimonialsByUserId($user_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    t.testimonial_id,
                    CONCAT(u.first_name, ' ', u.last_name) as display_name,
                    t.testimonial_text,
                    t.rating,
                    t.submitted_at as created_at
                FROM testimonials t
                JOIN users u ON t.user_id = u.user_id
                WHERE t.user_id = :user_id
                ORDER BY t.testimonial_id DESC
                LIMIT 5
            ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getRecentTestimonials(){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM testimonials ORDER BY testimonial_id DESC LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getTestimonialsWithLimit($limit, $offset, $status_filter = null, $search = null) {
        try {
            $sql = "SELECT t.*, u.first_name, u.last_name FROM testimonials t 
                    LEFT JOIN users u ON t.user_id = u.user_id WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND t.status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (t.user_name_display LIKE :search OR t.testimonial_text LIKE :search OR u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $sql .= " ORDER BY t.testimonial_id DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->pdo->prepare($sql);
            
            // Bind parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getTestimonialCount($status_filter = null, $search = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM testimonials t 
                    LEFT JOIN users u ON t.user_id = u.user_id WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND t.status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (t.user_name_display LIKE :search OR t.testimonial_text LIKE :search OR u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllTestimonialsWithFilter($status_filter = null, $search = null) {
        try {
            $sql = "SELECT t.*, u.first_name, u.last_name FROM testimonials t 
                    LEFT JOIN users u ON t.user_id = u.user_id WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND t.status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (t.user_name_display LIKE :search OR t.testimonial_text LIKE :search OR u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $sql .= " ORDER BY t.testimonial_id DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}

?>