<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VastausController extends BaseController {

    public static function nimi() {

        $params = $_POST;

        $attribuutit = array(
            'nimi' => $params['nimi']
        );
        $vastaukset = New Vastaukset($attribuutit);
//        $vastaukset->tyhjennaNimet();
        $vastaukset->nimi($params['nimi']);


        $kysymykset = Kysymys::all();

        if (count($kysymykset) > 10) {
            $kysymykset = array_rand($kysymykset, 10);
        }


        Redirect::to('/vastaukset/kysymykset', array('nimi' => $params['nimi'], 'kysymykset' => $kysymykset));
    }

    public static function naytaKysymykset() {
        View::make('/vastaukset/vastaus.html');
    }

    public static function jaa($kysymys, $nimi) {
        $vastaukset = Tulos::findByKysymys($kysymys);

        for ($i = 0; $i < count($vastaukset); ++$i) {
            if ($vastaukset[$i]['tulos'] == 'jaa'){
                $puolue = $vastaukset[$i]['puolue'];
                
            }
        }

        View::make('/vastaukset/vastaus.html');
    }

}
