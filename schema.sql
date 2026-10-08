-- =========================================================
-- Attendance Management System - Database Schema
-- Author : Neel Dube (240503020016)
-- =========================================================

CREATE DATABASE IF NOT EXISTS attendance_db;
USE attendance_db;

-- ---------------------------------------------------------
-- Table: students
-- Stores basic details of every enrolled student
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    student_id   INT AUTO_INCREMENT PRIMARY KEY,
    roll_no      VARCHAR(20)  NOT NULL UNIQUE,
    full_name    VARCHAR(100) NOT NULL,
    class_name   VARCHAR(50)  NOT NULL,
    email        VARCHAR(100),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Table: attendance
-- Stores one row per student per date with status
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id    INT NOT NULL,
    date_marked   DATE NOT NULL,
    status        ENUM('Present', 'Absent') NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    UNIQUE KEY unique_attendance (student_id, date_marked)
);

-- Sample seed data (optional, for testing)
INSERT INTO students (roll_no, full_name, class_name, email) VALUES
('A1-01', 'Aarav Shah',   'BCA Cybersecurity A1', 'aarav@example.com'),
('A1-02', 'Neel Dube',    'BCA Cybersecurity A1', 'neel@example.com'),
('A1-03', 'Priya Mehta',  'BCA Cybersecurity A1', 'priya@example.com');
