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
        $vastaukset->nimi($params['nimi']);


        $kysymysIdt = Kysymys::kaikkiIdt();
        if ($kysymysIdt !== NULL){
            $luku = array_rand($kysymysIdt, 1);
        $id = $kysymysIdt[$luku];
        Redirect::to('/vastaus/' . $id, array('nimi' => $params['nimi']));
        }
        
    }

    public static function naytaKysymys($id) {
        $kysymys = Kysymys::find($id);
        View::make('/vastaukset/vastaus.html', array('kysymys' => $kysymys));
    }

}
