<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  echo 'Tämä on etusivu!';
        View::make('aloitus.html');
    }
    
     public static function esittely(){
      // Testaa koodiasi täällä
      View::make('esittely.html');
    }
    
    public static function hallinto(){
      // Testaa koodiasi täällä
      View::make('hallinto.html');
    }
    
    public static function tulosPuolueittain(){
      // Testaa koodiasi täällä
      View::make('tulosPuolueittain.html');
    }
    
    public static function lisaaKysymys(){
      // Testaa koodiasi täällä
      View::make('uusiKysymys.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
  }
