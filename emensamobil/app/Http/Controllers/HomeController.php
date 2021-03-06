<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bewertung;


class HomeController extends BaseController
{
    public function index(Request $request) {

        $logger = logger();
        $logger->info("zugriff hauptseite");
        $gerichte = DB::select("SELECT gericht.id, gericht.name, GROUP_CONCAT(gericht_hat_allergen.code) as gha_code, preis_intern, preis_extern, bildname
        FROM gericht
            LEFT JOIN gericht_hat_allergen ON gericht_hat_allergen.id = gericht.id
        GROUP BY gericht.name
        Order by gericht.name");
        $allergene = DB::select("SELECT code, name FROM allergen ORDER BY code");
        $bewertungen = Bewertung::join('gericht', 'bewertungen.gericht_id', '=', 'gericht.id')->where('hervorgehoben', true)->get();


        //$bewertungen = DB::select("select gericht.name, sterne, bemerkung from bewertungen join gericht on bewertungen.gericht_id = gericht.id where hervorgehoben=true;");
        return view('home', ['rd' => $request, 'gerichte' => $gerichte, 'allergene' => $allergene, 'session' => $request->session(), 'bewertungen' => $bewertungen]);
    }
}
