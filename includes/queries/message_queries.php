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

    public function getAllMessages($status_filter = null, $search = null, $order = 'DESC') {
        try {
            $sql = "SELECT * FROM messages WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (name LIKE :search OR email LIKE :search OR subject LIKE :search OR message_body LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $sql .= " ORDER BY received_at " . ($order === 'ASC' ? 'ASC' : 'DESC');

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function getMessagesWithLimit($limit, $offset, $status_filter = null, $search = null, $order = 'DESC') {
        try {
            $sql = "SELECT * FROM messages WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (name LIKE :search OR email LIKE :search OR subject LIKE :search OR message_body LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $sql .= " ORDER BY received_at " . ($order === 'ASC' ? 'ASC' : 'DESC');
            $sql .= " LIMIT :limit OFFSET :offset";

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

    public function getMessageCount($status_filter = null, $search = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM messages WHERE 1=1";
            $params = [];

            // Add status filter
            if ($status_filter && $status_filter !== '') {
                $sql .= " AND status = :status";
                $params['status'] = $status_filter;
            }

            // Add search filter
            if ($search && $search !== '') {
                $sql .= " AND (name LIKE :search OR email LIKE :search OR subject LIKE :search OR message_body LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result['count'];
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

    public function getRecentMessages() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM messages ORDER BY received_at DESC LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

}

?>