DROP TABLE specimens;
DROP TABLE lookupFamily;
DROP TABLE lookupOrder;
DROP TABLE localityInfo;
DROP TABLE species;
DROP TABLE localities;
DROP TABLE waterBodies;
DROP TABLE orders;
DROP TABLE family;

CREATE TABLE species(
	SpeciesID int NOT NULL AUTO_INCREMENT,
	Species varchar(50) NOT NULL,
	PRIMARY KEY(SpeciesID)
);

CREATE TABLE localities(
	LocalityID int NOT NULL AUTO_INCREMENT,
	Locality varchar(50) NOT NULL,
	PRIMARY KEY(LocalityID)
);

CREATE TABLE waterBodies(
	WaterBodyID int NOT NULL AUTO_INCREMENT,
	WaterBody varchar(100) NOT NULL,
	PRIMARY KEY(WaterBodyID)
);

CREATE TABLE specimens(
	ITC int NOT NULL AUTO_INCREMENT,
	SpeciesID int NOT NULL,
	Quantity int NOT NULL,
	LocalityID int NOT NULL,
	WaterBodyID int NOT NULL,
	Year year(4) NOT NULL,
	Storage varchar(6) NOT NULL,
	Comment varchar(100),
	OrigNum varchar(25),
	PRIMARY KEY(ITC),
	FOREIGN KEY(SpeciesID) REFERENCES species(SpeciesID) ON DELETE RESTRICT,
	FOREIGN KEY(LocalityID) REFERENCES localities(LocalityID) ON DELETE RESTRICT,
	FOREIGN KEY(WaterBodyID) REFERENCES waterBodies(WaterBodyID) ON DELETE RESTRICT
);

CREATE TABLE orders(
	OrderID int NOT NULL AUTO_INCREMENT,
	Orders varchar(30) NOT NULL,
	PRIMARY KEY(OrderID)
);

CREATE TABLE family(
	FamilyID int NOT NULL AUTO_INCREMENT,
	Family varchar(30) NOT NULL,
	PRIMARY KEY(FamilyID)
);

CREATE TABLE lookupFamily(
	FamilyID int NOT NULL,
	SpeciesID int NOT NULL,
	PRIMARY KEY(FamilyID,SpeciesID),
	FOREIGN KEY(FamilyID) REFERENCES family(FamilyID) ON DELETE RESTRICT,
	FOREIGN KEY(SpeciesID) REFERENCES species(SpeciesID) ON DELETE RESTRICT
);

CREATE TABLE lookupOrder(
	OrderID int NOT NULL,
	FamilyID int NOT NULL,
	PRIMARY KEY(FamilyID,OrderID),
	FOREIGN KEY(OrderID) REFERENCES orders(OrderID) ON DELETE RESTRICT,
	FOREIGN KEY(FamilyID) REFERENCES family(FamilyID) ON DELETE RESTRICT
);

CREATE TABLE localityInfo(
	LocalityID int NOT NULL,
	WaterBodyID int NOT NULL,
	Description varchar(100),
	County varchar(30),
	States varchar(2),
	PRIMARY KEY(LocalityID,WaterBodyID),
	FOREIGN KEY(LocalityID) REFERENCES localities(LocalityID) ON DELETE RESTRICT,
	FOREIGN KEY(WaterBodyID) REFERENCES waterBodies(WaterBodyID) ON DELETE RESTRICT
);
