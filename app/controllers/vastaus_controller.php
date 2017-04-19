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

        $kysymys = Kysymys::poistaKaikkiVastaajat();
        $kysymykset = Kysymys::kaikkiIdt();

        $vastaukset->nimi($params['nimi']);
//        $vastaukset->lisaaKysymys(1);
//        Kint::dump($vastaukset);



        Redirect::to('/vastaukset/kysymykset/' . $vastaukset->id);
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

    public static function jaa($kysymys_id, $nimi) {

        $vastaukset = Tulos::findJaat($kysymys_id);
        $vastaa = New VastausController();
        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
    }

    public static function ei($kysymys_id, $nimi) {
        $vastaukset = Tulos::findEit($kysymys_id);
        $vastaa = New VastausController();
        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
    }

    public static function eos($kysymys_id, $nimi) {

        $vastaukset = Tulos::findEost($kysymys_id);
        $vastaa = New VastausController();
        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
    }

    public static function vastaus($kysymys_id, $nimi, $vastaukset) {
        $vastaaja = Vastaukset::find($nimi);
        for ($i = 0; $i < count($vastaukset); ++$i) {
            $puolue = Puolue::find($vastaukset[$i]);
            $aanet = $vastaaja->palautautaAanet($puolue->nimi) + 1;
            $vastaaja->lisaaPuoleelleAani($puolue->nimi, $aanet);
        }
        $kysymys = Kysymys::find($kysymys_id);
        $kysymys->lisaaVastaaja($kysymys_id);
        $kysymykset = Kysymys::all();
        Redirect::to('/vastaukset/kysymykset/' . $vastaaja->id, array('kysymykset' => $kysymykset));
    }
    
    public static function tulokset($nimi) {

        $vastaukset = Vastaukset::find($nimi);
        
//        Kint::dump($puolueet);
        View::make('/vastaukset/tulokset.html', array('nimi'=>$vastaukset));
    }

}
