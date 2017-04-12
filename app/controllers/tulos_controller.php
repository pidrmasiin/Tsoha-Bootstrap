<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TulosController extends BaseController {

    public static function lisaaTulos($id) {
        $kysymys = Kysymys::find($id);

        View::make('tulokset/uusiTulos.html', array('kysymys' => $kysymys));
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
        $tulos = New Tulos($attribuutit);
        $errors = TulosController::virheet($attribuutit);
        $joku = $attribuutit['kysymys_id'];
        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $tulos->save();

            Redirect::to('/kysymykset/' . $joku);
        } else {
            // Pelissä oli jotain vikaa :(
//
//            View::make('tulokset/uusiTulos.html', array('attributes' => $attribuutit, 'errors' => $errors, 'kysymys' => $joku));
            Redirect::to('/lisaaVastaus/' . $joku, array('errors' => $errors), array('attributes' => $attribuutit));
        }
    }

    public static function naytaTulokset($id) {
        $kysymys = Kysymys::find($id);
        if(Tulos::all() !== NULL){
        $tulokset = Tulos::all();
        }
        View::make('tulokset/tulosPuolueittain.html', array('tulokset' => $tulokset, 'kysymys' => $kysymys));
    }

    public static function poista($tulosid) {
        $tulos = Tulos::find($tulosid);
        $tulokset = (array) $tulos;
        $kysymys = $tulokset['kysymys_id'];
        $tulos->poista($tulosid);
        Redirect::to('/kysymykset/' . $kysymys);
    }

    public static function ilmoitus($tulosid) {
        $tulos = Tulos::find($tulosid);
        View::make('tulokset/ilmoitus.html', array('tulos' => $tulos));
    }

    public static function muokkaa($id) {
        $tulos = Tulos::find($id);
        View::make('tulokset/muokkaaTulosta.html', array('tulos' => $tulos));
    }

    public static function paivita($id) {
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
        $tulos = New Tulos($attribuutit);
        $errors = TulosController::virheet($attribuutit);

        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $tulos->paivita($id);

            Redirect::to('/kysymykset/' . $params['kysymys_id']);
        } else {
            // Pelissä oli jotain vikaa :(

            Redirect::to('/muokkaaVastausta/' . $id, array('errors' => $errors));
//                    ,'tilsu' == $tulos, 'jaa' == $jaa, 'ei' == $ei, 'poissa' == $poissa);
        }
    }

    public static function virheet($attribuutit) {
        $errors = array();

        if (!is_numeric($attribuutit['kysymys_id'])) {
            array_push($errors, 'kysymys_id');
        }if (!is_numeric($attribuutit['puolue_id'])) {
            array_push($errors, 'puolue_id');
        }if (!is_numeric($attribuutit['jaa'])) {
            array_push($errors, 'jaa');
        }if (!is_numeric($attribuutit['ei'])) {
            array_push($errors, 'ei');
        }if (!is_numeric($attribuutit['tyhja'])) {
            array_push($errors, 'tyhja');
        }if (!is_numeric($attribuutit['poissa'])) {
            array_push($errors, 'poissa');
        } if ($attribuutit['tulos'] != 'jaa' && $attribuutit['tulos'] != 'ei' && $attribuutit['tulos'] != 'eos') {
            array_push($errors, 'tulos');
        }return $errors;
    }

}
