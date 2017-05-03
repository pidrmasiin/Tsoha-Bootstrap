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
class Liitos extends BaseModel {

    // Attribuutit
    public $kysymys_id, $vastaukset_id, $vastattu;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Toi DB on tässä luokka, jonka metodit löytyy libin alta
        $query = DB::connection()->prepare('SELECT * FROM Liitos');
        // toi nää pari metodia löytyy PDA-kirjastosta, johon tää DB:n connection metodi tän liitti
        $query->execute();
        $rows = $query->fetchAll();
        $puolueet = array();


        foreach ($rows as $row) {

            $tulokset[] = new Liitos(array(
                'kysymys_id' => $row['kysymys_id'],
                'vastaukset_id' => $row['vastaukset_id'],
                'vastattu' => $row['vastattu']
            ));
        }

        return $puolueet;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Liitos (kysymys_id, vastaukset_id, vastattu) VALUES (:kysymys_id, :vastaukset_id, :vastattu)');
        $query->execute(array('kysymys_id' => $this->kysymys_id, 'vastaukset_id' => $this->vastaukset_id, 'vastattu' => $this->vastattu));
        $row = $query->fetch();
    }

    public static function vastattu($kysymys_id, $vastaukset_id) {

        $query = DB::connection()->prepare('UPDATE Liitos SET vastattu = TRUE WHERE kysymys_id = :kysymys_id AND vastaukset_id = :vastaukset_id');
        $query->execute(array('kysymys_id' => $kysymys_id, 'vastaukset_id' => $vastaukset_id));
    }
    
    public static function find($kysymys_id, $vastaukset_id) {
        $query = DB::connection()->prepare('SELECT * FROM Liitos WHERE kysymys_id = :kysymys_id AND vastaukset_id = :vastaukset_id');
        $query->execute(array('kysymys_id' => $kysymys_id, 'vastaukset_id' => $vastaukset_id));
        $row = $query->fetch();

        if ($row) {
            $kysymys = new Liitos(array(
                'kysymys_id' => $row['kysymys_id'],
                'vastaukset_id' => $row['vastaukset_id'],
                'vastattu' => $row['vastattu']
            ));

            return $kysymys;
        }

        return null;
    }
    
     public static function poista() {
        $query = DB::connection()->prepare('DELETE FROM Liitos');
        $query->execute();
    }



}
