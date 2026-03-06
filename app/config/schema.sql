-- DIUfind Master Schema
-- Database: diufind_db
-- Phase 2: Architecture & Schema Design

SET FOREIGN_KEY_CHECKS=0;

-- 1. Users Table
-- Supports Role-Based Access, Trust Score, Verification
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'faculty', 'admin', 'security') DEFAULT 'student',
    phone VARCHAR(20) DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT 'default_avatar.png',
    trust_score INT DEFAULT 100,
    is_verified BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'banned', 'locked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_trust (trust_score)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Categories Table
-- Standardized Item Types
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    icon_class VARCHAR(50) DEFAULT 'fa-box'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Locations Table
-- Context-Aware Campus Spots
DROP TABLE IF EXISTS locations;
CREATE TABLE locations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('Campus', 'Transport', 'Dormitory') DEFAULT 'Campus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Posts Table
-- Core Item Data with JSON Auto-Tags
DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    type ENUM('Lost', 'Found') NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    auto_tags JSON DEFAULT NULL, -- Stores ["#wallet", "#black"]
    date_time DATETIME NOT NULL,
    image_path VARCHAR(255),
    status ENUM('Open', 'Matched', 'Handover', 'Closed', 'Archived') DEFAULT 'Open',
    privacy_mode BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE RESTRICT,
    INDEX idx_search (title),
    INDEX idx_status (status),
    INDEX idx_date (date_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Claims Table
-- Smart Matching Logic
DROP TABLE IF EXISTS claims;
CREATE TABLE claims (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id BIGINT(20) UNSIGNED NOT NULL,
    claimant_id BIGINT(20) UNSIGNED NOT NULL,
    confidence_score FLOAT DEFAULT 0.0,
    security_answer TEXT,
    proof_image VARCHAR(255),
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (claimant_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Messages Table
-- Communication
DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_id BIGINT(20) UNSIGNED NOT NULL,
    receiver_id BIGINT(20) UNSIGNED NOT NULL,
    post_id BIGINT(20) UNSIGNED NOT NULL,
    message_text TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Notifications Table
DROP TABLE IF EXISTS notifications;
CREATE TABLE notifications (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    type ENUM('Alert', 'Claim', 'Badge', 'System') NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Badges Table
-- Gamification Definitions
DROP TABLE IF EXISTS badges;
CREATE TABLE badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    icon VARCHAR(50) NOT NULL,
    required_score INT NOT NULL,
    description VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. User Badges Pivot
DROP TABLE IF EXISTS user_badges;
CREATE TABLE user_badges (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    badge_id INT UNSIGNED NOT NULL,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_badge (user_id, badge_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Activity Logs Table
-- Security & Auditing
DROP TABLE IF EXISTS activity_logs;
CREATE TABLE activity_logs (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT(20) UNSIGNED NULL, -- Nullable for failed login attempts
    action VARCHAR(50) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Archived Posts
-- Clone of posts table for cleanup
DROP TABLE IF EXISTS archived_posts;
CREATE TABLE archived_posts LIKE posts;

SET FOREIGN_KEY_CHECKS=1;


-- DUMMY DATA SEEDING
-- Users
INSERT INTO users (name, email, password_hash, role, trust_score, is_verified) VALUES 
('Rahim Student', 'rahim@diu.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 120, 1),
('Ms. Fatema', 'fatema@diu.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'faculty', 500, 1);

-- Categories
INSERT INTO categories (name, icon_class) VALUES 
('Electronics', 'fa-laptop'),
('Documents', 'fa-id-card'),
('Accessories', 'fa-glasses');

-- Locations
INSERT INTO locations (name, type) VALUES 
('AB4 (Academic Building 4)', 'Campus'),
('Daffodil Bus (Mirpur Route)', 'Transport'),
('Food Court', 'Campus');

-- Badges
INSERT INTO badges (name, icon, required_score, description) VALUES
('Honest Finder', 'fa-medal', 10, 'Returned 1 confirmed item'),
('Campus Hero', 'fa-crown', 100, 'Returned 10 confirmed items');
