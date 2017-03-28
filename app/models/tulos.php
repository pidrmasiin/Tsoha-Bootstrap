<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tulos extends BaseModel {

    // Attribuutit
    public $id, $puolue_id, $kysymys_id, $tulos, $jaa, $ei, $tyhja, $poissa;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Toi DB on tässä luokka, jonka metodit löytyy libin alta
        $query = DB::connection()->prepare('SELECT * FROM Tulos');
        // toi nää pari metodia löytyy PDA-kirjastosta, johon tää DB:n connection metodi tän liitti
        $query->execute();
        $rows = $query->fetchAll();
        $tulokset = array();


        foreach ($rows as $row) {
 
            $tulokset[] = new Tulos(array(
                'id' => $row['id'],
                'puolue_id' => $row['puolue_id'],
                'kysymys_id' => $row['kysymys_id'],
                'tulos' => $row['tulos'],
                'jaa' => $row['jaa'],
                'ei' => $row['ei'],
                'tyhja' => $row['tyhja'],
                'poissa' => $row['poissa']
            ));
        }

        return $tulokset;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kysymys WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tulokset = new Tulos(array(
                'id' => $row['id'],
                'puolue_id' => $row['puolue_id'],
                'kysymys_id' => $row['kysymys_id'],
                'tulos' => $row['tulos'],
                'jaa' => $row['jaa'],
                'ei' => $row['ei'],
                'tyhja' => $row['tyhja'],
                'poissa' => $row['poissa']
            ));

            return $tulokset;
        }

        return null;
    }

}
