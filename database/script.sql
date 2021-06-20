
-- Created by Yassir JANAH

CREATE DATABASE IF NOT EXISTS JANAH_ECommerce;

use JANAH_ECommerce;

-- create categories table
CREATE TABLE Categories(
	id TEXT DEFAULT NULL,
	name TEXT DEFAULT NULL
);

-- create Panier table
CREATE TABLE Panier(
	ProductId VARCHAR(60) NOT NULL,
	UserId INT(11) NOT NULL,
	Qte INT(11) NOT NULL
);

-- create Products table
CREATE TABLE Products(
	sku VARCHAR(32) NOT NULL,
	name TEXT DEFAULT NULL,
	description TEXT DEFAULT NULL,
	price VARCHAR(60) DEFAULT NULL,
	image TEXT DEFAULT NULL,
	catId VARCHAR(32) DEFAULT NULL
);

-- create Users table
CREATE TABLE Users(
	id INT,
	fname TEXT NOT NULL,
	lname TEXT NOT NULL,
	email TEXT NOT NULL,
	password TEXT NOT NULL,
	Address TEXT
);

ALTER TABLE Users modify id INT AUTO_INCREMENT PRIMARY KEY;
