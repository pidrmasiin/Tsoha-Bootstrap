<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KysymysController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $kysymykset = Kysymys::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('kysymys/uusiKysymys.html', array('kysymykset' => $kysymykset));
    }

    public static function lisaaKysymys() {
        // Testaa koodiasi täällä
        View::make('kysymys/uusiKysymys.html');
    }

}
