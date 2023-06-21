DROP DATABASE garage_parrot;

DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS services;

-- create the database for all tables of garage parrot
CREATE DATABASE garage_parrot;

-- create table Employees 
CREATE TABLE IF NOT EXISTS employees (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lastname VARCHAR(50) NOT NULL, 
  name VARCHAR(50) NOT NULL, 
  email VARCHAR(250) NOT NULL, 
  password VARCHAR(60) NOT NULL, 
  role VARCHAR(10)
);


-- create table Cars 
CREATE TABLE IF NOT EXISTS cars (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(10) NOT NULL,
  brand VARCHAR(60) NOT NULL,
  model VARCHAR(60) NOT NULL,
  year YEAR NOT NULL,
  price float(10,2) NOT NULL,
  kilometers INT(10) NOT NULL,
  color VARCHAR(25) NOT NULL,
  gearbox VARCHAR(25) NOT NULL,
  number_doors int(2) NOT NULL,
  fuel VARCHAR(25) NOT NULL,
  co int(5) NOT NULL,
  image VARCHAR(25) NOT NULL
);


-- create table Reviews 
CREATE TABLE IF NOT EXISTS reviews (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  client VARCHAR(255) NOT NULL,
  comment VARCHAR(300) NOT NULL,
  note VARCHAR(1) NOT NULL
);

-- create table schedules 
CREATE TABLE IF NOT EXISTS schedules (
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   day VARCHAR(15) NOT NULL,
   morning_start VARCHAR(5) NOT NULL,
   morning_end VARCHAR(5) NOT NULL,
   afternoon_start VARCHAR(5) NOT NULL,
   afternoon_end VARCHAR(5) NOT NULL
);

-- create table services 
CREATE TABLE IF NOT EXISTS services (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  service VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(25) NOT NULL
)

-- create admin count Vincent Parrot
INSERT INTO employees(lastname, name, email, password, role) VALUES ('Parrot', 'Vincent', 'parrotvincent@garageparrot.com', 'Vincent2023','admin');



-- create cars
INSERT INTO cars(code, brand, model, year, price, kilometers, color, gearbox, number_doors, fuel, co, image) VALUES ('fad22','Fiat', 'Uno 5', 2013, 8700, 23375, 'rouge', 'manuelle', 4, 'gazole',123, 'car-card.png'),('ren33','Renault', 'Clio 5', 2017, 34765,8456, 'noir', 'manuel', 4, 'gazole',92, 'car-card.png'),('for23','Ford', 'Escort', 2001, 67897,2656, 'rouge', 'manuel', 2, 'diesel',120, null);

-- create services
INSERT INTO services(service, description, image) VALUES ('eletric','Magnis risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque','01-eletric.jpg'),('Motor','Risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque','02-engine_repair.jpg'),('batterie','Tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque',null);
