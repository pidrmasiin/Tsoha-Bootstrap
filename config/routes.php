<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/esittely', function() {
    HelloWorldController::esittely();
});

$routes->get('/hallinto', function() {
    HelloWorldController::hallinto();
});

//KysymysController:: ALLA

$routes->get('/lisaaKysymys', function() {
    KysymysController::lisaaKysymys();
});

$routes->post('/lisaaKysymys', function() {
    KysymysController::lisatty();
});

$routes->get('/lisaaKysymys/lisatty', function() {
    KysymysController::ilmoitus();
});

$routes->get('/kysymykset', function() {
    KysymysController::naytaKysymykset();
});

//TulosController:: ALLA

$routes->get('/kysymykset/:id', function($id){
    TulosController::naytaTulokset($id);
});

$routes->get('/lisaaVastaus/:id', function($id) {
    TulosController::lisaaTulos($id);
});

$routes->post('/lisaaVastaus', function() {
    TulosController::lisatty();
});


$routes->get('/poistaTulos/:tulosid', function($tulosid){
    TulosController::ilmoitus($tulosid);
});

$routes->post('/poistaTulos/:tulosid/poista', function($tulosid){
    TulosController::poista($tulosid);
});

$routes->get('/muokkaaVastausta/:id', function($id){
    TulosController::muokkaa($id);
});

$routes->post('/paivita/:id', function($id){
    TulosController::paivita($id);
});


