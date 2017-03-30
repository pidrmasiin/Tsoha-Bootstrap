<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KysymysController extends BaseController {

    public static function lisaaKysymys() {
        View::make('kysymys/uusiKysymys.html');
    }

    public static function ilmoitus() {
        View::make('kysymys/ilmoitus.html');
    }

    public static function lisatty() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $kysymys = new Kysymys(array(
            'kysymys' => $params['kysymys'],
            'istunto' => $params['istunto'],
            'paivamaara' => $params['paivamaara'],
            'linkki' => $params['linkki']
        ));

//        Kint::dump($params);
        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $kysymys->save();

//        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/lisaaKysymys/lisatty');
    }

//    public static function index() {
//        // Haetaan kaikki pelit tietokannasta
//        $kysymykset = Kysymys::all();
//        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
//        View::make('kysymys/uusiKysymys.html', array('kysymykset' => $kysymykset));
//    }

}
