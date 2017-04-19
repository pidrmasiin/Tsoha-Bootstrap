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
            'nimi' => $params['nimi'],
        );
        $vastaukset = New Vastaukset($attribuutit);
        $vastaukset->tyhjennaNimet();
        
        $kysymykset = Kysymys::kaikkiIdt();
        $vastaukset->nimi($params['nimi']);
        $vastaukset->lisaaKysymys(1);
        Kint::dump($vastaukset);
//        $vastaukset->lisaaKysymykset($kysymykset);


//        Redirect::to('/vastaukset/kysymykset/' . $vastaukset->id);
    }

    public static function naytaKysymykset($id) {
        $vastaaja = Vastaukset::find($id);
        $kysymykset = Kysymys::all();

//        if (count($kysymykset) > 10) {
//            $kysymykset = array_rand($kysymykset, 10);
//        }
//        Kint::dump($vastaaja);
        View::make('/vastaukset/vastaus.html', array('nimi' => $vastaaja, 'kysymykset' => $kysymykset));
    }

    public static function jaa($kysymys, $nimi) {
        $vastaaja = Vastaukset::find($nimi);
        $vastaukset = Tulos::findJaat($kysymys);
        for ($i = 0; $i < count($vastaukset); ++$i) {
            $puolue = Puolue::find($vastaukset[$i]);
            $aanet = $vastaaja->palautautaAanet($puolue->nimi) + 1;
            $vastaaja->lisaaPuoleelleAani($puolue->nimi, $aanet);
        }

        $kysymykset = Kysymys::all();
        Redirect::to('/vastaukset/kysymykset/' . $vastaaja->id, array('kysymykset' => $kysymykset));
    }

}
