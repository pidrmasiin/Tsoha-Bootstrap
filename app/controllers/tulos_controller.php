<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TulosController extends BaseController {

    public static function index() {
        $tulokset = Tulos::all();
        
        View::make('tulos/tulosPuolueittain.html', array('tulokset' => $tulokset));
    }

    public static function lisaaKysymys() {
        View::make('tulos/tulosPuolueittain.html');
    }

}
