	CREATE DATABASE Filling_station_site;

	USE Filling_station_site;

	-- ==========================
	-- STATION TABLE
	-- ==========================
	CREATE TABLE station (
		station_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		station_name VARCHAR(255) NOT NULL,
		station_location VARCHAR(255) NOT NULL,
		station_description TEXT NOT NULL
	);

	-- ==========================
	-- USER TABLE
	-- ==========================
	CREATE TABLE user (
		user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_name VARCHAR(255) NOT NULL,
		user_email VARCHAR(255) NOT NULL UNIQUE,
		user_position VARCHAR(255) NOT NULL,
		user_password VARCHAR(255) NOT NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);

	-- ==========================
	-- CASHIER TABLE
	-- ==========================
	CREATE TABLE cashier (
		cashier_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		cashier_name VARCHAR(255) NOT NULL,
		cashier_email VARCHAR(255) NOT NULL UNIQUE,
		user_id INT NOT NULL,
		station_id INT NOT NULL,
		FOREIGN KEY (user_id) REFERENCES user(user_id)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- ACCOUNTANT TABLE
	-- ==========================
	CREATE TABLE accountant (
		accountant_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		accountant_name VARCHAR(255) NOT NULL,
		accountant_email VARCHAR(255) NOT NULL UNIQUE,
		user_id INT NOT NULL,
		station_id INT NOT NULL,
		FOREIGN KEY (user_id) REFERENCES user(user_id)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- MANAGER TABLE
	-- ==========================
	CREATE TABLE manager (
		manager_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		manager_name VARCHAR(255) NOT NULL,
		manager_email VARCHAR(255) NOT NULL UNIQUE,
		user_id INT NOT NULL,
		station_id INT NOT NULL,
		FOREIGN KEY (user_id) REFERENCES user(user_id)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- STOCK CONTROL TABLE
	-- ==========================
	CREATE TABLE stock_control (
		metre_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		metre_reading INT NOT NULL,
		metre_receipt TEXT NOT NULL,
		metre_sale DECIMAL(10,2) NOT NULL,
		approved_by INT NOT NULL,
		station_id INT NOT NULL,
		FOREIGN KEY (approved_by) REFERENCES user(user_id)
			ON DELETE SET NULL ON UPDATE CASCADE,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- EXPENSES TABLE
	-- ==========================
	CREATE TABLE expenses (
		expense_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		expense_amount DECIMAL(10,2) NOT NULL,
		expense_description TEXT NOT NULL,
		approved_by INT NOT NULL,
		expense_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		station_id INT NOT NULL,
		FOREIGN KEY (approved_by) REFERENCES user(user_id)
			ON DELETE SET NULL ON UPDATE CASCADE,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- DAILY DATA TABLE
	-- ==========================
	CREATE TABLE moffart_daily_data (
		daily_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		dates DATE NOT NULL,
		daily_total_amount DECIMAL(10,2) NOT NULL,
		daily_expenses DECIMAL(10,2) NOT NULL,
		daily_description TEXT,
		station_id INT NOT NULL,
		FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

	-- ==========================
	-- MONTHLY DATA TABLE
	-- ==========================
	CREATE TABLE moffart_monthly_data (
		month_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		month_name VARCHAR(50) NOT NULL,
		total_amount DECIMAL(10,2) NOT NULL,
		total_expenses DECIMAL(10,2) NOT NULL,
		 station_id INT NOT NULL,
		 FOREIGN KEY (station_id) REFERENCES station(station_id)
			ON DELETE CASCADE ON UPDATE CASCADE
	);

