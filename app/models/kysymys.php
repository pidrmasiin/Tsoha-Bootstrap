<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kysymys extends BaseModel {

    // Attribuutit
    public $id, $kysymys, $istunto, $paivamaara, $linkki, $vastaaja;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Kysymys');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $kysymykset = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $kysymykset[] = new Kysymys(array(
                'id' => $row['id'],
                'kysymys' => $row['kysymys'],
                'istunto' => $row['istunto'],
                'paivamaara' => $row['paivamaara'],
                'linkki' => $row['linkki'],
                'vastaaja' => $row['vastaaja']
            ));
        }

        return $kysymykset;
    }

    public static function kaikkiIdt() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Kysymys');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $idt = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            array_push($idt, $row['id']);
        }

        return $idt;
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Kysymys (kysymys, istunto, paivamaara, linkki, vastaaja) VALUES (:kysymys, :istunto, :paivamaara, :linkki, FALSE) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('kysymys' => $this->kysymys, 'istunto' => $this->istunto, 'paivamaara' => $this->paivamaara, 'linkki' => $this->linkki));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
//        Kint::trace();
//        Kint::dump($row);
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kysymys WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kysymys = new Kysymys(array(
                'id' => $row['id'],
                'kysymys' => $row['kysymys'],
                'istunto' => $row['istunto'],
                'paivamaara' => $row['paivamaara'],
                'linkki' => $row['linkki'],
                'vastaaja' => $row['vastaaja']
            ));

            return $kysymys;
        }

        return null;
    }

    public function poista($id) {
        $query = DB::connection()->prepare('DELETE FROM Kysymys WHERE id =' . $id);
        $query->execute();
    }

    public function lisaaVastaaja($kysymys_id) {

        $query = DB::connection()->prepare('UPDATE Kysymys SET vastaaja = TRUE WHERE id = ' . $kysymys_id);
        $query->execute();
    }
    
    public static function poistaKaikkiVastaajat() {

        $query = DB::connection()->prepare('UPDATE Kysymys SET vastaaja = FALSE');
        $query->execute();
        return TRUE;
    }

}
