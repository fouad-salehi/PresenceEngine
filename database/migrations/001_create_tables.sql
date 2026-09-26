CREATE DATABASE IF NOT EXISTS presence_engine
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE presence_engine;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    section VARCHAR(50) NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE presence_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    section VARCHAR(50) NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME NULL,
    is_online TINYINT(1) DEFAULT 1,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_online (is_online),
    INDEX idx_user_time (user_id, login_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;