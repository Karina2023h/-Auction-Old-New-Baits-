-- Створення бази даних
CREATE DATABASE auction_baits;
USE auction_baits;

-- Таблиця користувачів
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблиця категорій лотів
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Таблиця лотів
CREATE TABLE lots (
    lot_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    start_price DECIMAL(10, 2),
    current_price DECIMAL(10, 2),
    end_time DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Таблиця ставок
CREATE TABLE bids (
    bid_id INT AUTO_INCREMENT PRIMARY KEY,
    lot_id INT,
    user_id INT,
    bid_amount DECIMAL(10, 2),
    bid_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lot_id) REFERENCES lots(lot_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
