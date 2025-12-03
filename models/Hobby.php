<?php
class Hobby {
    private $conn;
    private $table_name = "hobbies";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $hobbies = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $hobbies[] = $row;
        }
        return $hobbies;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET hobby_name=:hobby_name, description=:description, image_path=:image_path";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":hobby_name", $data['hobby_name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image_path", $data['image_path']);
        
        return $stmt->execute();
    }

    public function delete($hobby_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE hobby_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $hobby_id);
        return $stmt->execute();
    }

    public function getById($hobby_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE hobby_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $hobby_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function update($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                    hobby_name=:hobby_name, description=:description, image_path=:image_path
                  WHERE hobby_id=:hobby_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":hobby_name", $data['hobby_name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image_path", $data['image_path']);
        $stmt->bindParam(":hobby_id", $data['hobby_id']);
        
        return $stmt->execute();
    }
}
?>