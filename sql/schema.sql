-- Job Application System Database Schema
-- Database: job_application
-- Table: job_applications

CREATE DATABASE IF NOT EXISTS job_application;
USE job_application;

CREATE TABLE IF NOT EXISTS job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20),
    position_applied VARCHAR(100) NOT NULL,
    years_experience INT DEFAULT 0,
    skills TEXT,
    expected_salary DECIMAL(10,2),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
