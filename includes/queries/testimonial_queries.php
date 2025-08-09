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

    public function getTestimonialCount() {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM testimonials");
            $stmt->execute();
            return $stmt->fetchColumn();
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



}

?>