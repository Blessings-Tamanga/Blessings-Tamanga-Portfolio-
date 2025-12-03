<?php
class Education {
    private $conn;
    private $table_name = "education";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY year_start DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $educations = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $educations[] = $row;
        }
        return $educations;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET degree_title=:degree_title, institution=:institution, 
                      year_start=:year_start, year_end=:year_end, description=:description,
                      image_path=:image_path, certificate_link=:certificate_link, institution_link=:institution_link";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":degree_title", $data['degree_title']);
        $stmt->bindParam(":institution", $data['institution']);
        $stmt->bindParam(":year_start", $data['year_start']);
        $stmt->bindParam(":year_end", $data['year_end']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image_path", $data['image_path']);
        $stmt->bindParam(":certificate_link", $data['certificate_link']);
        $stmt->bindParam(":institution_link", $data['institution_link']);
        
        return $stmt->execute();
    }

    public function delete($education_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE education_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $education_id);
        return $stmt->execute();
    }

    public function getById($education_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE education_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $education_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function update($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                    degree_title=:degree_title, institution=:institution, 
                    year_start=:year_start, year_end=:year_end, description=:description,
                    image_path=:image_path, certificate_link=:certificate_link, institution_link=:institution_link
                  WHERE education_id=:education_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":degree_title", $data['degree_title']);
        $stmt->bindParam(":institution", $data['institution']);
        $stmt->bindParam(":year_start", $data['year_start']);
        $stmt->bindParam(":year_end", $data['year_end']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image_path", $data['image_path']);
        $stmt->bindParam(":certificate_link", $data['certificate_link']);
        $stmt->bindParam(":institution_link", $data['institution_link']);
        $stmt->bindParam(":education_id", $data['education_id']);
        
        return $stmt->execute();
    }
}
?>