-- Ejecutar este archivo desde phpMyAdmin o la consola de MySQL.
CREATE DATABASE IF NOT EXISTS escuela CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE escuela;

CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    dni VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL
);

INSERT INTO estudiantes (nombre, apellido, dni, email) VALUES
('Juan', 'Pérez', '12345678', 'juan.perez@example.com'),
('María', 'Gómez', '87654321', 'maria.gomez@example.com'),
('Carlos', 'López', '11223344', 'carlos.lopez@example.com');
