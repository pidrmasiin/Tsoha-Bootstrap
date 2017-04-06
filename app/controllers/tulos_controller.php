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
        $array = array_values($attribuutit);
        $errors = array();
        $tulos = New Tulos($attribuutit);

        for ($i = 0; $i < count($array); ++$i) {
            $joku = $array[$i];
            if ($joku == '' || $joku == null) {
                array_push($errors, $joku);
            }
        }
        $joku = $attribuutit['kysymys_id'];
        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $tulos->save();

            Redirect::to('/kysymykset/' . $joku);
        } else {
            // Pelissä oli jotain vikaa :(

            View::make('tulokset/uusiTulos.html', array('attributes' => $attribuutit, 'errors' => $errors, 'kysymys' => $joku));
        }
    }

    public static function naytaTulokset($id) {
        $kysymys = Kysymys::find($id);
        $tulokset = Tulos::all();
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
        $array = array_values($attribuutit);
        $errors = array();
        
        $tulos = New Tulos($attribuutit);

        for ($i = 0; $i < count($array); ++$i) {
            $joku = $array[$i];
            if ($joku == '' || $joku == null) {
                array_push($errors, $joku);
            }
        }
        if( !is_numeric($params['jaa']) || !is_numeric($params['ei']) || !is_numeric($params['tyhja']) || !is_numeric($params['poissa'])){
            array_push($errors, $joku);
        }
        $joku = $attribuutit['kysymys_id'];
        $jaa = $params['jaa'];
        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $tulos->paivita($id);

            Redirect::to('/kysymykset/' . $joku);
        } else {
            // Pelissä oli jotain vikaa :(

            View::make('tulokset/muokkaaTulosta.html', array('attributes' => $tulos, 'errors' => $errors, 'kysymys' => $joku));
        }
    }

    public static function tulos($tulos) {
        if ($tulos == 'jaa' || $tulos == 'ei' || $tulos == 'eos') {
            return $tulos;
        } else {
            return null;
        }
    }

    

}
