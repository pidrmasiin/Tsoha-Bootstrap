-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Puolue (nimi) 
VALUES 
    ('keskusta'),
    ('sdp'), 
    ('kokoomus'), 
    ('rkp'),
    ('persut'), 
    ('vihreat'),
    ('kd'),
    ('vasemmisto');


INSERT INTO Kysymys (kysymys, istunto, paivamaara, linkki) 
VALUES 
    ('Kansalaisaloite avioliiton säilyttämisestä aidosti tasa-arvoisena, miehen ja naisen välisenä liittona ja sukupuolineutraalin avioliittolain kumoamisesta','11','2017-2-22','https://www.eduskunta.fi/FI/Vaski/sivut/aanestys.aspx?aanestysnro=1&istuntonro=11&vuosi=2017'); 

INSERT INTO Tulos (puolue_id, kysymys_id, tulos, jaa, ei ,tyhja, poissa) 
VALUES 
    ((SELECT id FROM Puolue WHERE nimi='sdp'),(SELECT id FROM Kysymys WHERE istunto='11'),'ei','17','22','0','10');

INSERT INTO Kayttaja (nimi, salasana) 
VALUES 
    ('nimi', 'salasana');


