<?php
class Project {
    private $conn;
    private $table = 'projects';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all projects
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY 
                  FIELD(status, 'completed', 'in_progress', 'planned', 'on_hold'),
                  created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get projects by status
    public function getByStatus($status) {
        $query = "SELECT * FROM {$this->table} WHERE status = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();
        return $stmt;
    }

    // Get featured projects
    public function getFeatured() {
        $query = "SELECT * FROM {$this->table} WHERE featured = TRUE ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single project
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Create project
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  SET title = :title, description = :description, short_description = :short_description,
                      category = :category, status = :status, image_url = :image_url,
                      project_url = :project_url, github_url = :github_url, technologies = :technologies,
                      featured = :featured, start_date = :start_date, end_date = :end_date";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':project_url', $data['project_url']);
        $stmt->bindParam(':github_url', $data['github_url']);
        $stmt->bindParam(':technologies', $data['technologies']);
        $stmt->bindParam(':featured', $data['featured']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);

        return $stmt->execute();
    }

    // Update project
    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET title = :title, description = :description, short_description = :short_description,
                      category = :category, status = :status, image_url = :image_url,
                      project_url = :project_url, github_url = :github_url, technologies = :technologies,
                      featured = :featured, start_date = :start_date, end_date = :end_date,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':project_url', $data['project_url']);
        $stmt->bindParam(':github_url', $data['github_url']);
        $stmt->bindParam(':technologies', $data['technologies']);
        $stmt->bindParam(':featured', $data['featured']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);

        return $stmt->execute();
    }

    // Delete project
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // Get project count by status
    public function getCountByStatus() {
        $query = "SELECT status, COUNT(*) as count FROM {$this->table} GROUP BY status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>