<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//HallintoController ALLA

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

$routes->post('/logout', function() {
    HallintoController::logout();
});

//KysymysController:: ALLA

$routes->get('/lisaaKysymys', 'check_logged_in', function() {
    KysymysController::lisaaKysymys();
});

$routes->post('/lisaaKysymys', 'check_logged_in', function() {
    KysymysController::lisatty();
});

$routes->get('/lisaaKysymys/lisatty', 'check_logged_in', function() {
    KysymysController::ilmoitus();
});

$routes->get('/kysymykset', 'check_logged_in', function() {
    KysymysController::naytaKysymykset();
});

$routes->get('/poistaKysymys/:id', 'check_logged_in', function($id) {
    KysymysController::varmistus($id);
});

$routes->post('/poistaKysymys/:id/poista', 'check_logged_in', function($id) {
    KysymysController::poista($id);
});

//TulosController:: ALLA

$routes->get('/kysymykset/:id', 'check_logged_in', function($id) {
    TulosController::naytaTulokset($id);
});

$routes->get('/lisaaVastaus/:id', 'check_logged_in', function($id) {
    TulosController::lisaaTulos($id);
});

$routes->post('/lisaaVastaus', 'check_logged_in', function() {
    TulosController::lisatty();
});


$routes->get('/poistaTulos/:tulosid', 'check_logged_in', function($tulosid) {
    TulosController::ilmoitus($tulosid);
});

$routes->post('/poistaTulos/:tulosid/poista', 'check_logged_in',  function($tulosid) {
    TulosController::poista($tulosid);
});

$routes->get('/muokkaaVastausta/:id', 'check_logged_in', function($id) {
    TulosController::muokkaa($id);
});

$routes->post('/paivita/:id', 'check_logged_in', function($id) {
    TulosController::paivita($id);
});

//VastausController:: ALLA

$routes->post('/vastaus', function() {
    VastausController::nimi();
});

$routes->get('/vastaukset/kysymykset/:id', function($id) {
    VastausController::naytaKysymykset($id);
});

$routes->get('/vastaus/:kysymys/jaa/:nimi', function($kysymys, $nimi) {
    VastausController::jaa($kysymys, $nimi);
});

$routes->get('/vastaus/:kysymys/eos/:nimi', function($kysymys, $nimi) {
    VastausController::eos($kysymys, $nimi);
});

$routes->get('/vastaus/:kysymys/ei/:nimi', function($kysymys, $nimi) {
    VastausController::ei($kysymys, $nimi);
});

$routes->get('/vastaukset/:nimi', function($nimi) {
    VastausController::tulokset($nimi);
});




