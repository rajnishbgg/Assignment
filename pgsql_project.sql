-- PostgreSQL SQL Project
CREATE DATABASE school_db;
\c school_db;

CREATE TABLE auth_user (
  id SERIAL PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE teachers (
  id SERIAL PRIMARY KEY,
  user_id INT UNIQUE NOT NULL,
  university_name VARCHAR(255) NOT NULL,
  gender VARCHAR(20) CHECK (gender IN ('male','female','other')) DEFAULT 'other',
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
