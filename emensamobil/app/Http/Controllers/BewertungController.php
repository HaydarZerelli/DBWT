<?php


namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BewertungController extends BaseController
{
    function show(Request $rd) {

        if (!session('auth_token')) {
            return redirect()->to('/');
        } else {
            $data = DB::select("SELECT name, bildname FROM gericht WHERE id=?", [$rd->query('gerichtid')]);

            return view('bewertung', ['request' => $rd, 'data' => $data]);
        }
    }

    function rate(Request $rd) {

        $kommentar = filter_var($rd->input('kommentar'), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $sterne = filter_var( $rd->input('sterne'), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        if (is_numeric($rd->input('id'))) {
            $gerichtid = $rd->input('id');
        }


        $benutzerid = DB::select("SELECT id FROM benutzer WHERE auth_token=?", [session('auth_token')]);

        $benutzerid = $benutzerid[0]->id;

        DB::insert('INSERT INTO bewertungen (sterne, bemerkung, benutzerid, gerichtid) VALUES (?,?,?,?);',
            [$sterne, $kommentar, $benutzerid, $gerichtid]);

        return redirect()->to('/');
    }

    function zeigeAlle(Request $rd) {
        $data = DB::select("SELECT * from bewertungen ORDER BY bewertungszeitpunkt DESC LIMIT 30");
        return view('bewertungen', ['bewertungen' => $data]);
    }

    function zeigeMeine(Request $rd) {
        $benutzerid = DB::select("SELECT id FROM benutzer WHERE auth_token=?", [session('auth_token')]);
        $benutzerid = $benutzerid[0]->id;
        $bewertungen = DB::select("SELECT * FROM bewertungen WHERE benutzerid=? ORDER BY bewertungszeitpunkt DESC", [$benutzerid]);
        return view('meine_bewertungen', ['bewertungen' => $bewertungen]);
    }

    function loeschen(Request $rd) {
        $res = DB::delete("delete from bewertungen where id=?", [$rd->input('id')]);
        return redirect()->to('meine_bewertungen');
    }
}
