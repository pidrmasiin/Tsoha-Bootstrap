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



    public static function lisaaTulos() {
        View::make('tulokset/uusiTulos.html');
    }

    public static function lisatty() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        $attribuutit = array(
            'puolue_id' => $params['puolue_id'],
            'kysymys_id' => $params['kysymys_id'],
            'tulos' => $params['tulos'],
            'jaa' => $params['jaa'],
            'ei' => $params['ei'],
            'tyhja' => $params['tyhja'],
            'poissa' => $params['poissa']
        );
        $array = array_values($attribuutit);
        $errors = array();
        $tulos = New Tulos($attribuutit);

        for ($i = 0; $i < count($array); ++$i) {
            $joku = $array[$i];
            if ($joku == '' || $joku == null) {
                array_push($errors, $joku);
            }
        }

        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $tulos->save();

            Redirect::to('/kysymykset');
        } else {
            // Pelissä oli jotain vikaa :(

            View::make('tulokset/uusiTulos.html', array('attributes' => $attribuutit, 'errors' => $errors));
        }
    }

    public static function naytaTulokset($id) {
        $kysymys = Kysymys::find($id);
        $tulokset = Tulos::all();
        View::make('tulokset/tulosPuolueittain.html', array('tulokset' => $tulokset, 'kysymys' => $kysymys));
    }

    public static function ilmoitus() {
        View::make('tulokset/ilmoitus.html');
    }

}
