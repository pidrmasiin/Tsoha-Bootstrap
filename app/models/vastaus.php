<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vastaukset extends BaseModel {

// Attribuutit
    public $id, $nimi, $kysymykset, $keskusta, $sdp, $kokoomus, $rkp, $persut, $vihreat, $kd, $vasemmisto;

// Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_sisalto');
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Vastaukset WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tulokset = new Vastaukset(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kysymyḱset' => $row['kysymykset'],
                'keskusta' => $row['keskusta'],
                'sdp' => $row['sdp'],
                'kokoomus' => $row['kokoomus'],
                'rkp' => $row['rkp'],
                'persut' => $row['persut'],
                'vihreat' => $row['vihreat'],
                'kd' => $row['kd'],
                'vasemmisto' => $row['vasemmisto']
                    
            ));

            return $tulokset;
        }

        return null;
    }
    
    public function nimi($nimi) {
// Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Vastaukset (nimi, keskusta, sdp, kokoomus, rkp, persut, vihreat, kd, vasemmisto) VALUES (:nimi, 0, 0, 0, 0, 0, 0, 0, 0) RETURNING id');
// Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('nimi' => $this->nimi));
//                , k => $this->keskusta, 0 => $this->sdp, 0 => $this->kokoomus, 0 => $this->rkp, 0 => $this->persut, 0 => $this->kd, 0 => $this->vasemmisto));
// Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
//        Kint::trace();
//        Kint::dump($row);
// Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }
    
    public function palautautaAanet($puolue) {
        $query = DB::connection()->prepare('SELECT ' . $puolue .' FROM Vastaukset');
        $query->execute();
        $row = $query->fetch();

        if ($row) {
            
            return $this->$puolue;
        }return null;
    }
    
    public function tyhjennaNimet() {
        $query = DB::connection()->prepare('DELETE FROM Vastaukset');
        $query->execute();
        
    }
    
    public function lisaaPuoleelleAani($puolue, $arvo) {
        $query = DB::connection()->prepare("UPDATE Vastaukset SET " . $puolue ." = ". $arvo);
        $query->execute();
       
    }
    
//    public function lisaaKysymys($kysymys) {
//        $query = DB::connection()->prepare("UPDATE Vastaukset SET kysymykset =  array_replace(kysymykset, (CAST (". $kysymys ." AS integer)))");
//        $query->execute();
//       
//    }
 

}
