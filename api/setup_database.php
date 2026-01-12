<?php
// Run this file once to set up the database

$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS portfolio_db";
    $conn->exec($sql);
    echo "Database created successfully<br>";
    
    // Use database
    $conn->exec("USE portfolio_db");
    
    // Create tables
    $tables = [
        "CREATE TABLE IF NOT EXISTS admin_users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS personal_info (
            id INT PRIMARY KEY AUTO_INCREMENT,
            full_name VARCHAR(100) NOT NULL,
            title VARCHAR(100) NOT NULL,
            bio TEXT,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            city VARCHAR(50),
            profile_image VARCHAR(255),
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS education (
            education_id INT PRIMARY KEY AUTO_INCREMENT,
            degree_title VARCHAR(200) NOT NULL,
            institution VARCHAR(200) NOT NULL,
            year_start INT NOT NULL,
            year_end INT,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS skills (
            skill_id INT PRIMARY KEY AUTO_INCREMENT,
            skill_name VARCHAR(100) NOT NULL,
            category ENUM('Technical', 'Creative', 'Personal') NOT NULL,
            level INT NOT NULL,
            description TEXT,
            icon VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS hobbies (
            hobby_id INT PRIMARY KEY AUTO_INCREMENT,
            hobby_name VARCHAR(100) NOT NULL,
            description TEXT,
            image_path VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS dashboard_stats (
            stat_id INT PRIMARY KEY AUTO_INCREMENT,
            profile_views INT DEFAULT 0,
            completed_projects INT DEFAULT 0,
            pending_messages INT DEFAULT 0,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )"
    ];
    
    foreach ($tables as $table) {
        $conn->exec($table);
        echo "Table created successfully<br>";
    }
    
    // Insert default data
    $defaultData = [
        "INSERT IGNORE INTO admin_users (username, password, full_name, email) 
         VALUES ('admin', 'admin123', 'Blessings E. Tamanga', 'admin@portfolio.com')",
        
        "INSERT IGNORE INTO personal_info (full_name, title, bio, email, phone, city) 
         VALUES ('Blessings Exton Tamanga', 'Software Engineer & Web Developer', 'I''m a software engineer and a web developer with a passion for creating intuitive and visually appealing web experiences. With a background in Business Information technology, I bridge the gap between technical functionality and user-centered design.', 'blessings.tamanga@example.com', '+265 991 234 567', 'Lilongwe, Malawi')",
        
        "INSERT IGNORE INTO dashboard_stats (profile_views, completed_projects, pending_messages) 
         VALUES (1250, 15, 3)",
        
        "INSERT IGNORE INTO education (degree_title, institution, year_start, year_end, description) VALUES
         ('Business Information technology (Hons)', 'Greenwich University - NACIT Lilongwe Campus', 2018, 2020, 'Specialized in Human-Computer Interaction and Web Technologies. Completed thesis on \"Improving Web Accessibility for Visually Impaired Users\".'),
         ('Level-05 Advance Diploma in Computing', 'NCC Education - NACIT', 2014, 2018, 'Graduated with honors. Served as president of the Web Development Club and participated in multiple hackathons.'),
         ('Level-04 Diploma in Computing', 'NCC Education - NACIT', 2017, 2017, 'Intensive program focusing on modern web development technologies.'),
         ('Level-03 Diploma in Computing', 'NCC Education - NACIT', 2010, 2014, 'Graduated with high honors. Active in computer science club and yearbook committee.')",
        
        "INSERT IGNORE INTO skills (skill_name, category, level, description, icon) VALUES
         ('HTML/CSS', 'Technical', 95, 'Building responsive, modern, and user-friendly web layouts with clean code and best practices.', 'fas fa-code'),
         ('JavaScript', 'Technical', 90, 'Creating interactive interfaces, animations, and efficient front-end logic with modern JavaScript.', 'fab fa-js-square'),
         ('React', 'Technical', 85, 'Developing scalable and dynamic single-page applications with reusable components.', 'fab fa-react'),
         ('Node.js', 'Technical', 80, 'Building robust back-end services and REST APIs using Node.js and Express.js.', 'fab fa-node'),
         ('UI/UX Design', 'Creative', 88, 'Designing engaging, accessible, and user-centric interfaces using Figma and Adobe XD.', 'fas fa-pencil-ruler'),
         ('Communication', 'Personal', 90, 'Collaborating effectively with teams and clients, delivering clear and creative ideas.', 'fas fa-comments')",
        
        "INSERT IGNORE INTO hobbies (hobby_name, description, image_path) VALUES
         ('Hiking & Nature', 'I love exploring trails and capturing the beauty of nature through photography. It''s my way of disconnecting and finding inspiration.', 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'),
         ('Reading', 'From science fiction to biographies, I''m an avid reader. Currently enjoying \"The Three-Body Problem\" by Cixin Liu.', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'),
         ('Cooking', 'Experimenting with new recipes and cuisines is my creative outlet. I especially enjoy making homemade pasta and Asian dishes.', 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'),
         ('Gaming', 'I enjoy strategy games and RPGs that challenge problem-solving skills. It''s also a great way to connect with friends.', 'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')"
    ];
    
    foreach ($defaultData as $data) {
        $conn->exec($data);
        echo "Default data inserted successfully<br>";
    }
    
    echo "<h2>Database setup completed successfully!</h2>";
    echo "<p>You can now:</p>";
    echo "<ul>";
    echo "<li><a href='/api/index.php'>View Portfolio</a></li>";
    echo "<li><a href='/api/admin_login.php'>Login to Admin Dashboard</a> (Username: admin, Password: admin123)</li>";
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>