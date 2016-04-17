
USE homestead;

########################### USERS TABLE ##############################
CREATE TABLE users (
	id INT(11) AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
	email VARCHAR(150) NOT NULL,
    pass VARCHAR(70) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	address1 VARCHAR(255) NOT NULL,
	address2 VARCHAR(100) NOT NULL,
	city VARCHAR(100) NOT NULL,
	state VARCHAR(100) NOT NULL,
	zipcode VARCHAR(20) NOT NULL,
	country VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY(email),
    UNIQUE KEY(phone)
);

########################### CONTACTS TABLE ##############################
 CREATE TABLE contacts (
	id INT(11) AUTO_INCREMENT NOT NULL,
    uid INT(11) NOT NULL,
    cid INT(11) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
	PRIMARY KEY(id),
    UNIQUE KEY `Connected_Contact` (uid,cid)
 );
 
 ########################### PAYMENT CARDS TABLE ##############################
 
 CREATE TABLE cards (
		id INT(11) AUTO_INCREMENT NOT NULL,
		uid INT(11) NOT NULL,
		CardName VARCHAR(255) NOT NULL,
		CardNumber VARCHAR(50) NOT NULL,
		acquiringBin VARCHAR(30) NOT NULL,
		acquirerCountryCode INT(5) NOT NULL,
        expirationData VARCHAR(15) NOT NULL,
        currencyCode INT(5) NOT NULL,
        created_at DATETIME NOT NULL,
    	updated_at DATETIME NOT NULL,
        PRIMARY KEY(id),
		UNIQUE KEY (CardNumber)
 );
 
 ########################### PAYMENT TOKENS TABLE ##############################
 # THESE ARE UNIQUE TOKENS FOR SENDING PAYMENT REQUESTS AND TRACKING WHICH "TOKENS" ARE EFFECTIVE FOR Donations for example.alter
 # THIS IS AFTER BASIC IMPLEMENTATION
    
    