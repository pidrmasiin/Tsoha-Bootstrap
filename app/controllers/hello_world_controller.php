<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  echo 'Tämä on etusivu!';
        View::make('aloitus.html');
    }

    public static function esittely() {
        // Testaa koodiasi täällä
        View::make('esittely.html');
    }

    public static function hallinto() {
        // Testaa koodiasi täällä
        View::make('hallinto.html');
    }

  

  

    public static function sandbox() {
        $eka = Kysymys::find(1);
        $kysymykset = Kysymys::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($kysymykset);
        Kint::dump($eka);
        
    }

}
