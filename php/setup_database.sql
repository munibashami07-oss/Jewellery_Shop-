-- Create database
CREATE DATABASE IF NOT EXISTS student_login_system;
USE student_login_system;

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    roll_number INT NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL,
    cnic VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    login_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add indexes for faster lookups
CREATE INDEX idx_roll_number ON students(roll_number);
CREATE INDEX idx_login_id ON students(login_id);
CREATE INDEX idx_email ON students(email);
