##################
# DATABASE SETUP #
##################

# Create the database
CREATE DATABASE IF NOT EXISTS Vet;

# Creating tables for a Vet database and adding entries
CREATE TABLE IF NOT EXISTS Breeds(
	Breed_ID INT AUTO_INCREMENT NOT NULL,
	Breed_Name VARCHAR (255),
	PRIMARY KEY (Breed_ID)
);

CREATE TABLE IF NOT EXISTS Owners(
	Owner_ID INT AUTO_INCREMENT NOT NULL,
	First_Name VARCHAR(255) NOT NULL,
	Last_Name VARCHAR(255) NOT NULL,
	Phone CHAR(10),
	Email VARCHAR(255),
	PRIMARY KEY (Owner_ID)
);

# Creating login table
CREATE TABLE IF NOT EXISTS Login(
	Login_ID INT AUTO_INCREMENT NOT NULL,
	Username VARCHAR(50),
	Pass VARCHAR(50),
	Owner_ID INT,
	PRIMARY KEY (Login_ID),
	FOREIGN KEY (Owner_ID) REFERENCES Owners(Owner_ID) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Pets(
	Pet_ID INT AUTO_INCREMENT NOT NULL,
	Owner_ID INT DEFAULT 999,
	Name VARCHAR(255) NOT NULL,
	Breed_ID INT,
	Age INT,
	Gender CHAR(1),
	Owner VARCHAR(255),
	PRIMARY KEY (Pet_ID),
	FOREIGN KEY (Owner_ID) REFERENCES Owners(Owner_ID) ON DELETE SET NULL,
	FOREIGN KEY (Breed_ID) REFERENCES Breeds(Breed_ID) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Transactions(
	Transaction_ID INT AUTO_INCREMENT NOT NULL,
	Owner_ID INT,
	Amount INT,
	PRIMARY KEY (Transaction_ID),
	FOREIGN KEY (Owner_ID) REFERENCES Owners (Owner_ID) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Doctors(
	Doctor_ID INT AUTO_INCREMENT NOT NULL,
	First_Name VARCHAR(255) NOT NULL,
	Last_Name VARCHAR(255) NOT NULL,
	Phone CHAR(10),
	Email VARCHAR(100),
	PRIMARY KEY (Doctor_ID)
);

CREATE TABLE IF NOT EXISTS Medication(
	Medicine_ID INT AUTO_INCREMENT NOT NULL,
	Name VARCHAR(255) NOT NULL,
	Brand VARCHAR(255),
	Cost INT,
	PRIMARY KEY (Medicine_ID)
);
 
CREATE TABLE IF NOT EXISTS Reviews(
	Review_ID INT AUTO_INCREMENT NOT NULL,
	Name VARCHAR(255) NOT NULL,
	Date DATE,
	Rating INT,
	Review_Text VARCHAR(255),
	PRIMARY KEY (Review_ID)
);

CREATE TABLE IF NOT EXISTS Perscriptions(
	Perscrpition_ID INT AUTO_INCREMENT NOT NULL,
	Pet_ID INT,
	Medicine_ID INT,
	Doctor_ID INT,
	PRIMARY KEY (Perscrpition_ID),
	FOREIGN KEY (Pet_ID) REFERENCES Pets (Pet_ID) ON DELETE SET NULL,
	FOREIGN KEY (Medicine_ID) REFERENCES Medication (Medicine_ID) ON DELETE SET NULL,
	FOREIGN KEY (Doctor_ID) REFERENCES Doctors (Doctor_ID) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Appointments(
	Appointment_ID INT AUTO_INCREMENT NOT NULL,
	Pet_ID INT,
	Pet_Name VARCHAR(100),
	appt_date DATE,
	appt_time TIME,
	PRIMARY KEY (Appointment_ID),
	FOREIGN KEY (Pet_ID) REFERENCES Pets (Pet_ID) ON DELETE SET NULL,
	CONSTRAINT unique_appt UNIQUE (appt_date,appt_time),
	CHECK (appt_time > "06:00:00" AND appt_time < "17:00:00"),
	CHECK (appt_date > current_date)
);

##############################
# INSERTING DATA INTO TABLES #
##############################

# Breeds Table Data
INSERT INTO Breeds (Breed_Name)
VALUES
	# Dog Breeds
	("Goldern Retriever"),
	("German Shepard"),
	("Labrador Retriever"),
	("Bulldog"),
	("Pug"),
	("Dobermann"),
	("Shiba Inu"),
	("Bernese Mountain Dog"),
	("Border Collie"),
	# Cat Breeds
	("Persian"),
	("Maine Coon"),
	("Bengal"),
	("Scottish Fold"),
	("Norwegian Forest"),
	("Turkish Angora"),
	("Burmese"),
	("Ragamuffin");

# Owners Table Data
INSERT INTO Owners (First_Name, Last_Name, Phone, Email)
VALUES
	("Doctor", "Reed", 3126549988, "ReedRichards@vetcare.com"),
	("John", "Smith", 1233456789, "jsmith@gmail.com"),
	("Lisa", "Rowwing", 2324451234,"LRowwing@gmail.com"),
	("Rebecca", "Foster", 2123879367, "RebeccaFoster@cox.net"),
	("Vin", "Diesel", 7604442981, "VinnyD@hotmail.com"),
	("Megan", "Beauvais", 6199990022, "mbeauvais@cox.net"),
	("Marie", "Wirsing", 3439926743, "marmar@gmail.com"),
	("Rupert", "Greatthorp", 4987765422, "theGreat@GreatthorpInvestments.com"),
	("Harry", "Harrison", 8785693658, "HarryHarrison@gmail.com"),
	("Jen", "Rix", 6194765383, "jenlikesdogs@gmail.com"),
	("Max", "Verstop", 7892347561, "maxydrives@hotmail.com");

# Pets Table Data
INSERT INTO Pets (Name, Breed_ID, Age, Gender, Owner_ID)
VALUES
	("Nelson", 1, 4, "M", 3),
	("Peter", 16, 6, "M", 6),
	("JoAnne", 5, 1, "F", 11),
	("Gracie", 1, 1, "F", 2),
	("Theodore", 16, 4, "M", 5),
	("Mango", 14, 9, "F", 4),
	("Thurman", 4, 5, "M", 7),
	("Ginger", 3, 1, "F", 8),
	("Murphy", 12, 7, "M", 9),
	("Arnold", 17, 2, "M", 3); #10


# Transactions Table Data
INSERT INTO Transactions(Owner_ID, Amount)
VALUES
	(11, 44),
	(11, 245),
	(2, 12),
	(2, 53),
	(2, 62),
	(3, 17),
	(4, 75),
	(4, 90),
	(5, 429),
	(6, 79),
	(6, 93),
	(7, 547),
	(7, 55),
	(7, 13),
	(8, 1128),
	(8, 283),
	(9, 99),
	(9, 343),
	(9, 289),
	(10, 42),
	(10, 68),
	(10, 13);

# Medication Table Data
INSERT INTO Medication (Name, Brand, Cost)
VALUES
	("Rimadyl", "Johnson & Johnson", 44),
	("Diazepam", "Drug Bros", 50),
	("Prozinc", "Weight Weenies", 23),
	("Vetsulin", "Drug Bros", 49),
	("Acepromazine", "Johnson & Johnson", 45),
	("Clomicalm", "Healthy Pet", 40),
	("Trifexis", "Healthy Pet", 39),
	("EasySpot", "Johnson & Johnson", 15),
	("Frontline Plus for Cats", "Johnson & Johnson", 30),
	("Frontline Plus for Dogs", "Johnson & Johnson", 30),
	("Primidone", "Healthy Pet", 50); #10

# Dotors Table Data
INSERT INTO Doctors (First_Name, Last_Name, Phone, Email)
VALUES
	("Richard", "Reed", 3126549988, "ReedRichards@vetcare.com"),
	("Laura", "Reed", 3126549989, "LauraReed@vetcare.com");


# Persciptions Table Data
INSERT INTO Perscriptions (Pet_ID, Medicine_ID, Doctor_ID)
VALUES
	(1, 1, 1),
	(2, 1, 1),
	(2, 3, 1),
	(3, 4, 2),
	(6, 3, 2),
	(8, 2, 2),
	(10, 6, 2),
	(5, 5, 1),
	(5, 4, 1); #9

# Appointments Table Data
INSERT INTO Appointments (Pet_ID, Pet_Name, appt_date, appt_time)
VALUES
	(1, "Nelson", "2022-2-13", "8:00"),
	(2, "Peter","2021-12-26", "9:00"),
	(3, "JoAnne", "2021-12-28", "10:00"),
	(4,"Gracie" ,"2021-12-27", "11:30"),
	(5, "Theodore","2022-1-20", "13:15"),
	(6, "Mango","2021-12-31", "16:45");

# Reviews table data
INSERT INTO Reviews (Name, Date, Rating, Review_Text)
VALUES
	("John", "2021-12-9", 5,"This vet is great!"),
	("Lisa", "2021-12-10", 5,"Very kind staff here."),
	("Rebecca", "2021-11-13", 4,"The did great, but forgot to give me my meds..."),
	("Vin", "2021-10-29", 1,"They lost my dog"),
	("John", "2021-10-9", 5,"They always treat my dog like it't their own."),
	("Megan", "2021-9-9", 3,"Decent service but very high rates!"),
	("Marie", "2021-10-17", 5,"My dog was having issues with its stomach and they were able to diagnose the problem quickly.");

# login table data
INSERT INTO Login (Username, Pass, Owner_ID)
VALUES
	("admin", "admin321", 1), # NOTE: This is for the doctors to log in
	("JSmith", "password", 2),
	("LisaRow", "RowYourBoat1", 3),
	("RebFoster", "PaSSw0rD", 4),
	("VDiesel", "FastnFurious2000", 5),
	("MBeauvais", "passpass", 6),
	("MarieWirsing", "gigithedog", 7),
	("RGreat", "GreatPass01", 8),
	("HarryH", "HarryPotterFan1", 9),
	("JenR", "SecretP4ss", 10),
	("MaxxV", "D1veF4st", 11);