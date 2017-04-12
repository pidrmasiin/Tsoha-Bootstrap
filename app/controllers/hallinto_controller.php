<?php

class HallintoController extends BaseController {

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
        View::make('hallinto/hallinto.html');
    }

    public static function login() {
        // Testaa koodiasi täällä
        View::make('hallinto/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = Kayttaja::loytyyko($params['username'], $params['password']);

        if (!$user) {
            View::make('hallinto/hallinto.html', array('message' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/hallinto', array('message' => 'Tervetuloa takaisin ' . $user->nimi . '!'));
        }
    }

//    public static function sandbox() {
//        $eka = Kysymys::find(1);
//        $kysymykset = Kysymys::all();
//        // Kint-luokan dump-metodi tulostaa muuttujan arvon
//        Kint::dump($kysymykset);
//        Kint::dump($eka);
//        
//    }
}
