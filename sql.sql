CREATE DATABASE portfolio_db;
USE portfolio_db;

-- Admin users table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Personal information table
CREATE TABLE personal_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    bio TEXT,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    city VARCHAR(50),
    profile_image VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



-- Education table
CREATE TABLE education (
    education_id INT PRIMARY KEY AUTO_INCREMENT,
    degree_title VARCHAR(200) NOT NULL,
    institution VARCHAR(200) NOT NULL,
    year_start INT NOT NULL,
    year_end INT,
    description TEXT,
    image_path VARCHAR(255),
    certificate_link VARCHAR(255),
    institution_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


-- Skills table
CREATE TABLE skills (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) NOT NULL,
    category ENUM('Technical', 'Creative', 'Personal') NOT NULL,
    level INT NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Hobbies table
CREATE TABLE hobbies (
    hobby_id INT PRIMARY KEY AUTO_INCREMENT,
    hobby_name VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Files table
CREATE TABLE files (
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Settings table
CREATE TABLE settings (
    setting_id INT PRIMARY KEY AUTO_INCREMENT,
    site_title VARCHAR(200) NOT NULL,
    site_description VARCHAR(300),
    contact_email VARCHAR(100),
    linkedin_url VARCHAR(255),
    github_url VARCHAR(255),
    twitter_url VARCHAR(255),
    instagram_url VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Dashboard stats table
CREATE TABLE dashboard_stats (
    stat_id INT PRIMARY KEY AUTO_INCREMENT,
    profile_views INT DEFAULT 0,
    completed_projects INT DEFAULT 0,
    pending_messages INT DEFAULT 0,
    online_users INT DEFAULT 0,
    total_visitors INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);








-- Messages table
CREATE TABLE IF NOT EXISTS messages (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    is_read TINYINT DEFAULT 0,
    replied TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Online users tracking table
CREATE TABLE IF NOT EXISTS online_users (
    session_id VARCHAR(128) PRIMARY KEY,
    ip_address VARCHAR(45),
    user_agent TEXT,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    page_views INT DEFAULT 1
);



-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password, full_name, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Blessings E. Tamanga', 'admin@portfolio.com');

-- Insert default personal info
INSERT INTO personal_info (full_name, title, bio, email, phone, city) 
VALUES ('Blessings Exton Tamanga', 'Software Engineer & Web Developer', 'I''m a software engineer and a web developer with a passion for creating intuitive and visually appealing web experiences. With a background in Business Information technology, I bridge the gap between technical functionality and user-centered design.', 'blessings.tamanga@example.com', '+265 991 234 567', 'Lilongwe, Malawi');

-- Insert default settings
INSERT INTO settings (site_title, site_description, contact_email, linkedin_url, github_url, twitter_url, instagram_url) 
VALUES ('Blessings E. Tamanga - Portfolio', 'Software Engineer & Web Developer', 'blessings.tamanga@example.com', 'https://linkedin.com/in/blessingstamanga', 'https://github.com/blessingstamanga', 'https://twitter.com/blessingstamanga', 'https://instagram.com/blessingstamanga');

-- Insert default dashboard stats
INSERT INTO	 dashboard_stats (profile_views, completed_projects, pending_messages) 
VALUES (1250, 15, 3);