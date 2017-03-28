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
    
    

}
