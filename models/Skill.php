<?php
class Skill {
    private $conn;
    private $table_name = "skills";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY category, level DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $skills = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $skills[] = $row;
        }
        return $skills;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET skill_name=:skill_name, category=:category, 
                      level=:level, description=:description, icon=:icon";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":skill_name", $data['skill_name']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":level", $data['level']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":icon", $data['icon']);
        
        return $stmt->execute();
    }

    public function delete($skill_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE skill_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $skill_id);
        return $stmt->execute();
    }

    public function getById($skill_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE skill_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $skill_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function update($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                    skill_name=:skill_name, category=:category, 
                    level=:level, description=:description, icon=:icon
                  WHERE skill_id=:skill_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":skill_name", $data['skill_name']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":level", $data['level']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":icon", $data['icon']);
        $stmt->bindParam(":skill_id", $data['skill_id']);
        
        return $stmt->execute();
    }
}
?>