<?php

$routes->get('/', function() {
    HallintoController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HallintoController::sandbox();
});

$routes->get('/esittely', function() {
    HallintoController::esittely();
});

$routes->get('/hallinto', function() {
    HallintoController::hallinto();
});

$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    HallintoController::login();
});

$routes->post('/login', function() {
    // Kirjautumisen käsittely
    HallintoController::handle_login();
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

$routes->get('/poistaKysymys/:id', function($id) {
    KysymysController::varmistus($id);
});

$routes->post('/poistaKysymys/:id/poista', function($id) {
    KysymysController::poista($id);
});

//TulosController:: ALLA

$routes->get('/kysymykset/:id', function($id) {
    TulosController::naytaTulokset($id);
});

$routes->get('/lisaaVastaus/:id', function($id) {
    TulosController::lisaaTulos($id);
});

$routes->post('/lisaaVastaus', function() {
    TulosController::lisatty();
});


$routes->get('/poistaTulos/:tulosid', function($tulosid) {
    TulosController::ilmoitus($tulosid);
});

$routes->post('/poistaTulos/:tulosid/poista', function($tulosid) {
    TulosController::poista($tulosid);
});

$routes->get('/muokkaaVastausta/:id', function($id) {
    TulosController::muokkaa($id);
});

$routes->post('/paivita/:id', function($id) {
    TulosController::paivita($id);
});

//VastausController:: ALLA

$routes->post('/vastaus', function() {
    VastausController::nimi();
});

$routes->get('/vastaus/:id', function($id) {
    VastausController::naytaKysymys($id);
});


