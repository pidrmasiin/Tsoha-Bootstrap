<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KysymysController extends BaseController {

    public static function naytaKysymykset() {
        $kysymykset = Kysymys::all();
        View::make('kysymys/kysymykset.html', array('kysymykset' => $kysymykset));
    }

    public static function lisaaKysymys() {
        View::make('kysymys/uusiKysymys.html');
    }

    public static function varmistus($id) {
        $kysymys = Kysymys::find($id);
        View::make('kysymys/ilmoitus.html', array('kysymys' => $kysymys));
    }

    public static function lisatty() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $attribuutit = array(
            'kysymys' => $params['kysymys'],
            'istunto' => $params['istunto'],
            'paivamaara' => $params['paivamaara'],
            'linkki' => $params['linkki']
        );
        $kysymys = New Kysymys($attribuutit);
        $errors = array();
        if (!is_string($params['kysymys'])){
            array_push($errors, $params['kysymys']);
        }if (!is_numeric($params['istunto'])){
            array_push($errors, $params['istunto']);
//        }if (count($params['paivamaara']) != 10){
//            array_push($errors, $params['paivamaara']);
        }if (!is_string($params['linkki'])){
            array_push($errors, $params['linkki']);
        }
           
         if (count($errors) == 0){   
        $kysymys->save();
        Redirect::to('/kysymykset/' . $kysymys->id);
         }else {
              Redirect::to('/lisaaKysymys', array('errors' => $errors, 'attribuutit' => $attribuutit));
         }
    }

//    public static function index() {
//        // Haetaan kaikki pelit tietokannasta
//        $kysymykset = Kysymys::all();
//        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
//        View::make('kysymys/uusiKysymys.html', array('kysymykset' => $kysymykset));
//    }
    public static function poista($id) {
        $kysymys = Kysymys::find($id);
        $kysymyslista = (array) $kysymys;
        $kysymys_id = $kysymyslista['id'];

        $vastaukset = Tulos::findByKysymys($kysymys_id);
        if (count($vastaukset) > 0) {
            for ($i = 0; $i < count($vastaukset); ++$i) {
                $vastaukset[$i]->poista($vastaukset[$i]->id);
            }
        }

        $kysymys->poista($id);
        Redirect::to('/kysymykset');
    }

}
