
-- create the database for all tables of garage parrot
DROP DATABASE IF EXISTS garageparrot;
CREATE DATABASE garageparrot;

-- create table Employees 
DROP TABLE IF EXISTS employees;
CREATE TABLE IF NOT EXISTS employees (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lastname VARCHAR(25) NOT NULL, 
  name VARCHAR(25) NOT NULL, 
  email VARCHAR(255) NOT NULL, 
  password VARCHAR(255) NOT NULL, 
  role VARCHAR(20)
);

-- create table Cars 
DROP TABLE IF EXISTS cars;
-- create table Cars 
CREATE TABLE IF NOT EXISTS cars (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(6) NOT NULL,
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

-- create table Cars images
CREATE TABLE IF NOT EXISTS carimages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES cars(id)
);


-- create table Reviews 
DROP TABLE IF EXISTS reviews;
CREATE TABLE IF NOT EXISTS reviews (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  client VARCHAR(255) NOT NULL,
  comment text NOT NULL,
  note VARCHAR(1) NOT NULL
);

-- create table schedules 
DROP TABLE IF EXISTS schedules;
CREATE TABLE IF NOT EXISTS schedules (
   id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
   day VARCHAR(8) NOT NULL,
   morningOpen VARCHAR(5) NOT NULL,
   morningClose VARCHAR(5) NOT NULL,
   afternoonOpen VARCHAR(5) NOT NULL,
   afternoonClose VARCHAR(5) NOT NULL
);

-- create table services 
DROP TABLE IF EXISTS services;
CREATE TABLE IF NOT EXISTS services (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  service VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL
);

-- create admin count Vincent Parrot
INSERT INTO employees(lastname, name, email, password, role) VALUES ('Parrot', 'Vincent', 'vparrot@garageparrot.com', sha1("Azerty2023@"),'admin');


-- exemple create employee
INSERT INTO employees(lastname, name, email, password, role) VALUES ('Dupont', 'Shara', 'sara@sara.com', sha1("Azerty5555@"),'employee'),('Sharowski', 'Mickael', 'mi@cka.com', sha1("Azerty6666@"),'employee'),('Barre', 'Silvain', 'sil@vain.com', sha1("Azerty8888@"),'employee'),('Martin', 'Martin', 'mar@tin.com', sha1("Azerty4444@"),'employee'),('Robert', 'Hubert', 'ro@bert.com', sha1("Azerty3333@"),'employee'),('Dubois', 'Laura', 'lau@ra.com', sha1("Azerty2222@"),'employee'),('Moulin', 'Patricia', 'mou@lin.com', sha1("Azerty2121@"),'employee'),('Huet', 'Miriam', 'hu@et.com', sha1("Azerty9999@"),'employee'),('Leroy', 'Leo', 'le@roy.com', sha1("Azerty0000@"),'employee'),('Lambert', 'Pierre', 'lam@bert.com', sha1("Azerty2222@"),'employee'),('Barre', 'Thierry', 'bar@re.com', sha1("Azerty3333@"),'employee'),('Boucher', 'Christelle', 'bouc@cher.com', sha1("Azerty4444@"),'employee'),('Bonet', 'Fabienne', 'bo@net.com', sha1("Azerty5555@"),'employee'),('Klein', 'Adrian', 'kle@in.com', sha1("Azerty5555@"),'employee');


-- create schedules
INSERT INTO schedules(day, morningOpen, morningClose, afternoonOpen, afternoonClose) VALUES ("lundi","08:45","12:00", "14:00","18:00"),("mardi","08:45","12:00", "14:00","18:00"),("mercredi","08:45","12:00", "14:00","18:00"),("jeudi","08:45","12:00", "14:00","18:00"),("vendredi","08:45","12:00", "14:00","18:00"),("samedi","08:45","12:00", "00:00","00:00"),("dimanche","00:00","00:00", "00:00","00:00");

-- create services
INSERT INTO services(service, description, image) VALUES ('reparation de carrosserie','Notre equipe est especialisé depuis 2 ans dans la reparation de carrosserie','01-eletric.jpg'),('Motor','Notre equipe repare ou replace totalmente votre motor','02-engine_repair.jpg'),('batterie','On travail avec les meilleurs marques des batterie du marché','03-car_battery.jpg');

-- create reviews
INSERT INTO reviews(client, comment, note) VALUES ('Sarah Beline', "L'equipe du garage Parrot est vraiment professionnel. Ils ont rendu ma voiture dans la date et l'heure indiqué. Bravo",'4'),('Guillaume Dupont', "J'ai trouvé le service pas bon du tout. C'est l'arnaque total. A eviter vraiment.",'1'),('Jean-Claude', "J'ai ete reçu par Vincent lui même. Il ma proposé le service de changement de batterie avec un prix très abordable. Top M. Parrot.",'5'),('Mathilde Shawiski', "J'etait interesé par une voiture d'ocasion et ils mon proposé un garantie de 1 un. Très contente",'4'),('Sarah Laporte', 'Je suis très satisfaite du travail de reparation du motor de ma voiture.','4'),('Mark Huppert', "Malheuresement ma voiture a pris du retard à cause de la livraison de la clime de la voiture, mais apart ça, le service était empecable.",'5'),('Josephine', 'Je suis venu avec ma fille pour acheter une voiture pour son anniversaire, et elle est aux anges. Service excellent','5');

INSERT INTO cars(code, brand, model,year,price, kilometers,color,gearbox,number_doors,fuel,co,image) VALUES ('FRD23','Ford','Clio-5','2016','022345','23456','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD46','Peugeot','408','2020','014700','12345','rouge','manuel',2,'gazole',123,'car-card.png'),('FRD34','Citroen','Escort','2021','15800','019887','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD09','Ford','Kuga','2021','12890','034567','rouge','manuel',2,'essence',123,null),('FRD99','Ford','Clio-5','2015','33000','45999','rouge','manuel',2,'électrique',123,'car-card.png'),('FRD12','Ford','Ka','2017','9800','21789','rouge','manuel',2,'diesel',123,'car-card.png'),('FRD67','Ford','Fiesta','2012','12000','66999','rouge','manuel',2,'diesel',123,"car-card.png"),('FRD34','Toyota','Galaxy','2018','11560','56000','rouge','manuel',2,'gazole',123,'02-diesel.png'),('FRD22','Dacia','Duster','2021','34000','23456','rouge','manuel',2,'essence',123,"04-fiat.png"),('FRD02','Audi','Clio-5','2017','8700','45666','rouge','manuel',2,'électrique',123,'delorean.jpg');