<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kysymykset extends BaseModel {

// Attribuutit
    public $id, $yksi, $kaksi, $kolme, $nelja, $viisi;

// Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_sisalto');
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kysymykset (yksi, kaksi, kolme, nelja, viisi) VALUES (:yksi, :kaksi, :kolme, :nelja, :viisi) RETURNING id');
        $query->execute(array('yksi' => $this->yksi, 'kaksi' => $this->kaksi, 'kolme' => $this->kolme, 'nelja' => $this->nelja, 'viisi' => $this->viisi));
        $row = $query->fetch();
        $this->id = $row['id'];
        return $row['id'];
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kysymykset WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tulokset = new Kysymykset(array(
                'id' => $row['id'],
                'yksi' => $row['yksi'],
                'kaksi' => $row['kaksi'],
                'kolme' => $row['kolme'],
                'nelja' => $row['nelja'],
                'viisi' => $row['viisi'],
            ));

            return $tulokset;
        }

        return null;
    }
    
    public static function poistaKaikki() {
        $query = DB::connection()->prepare('DELETE FROM Kysymykset');
        $query->execute();
    }


}
