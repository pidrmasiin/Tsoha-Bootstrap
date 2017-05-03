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
//        $vastaukset->tyhjennaNimet();

        $kysymykset = Kysymys::kaikkiIdt();
        Liitos::poista();
        $vastaukset->nimi($params['nimi']);
        foreach ($kysymykset as $id) {
            $liitokseen = array(
                'kysymys_id' => $id,
                'vastaukset_id' => $vastaukset->id,
                'vastattu' => 0
            );
            $liitos = New Liitos($liitokseen);
            $liitos->save();
        }

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
        $liitos = Liitos::vastattu($kysymys_id, $nimi);
        $kysymykset = Kysymys::kaikkiVastaamattomat();
        Redirect::to('/vastaukset/kysymykset/' . $vastaaja->id, array('kysymykset' => $kysymykset));
    }

    public static function tulokset($nimi) {
        $vastaukset = Vastaukset::find($nimi);

//        Kint::dump($puolueet);
        View::make('/vastaukset/tulokset.html', array('nimi' => $vastaukset));
    }

    public static function puolueenVastaukset($puolue, $nimi) {
        $puolueint = (int) $puolue;
//        Kint::dump($puolueint);
        $vastaukset = Tulos::allPuolue($puolueint);
        $puolueenNimi = Puolue::find($puolue)->nimi;

        View::make('/vastaukset/ilmoitus.html', array('vastaukset' => $vastaukset, 'puolue' => $puolueenNimi));
    }

}

//
//    public static function jaa($kysymys_id, $nimi) {
//
//        $vastaukset = Tulos::findJaat($kysymys_id);
//        $vastaa = New VastausController();
//        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
//    }
//
//    public static function ei($kysymys_id, $nimi) {
//        $vastaukset = Tulos::findEit($kysymys_id);
//        $vastaa = New VastausController();
//        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
//    }
//
//    public static function eos($kysymys_id, $nimi) {
//
//        $vastaukset = Tulos::findEost($kysymys_id);
//        $vastaa = New VastausController();
//        $vastaa->vastaus($kysymys_id, $nimi, $vastaukset);
//    }
//
//    public static function vastaus($kysymys_id, $nimi, $vastaukset) {
//        $vastaaja = Vastaukset::find($nimi);
//        for ($i = 0; $i < count($vastaukset); ++$i) {
//            $puolue = Puolue::find($vastaukset[$i]);
//            $aanet = $vastaaja->palautautaAanet($puolue->nimi) + 1;
//            $vastaaja->lisaaPuoleelleAani($puolue->nimi, $aanet);
//        }
//        $kysymys = Kysymys::find($kysymys_id);
//        $kysymys->lisaaVastaaja($kysymys_id);
//        $kysymykset = VastausController::kysymykset($vastaaja->id);
//        Redirect::to('/vastaukset/kysymykset/' . $vastaaja->id, array('kysymykset' => $kysymykset));
//    }
//
//    public static function tulokset($nimi) {
//
//        $vastaukset = Vastaukset::find($nimi);
//
////        Kint::dump($puolueet);
//        View::make('/vastaukset/tulokset.html', array('nimi' => $vastaukset));
//    }
//
////    public static function kysymykset($id) {
////
////        $kysymysidt = Kysymykset::find($id);
////
//////        Kint::dump($kysymysidt);
////        $kysymykset = array(Kysymys::find($kysymysidt->yksi), Kysymys::find($kysymysidt->kaksi), Kysymys::find($kysymysidt->kolme), Kysymys::find($kysymysidt->nelja), Kysymys::find($kysymysidt->viisi));
////        return $kysymykset;
////    }
////    
////        public static function nimi() {
////
////
////
////        $kysymys = Kysymys::poistaKaikkiVastaajat();
////        $alustus = Kysymys::kaikkiIdt();
////
////
////        if (count($alustus) > 5) {
////            $arvotut = array_rand($alustus, 5);
////
////            $muuttujat = array(
////                'yksi' => $alustus[$arvotut[0]],
////                'kaksi' => $alustus[$arvotut[1]],
////                'kolme' => $alustus[$arvotut[2]],
////                'nelja' => $alustus[$arvotut[3]],
////                'viisi' => $alustus[$arvotut[4]]
////            );
////
////
////
//////            $alustus[0], $alustus[1], $alustus[2], $alustus[3], $alustus[4]
////            $kysymykset = new Kysymykset($muuttujat);
////
////
////
////            $kysymysid = $kysymykset->save();
////
////            $params = $_POST;
////
////            $attribuutit = array(
////                'nimi' => $params['nimi'],
////                'kysymykset' => $kysymysid
////            );
////            $vastaukset = New Vastaukset($attribuutit);
////            $vastaukset->tyhjennaNimet();
////
////
////            $vastaukset->nimi($params['nimi'], $kysymysid);
//////        $vastaukset->lisaaKysymys(1);
////            Redirect::to('/vastaukset/kysymykset/' . $vastaukset->id);
////        } else {
////            View::make('/vastaukset/ilmoitus.html');
////        }
////    }
////        public static function naytaKysymykset($id) {
////        $vastaaja = Vastaukset::find($id);
////        Kint::dump($vastaaja);
//////        $kysymykset = $vastaaja->kysymykset;
//////        View::make('/vastaukset/vastaus.html', array('nimi' => $vastaaja, 'kysymykset' => $kysymykset));
////    }
//}
