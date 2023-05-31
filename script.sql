CREATE DATABASE IF NOT EXISTS depenses;

-- Create table suppliers
CREATE TABLE suppliers
(
  id BIGINT NOT NULL AUTO_INCREMENT, 
  supplier_code VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

-- Create table depenses
CREATE TABLE depenses
(
  id BIGINT NOT NULL AUTO_INCREMENT, 
  name VARCHAR(50) NOT NULL,
  supplier_id BIGINT NOT NULL,
  amount DECIMAL(6,2) NOT NULL,
  depense_date DATE NOT NULL,
  invoice VARCHAR(15) NOT NULL,
  nature VARCHAR(50) NOT NULL,
  type VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
) ENGINE = InnoDB;

-- Create table depense_details
CREATE TABLE depense_details
(
  id BIGINT NOT NULL AUTO_INCREMENT, 
  depense_id BIGINT NOT NULL,
  amount VARCHAR(50) NOT NULL,
  depense_detail_date DATE NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (depense_id) REFERENCES depenses(id)
) ENGINE = InnoDB;