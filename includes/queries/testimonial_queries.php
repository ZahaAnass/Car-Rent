<?php

class TestimonialQueries {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createTestimonial($user_id, $user_name_display, $testimonial_text, $rating) {
        $sql = "INSERT INTO testimonials (user_id, user_name_display, testimonial_text, rating, status) VALUES (:user_id, :user_name_display, :testimonial_text, :rating, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'user_name_display' => $user_name_display,
            'testimonial_text' => $testimonial_text,
            'rating' => $rating,
            'status' => 'Pending'
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getTestimonialById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM testimonials WHERE testimonial_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAllTestimonials() {
        $stmt = $this->pdo->prepare("SELECT * FROM testimonials");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTestimonialsByUserId($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM testimonials WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function updateTestimonial($id, $user_name_display, $testimonial_text, $rating) {
        $sql = "UPDATE testimonials SET user_name_display = :user_name_display, testimonial_text = :testimonial_text, rating = :rating WHERE testimonial_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'user_name_display' => $user_name_display,
            'testimonial_text' => $testimonial_text,
            'rating' => $rating
        ]);
        return $stmt->rowCount() > 0;
    }

    public function deleteTestimonial($id) {
        $sql = "DELETE FROM testimonials WHERE testimonial_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function updateTestimonialStatus($id, $status) {
        $sql = "UPDATE testimonials SET status = :status WHERE testimonial_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getTestimonialCount() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM testimonials");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}