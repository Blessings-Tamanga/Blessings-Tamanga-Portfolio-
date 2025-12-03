<?php
class Message {
    private $conn;
    private $table_name = "messages";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name = :name, email = :email, subject = :subject, 
                      message = :message, ip_address = :ip_address, user_agent = :user_agent";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":subject", $data['subject']);
        $stmt->bindParam(":message", $data['message']);
        $stmt->bindParam(":ip_address", $data['ip_address']);
        $stmt->bindParam(":user_agent", $data['user_agent']);
        
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $messages = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messages[] = $row;
        }
        return $messages;
    }

    public function getUnreadCount() {
        $query = "SELECT COUNT(*) as unread_count FROM " . $this->table_name . " WHERE is_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['unread_count'];
    }

    public function getTotalCount() {
        $query = "SELECT COUNT(*) as total_count FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_count'];
    }

    public function markAsRead($message_id) {
        $query = "UPDATE " . $this->table_name . " SET is_read = 1 WHERE message_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$message_id]);
    }

    public function markAsReplied($message_id) {
        $query = "UPDATE " . $this->table_name . " SET replied = 1 WHERE message_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$message_id]);
    }

    public function getById($message_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE message_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$message_id]);
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>