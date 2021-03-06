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
        $this->validators = array('validate_sisalto');
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

    public static function allPuolue($puolue_id) {
// Toi DB on tässä luokka, jonka metodit löytyy libin alta
        $query = DB::connection()->prepare('SELECT Tulos.tulos, Kysymys.kysymys FROM Tulos RIGHT JOIN Kysymys ON Tulos.kysymys_id = Kysymys.id WHERE puolue_id = :puolue_id');
// toi nää pari metodia löytyy PDA-kirjastosta, johon tää DB:n connection metodi tän liitti
        $query->execute(array('puolue_id' => $puolue_id));
        $rows = $query->fetchAll();
        $tulokset = array();


        foreach ($rows as $row) {

            $tulokset[] = (array(
                'tulos' => $row['tulos'],
                'kysymys' => $row['kysymys']
//                'id' => $row['id'],
//                'puolue_id' => $row['puolue_id'],
//                'kysymys_id' => $row['kysymys_id'],
//                'tulos' => $row['tulos'],
//                'jaa' => $row['jaa'],
//                'ei' => $row['ei'],
//                'tyhja' => $row['tyhja'],
//                'poissa' => $row['poissa']
            ));
        }

        return $tulokset;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE id = :id LIMIT 1');
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

    public static function kaikkiKysymyksenPuolueet($kysymys_id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE kysymys_id = :kysymys_id');
        $query->execute(array('kysymys_id' => $kysymys_id));
        $rows = $query->fetchAll();
        $idt = array();

        foreach ($rows as $row) {
            array_push($idt, $row['puolue_id']);
        }

        return $idt;
    }

    public static function findByKysymys($kysymys_id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE kysymys_id = :kysymys_id');
        $query->execute(array('kysymys_id' => $kysymys_id));
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

    public function save() {
// Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Tulos (puolue_id, kysymys_id, tulos, jaa, ei, tyhja, poissa) VALUES (:puolue_id, :kysymys_id, :tulos, :jaa, :ei, :tyhja, :poissa) RETURNING id');
// Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('puolue_id' => $this->puolue_id, 'kysymys_id' => $this->kysymys_id, 'tulos' => $this->tulos, 'jaa' => $this->jaa, 'ei' => $this->ei, 'tyhja' => $this->tyhja, 'poissa' => $this->poissa));
// Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
//        Kint::trace();
//        Kint::dump($row);
// Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }

    public function poista($tulosid) {
        $query = DB::connection()->prepare('DELETE FROM Tulos WHERE id =' . $tulosid);
        $query->execute();
    }

    public function paivita($id) {

        $query = DB::connection()->prepare('UPDATE Tulos SET puolue_id = :puolue_id, kysymys_id = :kysymys_id, tulos = :tulos, jaa = :jaa, ei = :ei, tyhja = :tyhja, poissa = :poissa WHERE id = ' . $id);
        $query->execute(array('puolue_id' => $this->puolue_id, 'kysymys_id' => $this->kysymys_id, 'tulos' => $this->tulos, 'jaa' => $this->jaa, 'ei' => $this->ei, 'tyhja' => $this->tyhja, 'poissa' => $this->poissa));
    }

    public static function findJaat($kysymys_id) {

        $query = DB::connection()->prepare("SELECT * FROM Tulos WHERE kysymys_id = :kysymys_id AND tulos ='jaa'");
        $query->execute(array('kysymys_id' => $kysymys_id));
        $rows = $query->fetchAll();
        $puolueet = array();


        foreach ($rows as $row) {

            array_push($puolueet, $row['puolue_id']);
        }

        return $puolueet;
    }

    public static function findEit($kysymys_id) {

        $query = DB::connection()->prepare("SELECT * FROM Tulos WHERE kysymys_id = :kysymys_id AND tulos ='ei'");
        $query->execute(array('kysymys_id' => $kysymys_id));
        $rows = $query->fetchAll();
        $puolueet = array();


        foreach ($rows as $row) {

            array_push($puolueet, $row['puolue_id']);
        }

        return $puolueet;
    }

    public static function findEost($kysymys_id) {

        $query = DB::connection()->prepare("SELECT * FROM Tulos WHERE kysymys_id = :kysymys_id AND tulos ='eos'");
        $query->execute(array('kysymys_id' => $kysymys_id));
        $rows = $query->fetchAll();
        $puolueet = array();


        foreach ($rows as $row) {

            array_push($puolueet, $row['puolue_id']);
        }

        return $puolueet;
    }

}
