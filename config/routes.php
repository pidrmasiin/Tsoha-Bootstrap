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
  
  $routes->get('/tiettyVastaus', function() {
    HelloWorldController::tulosPuolueittain();
  });
  
  $routes->get('/lisaaKysymys', function() {
    HelloWorldController::lisaaKysymys();
  });
