<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of puolue
 *
 * @author petteri
 */
class Puolue extends BaseModel {

    // Attribuutit
    public $id, $nimi;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Toi DB on tässä luokka, jonka metodit löytyy libin alta
        $query = DB::connection()->prepare('SELECT * FROM Puolue');
        // toi nää pari metodia löytyy PDA-kirjastosta, johon tää DB:n connection metodi tän liitti
        $query->execute();
        $rows = $query->fetchAll();
        $puolueet = array();


        foreach ($rows as $row) {

            $tulokset[] = new Tulos(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }

        return $puolueet;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Puolue WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $puolue = new Puolue(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));

            return $puolue;
        }

        return null;
    }
    
    
    
 

}
