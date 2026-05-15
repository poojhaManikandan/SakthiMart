-- ============================================================
-- SakthiMart — Add Users Table
-- Run this in phpMyAdmin on sakthimart_db:
--   Import this file OR paste in the SQL tab
-- ============================================================
USE sakthimart_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,        -- bcrypt hashed
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
