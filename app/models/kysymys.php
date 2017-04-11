<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kysymys extends BaseModel {

    // Attribuutit
    public $id, $kysymys, $istunto, $paivamaara, $linkki;

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
                'linkki' => $row['linkki']
            ));
        }

        return $kysymykset;
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Kysymys (kysymys, istunto, paivamaara, linkki) VALUES (:kysymys, :istunto, :paivamaara, :linkki) RETURNING id');
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
                'linkki' => $row['linkki']
            ));

            return $kysymys;
        }

        return null;
    }
    
    public function poista($id) {
        $query = DB::connection()->prepare('DELETE FROM Kysymys WHERE id ='. $id);
        $query->execute();
        
    }

  
    

}
