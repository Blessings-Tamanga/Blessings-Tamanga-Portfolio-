<?php
class Business {
    private $conn;
    private $table = 'businesses';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all businesses
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY 
                  FIELD(status, 'active', 'planned', 'inactive'),
                  created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get businesses by status
    public function getByStatus($status) {
        $query = "SELECT * FROM {$this->table} WHERE status = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();
        return $stmt;
    }

    // Get featured businesses
    public function getFeatured() {
        $query = "SELECT * FROM {$this->table} WHERE featured = TRUE ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single business
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

    // Create business
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  SET name = :name, description = :description, short_description = :short_description,
                      category = :category, logo_url = :logo_url, website_url = :website_url,
                      contact_email = :contact_email, status = :status, learn_more_url = :learn_more_url,
                      featured = :featured";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':logo_url', $data['logo_url']);
        $stmt->bindParam(':website_url', $data['website_url']);
        $stmt->bindParam(':contact_email', $data['contact_email']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':learn_more_url', $data['learn_more_url']);
        $stmt->bindParam(':featured', $data['featured']);

        return $stmt->execute();
    }

    // Update business
    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET name = :name, description = :description, short_description = :short_description,
                      category = :category, logo_url = :logo_url, website_url = :website_url,
                      contact_email = :contact_email, status = :status, learn_more_url = :learn_more_url,
                      featured = :featured, updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':logo_url', $data['logo_url']);
        $stmt->bindParam(':website_url', $data['website_url']);
        $stmt->bindParam(':contact_email', $data['contact_email']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':learn_more_url', $data['learn_more_url']);
        $stmt->bindParam(':featured', $data['featured']);

        return $stmt->execute();
    }

    // Delete business
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // Get business count by status
    public function getCountByStatus() {
        $query = "SELECT status, COUNT(*) as count FROM {$this->table} GROUP BY status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>