<?php

class MessageQueries {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createMessage($name, $email, $phone, $inquiry_type, $subject, $message_body) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO messages (name, email, phone, inquiry_type, subject, message_body) VALUES (:name, :email, :phone, :inquiry_type, :subject, :message_body)");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'inquiry_type' => $inquiry_type,
                'subject' => $subject,
                'message_body' => $message_body
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getMessageById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE message_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getAllMessages($order = 'DESC') {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM messages ORDER BY received_at :order");
            $stmt->execute(['order' => $order]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function updateMessageStatus($id, $status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE messages SET status = :status WHERE message_id = :id");
            $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function deleteMessage($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM messages WHERE message_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getUnreadMessages() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE status = 'Unread'");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getReadMessages() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE status = 'Read'");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}

?>