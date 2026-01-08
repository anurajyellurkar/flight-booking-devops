
CREATE DATABASE IF NOT EXISTS flight_booking;
USE flight_booking;
DROP TABLE IF EXISTS passengers; DROP TABLE IF EXISTS bookings; DROP TABLE IF EXISTS flights; DROP TABLE IF EXISTS users;

CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(80),email VARCHAR(120) UNIQUE,password VARCHAR(255),role ENUM('user','admin') DEFAULT 'user');

CREATE TABLE flights(
 id INT AUTO_INCREMENT PRIMARY KEY,
 flight_no VARCHAR(40),
 origin VARCHAR(80),
 destination VARCHAR(80),
 depart_time DATETIME,
 arrive_time DATETIME,
 price_economy DECIMAL(10,2),
 price_business DECIMAL(10,2),
 total_seats INT DEFAULT 30);

CREATE TABLE bookings(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT, flight_id INT,
 class_type ENUM('ECONOMY','BUSINESS'),
 total_price DECIMAL(10,2),
 ticket_no VARCHAR(40),
 status ENUM('CONFIRMED','CANCELLED') DEFAULT 'CONFIRMED',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE passengers(
 id INT AUTO_INCREMENT PRIMARY KEY,
 booking_id INT,
 name VARCHAR(80),
 age INT, gender VARCHAR(10), seat_no VARCHAR(10));

INSERT INTO users(name,email,password,role) VALUES('Admin','admin@example.com',MD5('admin123'),'admin');
