-- ============================================================
-- SakthiMart Database Schema
-- Import this file via phpMyAdmin or MySQL CLI:
--   mysql -u root -p < sakthimart.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS sakthimart_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sakthimart_db;

-- ============================================================
-- Table: products
-- ============================================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_url TEXT NOT NULL,
    rating DECIMAL(2, 1) NOT NULL DEFAULT 4.0,
    review_count INT NOT NULL DEFAULT 0,
    category VARCHAR(100) NOT NULL DEFAULT 'General',
    stock INT NOT NULL DEFAULT 100,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Table: contacts
-- ============================================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    order_id VARCHAR(50),
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Table: cart_sessions (optional persistent cart)
-- ============================================================
CREATE TABLE IF NOT EXISTS cart_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- Seed Data: Products
-- ============================================================
INSERT INTO products (name, price, image_url, rating, review_count, category) VALUES
(
    'Premium Wireless Over-Ear Headphones - Noise Cancelling',
    14999.00,
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop',
    4.0, 1240, 'Electronics'
),
(
    'Minimalist Analog Watch with Leather Strap',
    5999.00,
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2099&auto=format&fit=crop',
    5.0, 850, 'Fashion'
),
(
    'Vintage Film Camera - Special Edition',
    18500.00,
    'https://images.unsplash.com/photo-1526170315836-e520c15383d2?q=80&w=2070&auto=format&fit=crop',
    4.0, 450, 'Electronics'
),
(
    'Urban Sport Sneakers - Lightweight & Breathable',
    8999.00,
    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=2098&auto=format&fit=crop',
    4.0, 2100, 'Fashion'
),
(
    'Ultra Thin 10-inch Tablet - Pro Display',
    24999.00,
    'https://images.unsplash.com/photo-1542751110-97427bbecf20?q=80&w=2070&auto=format&fit=crop',
    5.0, 320, 'Electronics'
),
(
    'Smart Home Voice Assistant Speaker with Built-in Hub',
    4499.00,
    'https://images.unsplash.com/photo-1583394838336-acd977736f90?q=80&w=1968&auto=format&fit=crop',
    5.0, 950, 'Electronics'
),
(
    'Professional Creator Laptop 15.6" - 16GB RAM, 512GB SSD',
    74999.00,
    'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?q=80&w=2064&auto=format&fit=crop',
    4.0, 1020, 'Electronics'
),
(
    'Ergonomic Wireless Gaming Mouse 10000 DPI',
    1999.00,
    'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=2070&auto=format&fit=crop',
    4.0, 420, 'Electronics'
);
