DROP DATABASE garageparrot;

DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS schedules;
DROP TABLE IF EXISTS reviews;

-- create the database for all tables of garage parrot
CREATE DATABASE garageparrot;

-- create table Employees 
CREATE TABLE IF NOT EXISTS employees (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lastname VARCHAR(25) NOT NULL, 
  name VARCHAR(25) NOT NULL, 
  email VARCHAR(255) NOT NULL, 
  password VARCHAR(255) NOT NULL, 
  role VARCHAR(20)
);


-- create table Cars 
CREATE TABLE IF NOT EXISTS cars (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(5) NOT NULL,
  brand VARCHAR(60) NOT NULL,
  model VARCHAR(60) NOT NULL,
  year int NOT NULL,
  price float(10,2) NOT NULL,
  kilometers INT(10) NOT NULL,
  color VARCHAR(25) NOT NULL,
  gearbox VARCHAR(15) NOT NULL,
  number_doors int(2) NOT NULL,
  fuel VARCHAR(25) NOT NULL,
  co int(5) NOT NULL,
  image VARCHAR(255) NOT NULL
);


-- create table Reviews 
CREATE TABLE IF NOT EXISTS reviews (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  client VARCHAR(255) NOT NULL,
  comment text NOT NULL,
  note VARCHAR(1) NOT NULL
);

-- create table schedules 
CREATE TABLE IF NOT EXISTS schedules (
   id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
   day VARCHAR(8) NOT NULL,
   morningOpen VARCHAR(5) NOT NULL,
   morningClose VARCHAR(5) NOT NULL,
   afternoonOpen VARCHAR(5) NOT NULL,
   afternoonClose VARCHAR(5) NOT NULL
);

-- create table services 
CREATE TABLE IF NOT EXISTS services (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  service VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL
);

-- create admin count Vincent Parrot
INSERT INTO employees(lastname, name, email, password, role) VALUES ('Parrot', 'Vincent', 'vparrot@garageparrot.com', sha1("Qwerty2023@"),'admin');




-- exemple create employee
INSERT INTO employees(lastname, name, email, password, role) VALUES ('Dupont', 'Shara', 'sara@sara.com', sha1("234567"),'employee'),('Sharowski', 'Mickael', 'mi@cka.com', sha1("45678"),'employee'),('Barre', 'Silvain', 'sil@vain.com', sha1("111111"),'employee'),('Martin', 'Martin', 'mar@tin.com', sha1("333333"),'employee'),('Robert', 'Hubert', 'ro@bert.com', sha1("444444"),'employee'),('Dubois', 'Laura', 'lau@ra.com', sha1("555555"),'employee'),('Moulin', 'Patricia', 'mou@lin.com', sha1("666666"),'employee'),('Huet', 'Miriam', 'hu@et.com', sha1("777777"),'employee'),('Leroy', 'Leo', 'le@roy.com', sha1("345623"),'employee'),('Lambert', 'Pierre', 'lam@bert.com', sha1("909090"),'employee'),('Barre', 'Thierry', 'bar@re.com', sha1("232323"),'employee'),('Boucher', 'Christelle', 'bouc@cher.com', sha1("565656"),'employee'),('Bonet', 'Fabienne', 'bo@net.com', sha1("121212"),'employee'),('Klein', 'Adrian', 'kle@in.com', sha1("343434"),'employee'),('Leo', 'Leo', 'leo@leo.com', sha1("Qwerty2023@"),'employee'),('Klein', 'Adrian', 'kle@in.com', sha1("343434"),'employee');


-- create schedules
INSERT INTO schedules(day, morningOpen, morningClose, afternoonOpen, afternoonClose) VALUES ("lundi","08:45","12:00", "14:00","18:00"),("mardi","08:45","12:00", "14:00","18:00"),("mercredi","08:45","12:00", "14:00","18:00"),("jeudi","08:45","12:00", "14:00","18:00"),("vendredi","08:45","12:00", "14:00","18:00"),("samedi","08:45","12:00", "00:00","00:00"),("dimanche","00:00","00:00", "00:00","00:00");

-- create services
INSERT INTO services(service, description, image) VALUES ('eletric','Magnis risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque','01-eletric.jpg'),('Motor','Risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque','02-engine_repair.jpg'),('batterie','Tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque',null);

-- create reviews
INSERT INTO reviews(client, comment, note) VALUES ('John McCoy', 'Nulla tristique ipsum ac tortor id lacus lorem suspendisse eget urna magna scelerisque proin hendrerit euismod erat bibendum consectetur ut ac ac maecenas quis quisque.','4'),('Shara Dupont', 'Lorem suspendisse eget urna magna scelerisque proin hendrerit euismod erat bibendum consectetur ut ac ac maecenas quis quisque.','5'),('Jean-Claude', 'Purus nisl dolor et vivamus enim euismod a purus commodo quisque sem sit ex gravida vivamus phasellus bibendum sollicitudin portaest enim tempus et nisi interdum.','3'),('Mathilde Shawiski', 'Vel fusce erat quisque erat eu varius bibendum euismod consectetur orci cursus ut diam eros tortor tincidunt placerat tincidunt aliquam facilisis id sit lorem quisque.','2'),('Sarah Laporte', 'Sollicitudin ex placerat ut id nunc fusce arcu condimentum elementum arcu eros sollicitudin leo leo eget suspendisse eget diam maecenas leo purus cursus proin ac.','4'),('Mark Huppert', 'Sollicitudin ac consectetur tempus molestie consectetur eu quam massa diam cursus leo amet lacus gravida lorem sit nunc varius id consectetur rutrum maximus maximus molestie.','5'),('Josephine', 'Portaest varius orci vel euismod et placerat portaest quis elementum leo rutrum ipsum mi interdum lorem sollicitudin ipsum suspendisse vivamus elementum commodo tincidunt fusce erat.','5');

INSERT INTO cars(code, brand, model,year,price, kilometers,color,gearbox,number_doors,fuel,co,image) VALUES ('FRD23','Ford','Clio-5','2016','12678','56980','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD46','Ford','Clio-5','2020','8700','12345','rouge','manuel',2,'gazole',123,'car-card.png'),('FRD34','Ford','Escort','2021','8700','3999','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD09','Ford','Kuga','2020','8700','12345','rouge','manuel',2,'essence',123,null),('FRD99','Ford','Clio-5','2015','12700','76544','rouge','manuel',2,'électrique',123,'car-card.png'),('FRD12','Ford','Clio-5','2020','12700','67666','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD67','Ford','Clio-5','2020','8700','87998','rouge','manuel',2,'diesel',123,"car-card.png"),('FRD34','Ford','Galaxy','2020','7665','34890','rouge','manuel',2,'gazole',123,'car-card.png'),('FRD22','Ford','Clio-5','2020','34000','8977','rouge','manuel',2,'essence',123,null),('FRD02','Ford','Clio-5','2020','8700','22256','rouge','manuel',2,'électrique',123,'car-card.png');