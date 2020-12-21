<?php
require_once('../models/gericht.php');
require_once('../models/allergene.php');
/* Datei: controllers/HomeController.php */
class HomeController
{
    public function index(RequestData $request) {
        $logger = logger();
        $logger->info("zugriff hauptseite");
        $gerichte = db_gericht_alle_gerichte_allergenen();
        $allergene = db_allergen_select_all();
        return view('home', ['rd' => $request, 'gerichte' => $gerichte, 'allergene' => $allergene]);
    }
}