-- MySQL SQL Project
CREATE DATABASE school_db;
USE school_db;

CREATE TABLE auth_user (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE teachers (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT NOT NULL UNIQUE,
  university_name VARCHAR(255) NOT NULL,
  gender ENUM('male','female','other') DEFAULT 'other',
  year_joined INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_teacher_user FOREIGN KEY (user_id) REFERENCES auth_user(id) ON DELETE CASCADE
);

INSERT INTO auth_user (email, first_name, last_name, password) 
VALUES 
('alice@example.com','Alice','Johnson','$2y$10$hashedpassword1'),
('bob@example.com','Bob','Smith','$2y$10$hashedpassword2');

INSERT INTO teachers (user_id, university_name, gender, year_joined)
VALUES
(1,'Harvard University','female',2018),
(2,'Stanford University','male',2020);
