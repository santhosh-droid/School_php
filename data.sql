-- Create database
CREATE DATABASE IF NOT EXISTS student_management;

-- Use the database
USE student_management;

-- Create table for storing student data
CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    address TEXT,
    class_id INT,
    image VARCHAR(255),
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE SET NULL
);

-- Create table for storing class data
CREATE TABLE IF NOT EXISTS classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Insert some sample data into classes table
INSERT INTO classes (name) VALUES 
('Class 1'),
('Class 2'),
('Class 3');

-- You can add more classes as needed
