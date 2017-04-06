CREATE TABLE Puolue(
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL
);

CREATE TABLE Kysymys(
    id SERIAL PRIMARY KEY,
    kysymys varchar(200) NOT NULL,
    istunto INTEGER NOT NULL,
    paivamaara DATE,
    linkki varchar(200) NOT NULL
);

CREATE TABLE Tulos(
    id SERIAL PRIMARY KEY, 
    puolue_id INTEGER REFERENCES Puolue(id),
    kysymys_id INTEGER REFERENCES Kysymys(id),
    tulos  varchar(10) NOT NULL,
    jaa INTEGER,
    ei INTEGER,
    tyhja INTEGER,
    poissa INTEGER
);

CREATE TABLE Vastaus(
    id SERIAL PRIMARY KEY,
    kysymys_id INTEGER REFERENCES Kysymys(id),
    vastaus varchar(10) NOT NULL
);

CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    nimi varchar(10) NOT NULL,
    salasana varchar(10) 
);


    
