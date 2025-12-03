<?php
class PersonalInfo {
    private $conn;
    private $table_name = "personal_info";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getInfo() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY updated_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function updateInfo($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                    full_name = :full_name,
                    title = :title,
                    bio = :bio,
                    email = :email,
                    phone = :phone,
                    city = :city,
                    profile_image = :profile_image,
                    updated_at = CURRENT_TIMESTAMP
                  WHERE id = 1";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":bio", $data['bio']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":city", $data['city']);
        $stmt->bindParam(":profile_image", $data['profile_image']);
        
        return $stmt->execute();
    }

    // NEW METHOD: Update only profile image
    public function updateProfileImage($image_path) {
        $query = "UPDATE " . $this->table_name . " SET 
                    profile_image = :profile_image,
                    updated_at = CURRENT_TIMESTAMP
                  WHERE id = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":profile_image", $image_path);
        return $stmt->execute();
    }
}
?>