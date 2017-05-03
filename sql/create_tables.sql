CREATE TABLE Puolue(
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL
);



CREATE TABLE Kysymys(
    id SERIAL PRIMARY KEY,
    kysymys varchar NOT NULL,
    istunto INTEGER NOT NULL,
    paivamaara DATE,
    linkki varchar NOT NULL
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

CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    nimi varchar(10) NOT NULL,
    salasana varchar(10) 
);

CREATE TABLE Vastaukset(
    id SERIAL PRIMARY KEY,
    kysymykset INTEGER REFERENCES Kysymykset(id),
    nimi varchar(10) NOT NULL,
    keskusta INTEGER,
    sdp INTEGER,
    kokoomus INTEGER,
    rkp INTEGER,
    persut INTEGER,
    vihreat INTEGER,
    kd INTEGER,
    vasemmisto INTEGER
);

CREATE TABLE Liitos(
    kysymys_id INTEGER REFERENCES Kysymys(id),
    vastaukset_id INTEGER REFERENCES Vastaukset(id),
    vastattu BOOLEAN 
);


    
