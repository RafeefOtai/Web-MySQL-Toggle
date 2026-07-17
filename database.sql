-- Run this in phpMyAdmin (SQL tab) or via MySQL CLI
-- Safe to run again: it drops the old table first, then rebuilds it.

CREATE DATABASE IF NOT EXISTS task2_db;
USE task2_db;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 0
);

-- Sample roster
INSERT INTO users (name, age, status) VALUES
('Rafeef', 21, 0),
('Sarah', 32, 1),
('Norah', 22, 0),
('Layan', 27, 1),
('Raneem', 34, 0),
('Haya', 20, 1),
('Lujain', 29, 0),
('Fai', 24, 1);
