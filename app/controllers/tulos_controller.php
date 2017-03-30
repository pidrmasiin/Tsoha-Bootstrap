<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TulosController extends BaseController {

//    public static function lisaaTulos() {
//        View::make('tulokset/tulosPuolueittain.html');
//    }

    public static function naytaTulokset() {
        $tulokset = Tulos::all();
        View::make('tulokset/tulosPuolueittain.html', array('tulokset' => $tulokset));
    }
    
    public static function lisaaTulos() {
        View::make('tulokset/uusiTulos.html');
    }
    
    public static function lisatty() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        
        $tulos = new Tulos(array(
            'puolue_id' => $params['puolue_id'],
            'kysymys_id' => $params['kysymys_id'],
            'tulos' => $params['tulos'],
            'jaa' => $params['jaa'],
            'ei' => $params['ei'],
            'tyhja' => $params['tyhja'],
            'poissa' => $params['poissa']
        ));

        $tulos->save();


        Redirect::to('/tiettyVastaus/lisatty');
    }
    
    public static function ilmoitus() {
        View::make('tulokset/ilmoitus.html');
    }


}
