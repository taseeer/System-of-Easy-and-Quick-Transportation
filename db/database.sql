CREATE DATABASE bus_booking_system;
USE bus_booking_system;

-- Cities Table
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Bus Companies Table
CREATE TABLE bus_companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact_info VARCHAR(255)
);

-- Buses Table
CREATE TABLE buses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    bus_type VARCHAR(50),
    total_seats INT NOT NULL,
    company_id INT,
    FOREIGN KEY (company_id) REFERENCES bus_companies(id)
);

-- Routes Table
CREATE TABLE routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_city_id INT,
    to_city_id INT,
    distance INT,
    FOREIGN KEY (from_city_id) REFERENCES cities(id),
    FOREIGN KEY (to_city_id) REFERENCES cities(id)
);

-- Bus Stops Table
CREATE TABLE bus_stops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    route_id INT,
    city_id INT,
    arrival_time TIME,
    departure_time TIME,
    FOREIGN KEY (route_id) REFERENCES routes(id),
    FOREIGN KEY (city_id) REFERENCES cities(id)
);

-- Schedules Table
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_id INT,
    route_id INT,
    departure_time DATETIME,
    arrival_time DATETIME,
    ticket_price DECIMAL(10,2),
    FOREIGN KEY (bus_id) REFERENCES buses(id),
    FOREIGN KEY (route_id) REFERENCES routes(id)
);
