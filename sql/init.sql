
CREATE DATABASE IF NOT EXISTS cloud_inventory;
USE cloud_inventory;

-- Create table products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    ref VARCHAR(50) UNIQUE NOT NULL, -- Reference (Bar-code)
    description TEXT,
    quantity INT DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert a couple of products
INSERT INTO products (name, ref, description, quantity, price) VALUES 
('Air Heater', '50383', 'Stay warm with the air heater, available at the best price in our stores.', 55, 15.00),
('Halogen Heater With Hanger', '43138', 'Enjoy a warm and comfortable environment with this halogen heater with handle, designed to provide efficient and safe heat in any room of your home.', 150, 20.00);
