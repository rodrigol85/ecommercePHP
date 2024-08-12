CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- Creazione della tabella degli admins
CREATE TABLE `admins` (
  `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `confirm_code` VARCHAR(255)
);


-- Creazione della tabella degli indirizzi

CREATE TABLE `addresses` (
  `address_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  `street` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `cap` VARCHAR(10) NOT NULL
  
);

-- Creazione della tabella degli utenti 
CREATE TABLE `users` (
  `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `confirm_code` VARCHAR(255),
  `address_id` BIGINT(20) NOT NULL,	
  FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE CASCADE
);

-- tabella categorie
CREATE TABLE `category` (
  `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `name` VARCHAR(255) NOT NULL
);

-- Creazione della tabella 'products'  
CREATE TABLE `products` (
  `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `category_id` BIGINT NOT NULL,  
  FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
);



-- Tabella carrelli
CREATE TABLE `charts` (
  `id_chart` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `state` VARCHAR(15) NOT NULL
);

-- Tabella dettagli_carrelli
CREATE TABLE `chart_items` (
    `id_chart_item` INT PRIMARY KEY AUTO_INCREMENT,
    `chart_id` INT NOT NULL,
    `product_id` BIGINT NOT NULL,
    `quantity` INT NOT NULL,
    `unit_price` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`chart_id`) REFERENCES `charts` (`id_chart`),
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
);

-- Tabella ordini
CREATE TABLE `orders` (
  `id_order` INT PRIMARY KEY AUTO_INCREMENT,
  `chart_id` INT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `order_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `order_state` VARCHAR(256),
  `total` DECIMAL(10,2),
  FOREIGN KEY (`chart_id`) REFERENCES `charts` (`id_chart`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
