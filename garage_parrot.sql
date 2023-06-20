DROP DATABASE garage_parrot;

DROP TABLE IF EXISTS Employees;

-- create the database for all tables of garage parrot
CREATE DATABASE garage_parrot;

-- create table Employees 
CREATE TABLE IF NOT EXISTS Employees (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lastname VARCHAR(50) NOT NULL, 
  name VARCHAR(50) NOT NULL, 
  email VARCHAR(250) NOT NULL, 
  password VARCHAR(60) NOT NULL, 
  role VARCHAR(10)
);


-- create table Cars 
CREATE TABLE IF NOT EXISTS Cars (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(10) NOT NULL,
  title VARCHAR(120) NOT NULL,
  brand VARCHAR(60) NOT NULL,
  model VARCHAR(60) NOT NULL,
  year YEAR NOT NULL,
  price float(10,2) NOT NULL,
  kilometers INT(10) NOT NULL,
  color VARCHAR(25) NOT NULL,
  gearbox VARCHAR(25) NOT NULL,
  number_doors int(2) NOT NULL,
  fuel VARCHAR(25) NOT NULL,
  image VARCHAR(25) NOT NULL
);


-- create table Reviews 
CREATE TABLE IF NOT EXISTS Reviews (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  client VARCHAR(255) NOT NULL,
  comment VARCHAR(300) NOT NULL,
  note VARCHAR(1) NOT NULL
);

-- create table schedules 
CREATE TABLE IF NOT EXISTS Schedules (
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   day VARCHAR(15) NOT NULL,
   morning_start VARCHAR(5) NOT NULL,
   morning_end VARCHAR(5) NOT NULL,
   afternoon_start VARCHAR(5) NOT NULL,
   afternoon_end VARCHAR(5) NOT NULL
);

-- create table services 
CREATE TABLE IF NOT EXISTS Services (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  service VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL
)

-- create admin count Vincent Parrot
INSERT INTO Employees(lastname, name, email, password, role) VALUES ('Parrot', 'Vincent', 'parrotvincent@garageparrot.com', 'Vincent2023','admin');