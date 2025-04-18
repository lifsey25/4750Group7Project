CREATE DATABASE IF NOT EXISTS easyship;
USE easyship;

CREATE TABLE Zipcode (
    zipcode INT PRIMARY KEY,
    city VARCHAR(100),
    state VARCHAR(100)
);

CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    address VARCHAR(255),
    zipcode INT,
    phone VARCHAR(20),
    password VARCHAR(255),
    FOREIGN KEY (zipcode) REFERENCES Zipcode(zipcode)
);

CREATE TABLE Shipper (
    shipper_id INT PRIMARY KEY AUTO_INCREMENT,
    shipper_name VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE Product (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    product_in_stock INT NOT NULL
);

CREATE TABLE Orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    shipper_id INT,
    order_date DATE,
    ship_date DATE,
    zipcode INT,
    status VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (shipper_id) REFERENCES Shipper(shipper_id),
    FOREIGN KEY (zipcode) REFERENCES Zipcode(zipcode)
);

CREATE TABLE OrderDetail (
    order_id INT,
    product_id INT,
    unit_price DECIMAL(10,2),
    quantity INT,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Product(product_id)
);